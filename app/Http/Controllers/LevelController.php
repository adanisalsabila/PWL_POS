<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class LevelController extends Controller
{
    // Menampilkan halaman utama Level
    public function index()
    {
        $activeMenu = 'level';
        return view('level.index', compact('activeMenu'));
    }

    // Menampilkan data Level dengan AJAX
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = LevelModel::select('level_id', 'level_kode', 'level_nama')->get();

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" onclick="editLevel(' . $row->level_id . ')" class="btn btn-warning btn-sm">Edit</a> ' .
                        '<a href="javascript:void(0)" onclick="deleteLevel(' . $row->level_id . ')" class="btn btn-danger btn-sm">Hapus</a>';
                })
                ->make(true);
        }

        return abort(404);
    }

    // Menampilkan form untuk menambah Level
    public function create()
    {
        return view('level.create');
    }

    // Menyimpan data Level baru dengan Ajax
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'level_kode' => 'required|string|max:10|unique:levels,level_kode',
            'level_nama' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $level = LevelModel::create([
                'level_kode' => $request->level_kode,
                'level_nama' => $request->level_nama,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Level berhasil ditambahkan!',
                'data' => $level,
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing level: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan level.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Menampilkan form untuk edit Level
    public function edit($id)
    {
        try {
            $level = LevelModel::findOrFail($id);  // Fetch level by ID
            return view('level.edit', compact('level'));  // Pass the level to the view
        } catch (\Exception $e) {
            return redirect()->route('level.index')->with('error', 'Level tidak ditemukan.');
        }
    }
    
    // Menampilkan data Level untuk edit dengan AJAX
    public function editAjax($id)
    {
        try {
            $level = LevelModel::findOrFail($id);  // Fetch level by ID
            return response()->json($level);  // Return data as JSON for AJAX
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Level tidak ditemukan.',
            ], 404);
        }
    }

    // Memperbarui data Level dengan Ajax
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'level_kode' => 'required|string|max:10|unique:levels,level_kode,' . $id . ',level_id',
            'level_nama' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $level = LevelModel::findOrFail($id);
            $level->update([
                'level_kode' => $request->level_kode,
                'level_nama' => $request->level_nama,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Level berhasil diperbarui!',
                'data' => $level,
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating level: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui level.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Menghapus data Level dengan Ajax
    public function destroy($id)
    {
        try {
            $level = LevelModel::findOrFail($id);
            $level->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Level berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting level: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus level.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function import()
    {
        return view('level.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_level' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_level');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'level_kode' => $value['A'],
                            'level_nama' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (!empty($insert)) {
                    LevelModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diimport'
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Tidak ada data yang diimport'
            ]);
        }

        return redirect('/');
    }

    public function export_excel()
    {
        $level = LevelModel::select('level_kode', 'level_nama')
            ->orderBy('level_kode')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Level');
        $sheet->setCellValue('C1', 'Nama Level');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($level as $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->level_kode);
            $sheet->setCellValue('C' . $baris, $value->level_nama);
            $baris++;
            $no++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Level');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Level ' . date('Y-m-d H:i:s') . ".xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $level = LevelModel::select('level_kode', 'level_nama')
            ->orderBy('level_kode')
            ->get();

        $pdf = Pdf::loadView('level.export_pdf', ['level' => $level]);

        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Level ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
