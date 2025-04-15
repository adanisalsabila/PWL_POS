<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\KategoriModel; // Pastikan nama model sesuai
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse; // Tambahkan import
use PhpOffice\PhpSpreadsheet\IOFactory;

class KategoriController extends Controller
{
    public function index()
    {
        $activeMenu = 'kategori';
        return view('kategori.index', compact('activeMenu'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = KategoriModel::select(['kategori_id', 'kategori_kode', 'kategori_nama']);
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editRoute = route('kategori.edit', $row->kategori_id);
                    $deleteRoute = route('kategori.destroy', $row->kategori_id);

                    return '<a href="' . $editRoute . '" class="btn btn-warning btn-sm">Edit</a>
                            <form action="' . $deleteRoute . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>';
                })
                ->make(true);
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_kode' => 'required|string|unique:kategori,kategori_kode',
            'kategori_nama' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            KategoriModel::create($request->all());
            return response()->json(['success' => 'Kategori berhasil ditambahkan!']);
        } catch (\Exception $e) {
            Log::error('Error storing kategori: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat menambahkan kategori.'], 500);
        }
    }

    public function edit($id): JsonResponse
    {
        try {
            $kategori = KategoriModel::findOrFail($id);
            return response()->json($kategori);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Kategori tidak ditemukan.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kategori_kode' => 'required|string|unique:kategori,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            KategoriModel::findOrFail($id)->update($request->all());
            return response()->json(['success' => 'Kategori berhasil diperbarui!']);
        } catch (\Exception $e) {
            Log::error('Error updating kategori: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui kategori.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            KategoriModel::findOrFail($id)->delete();
            return response()->json(['success' => 'Kategori berhasil dihapus!']);
        } catch (\Exception $e) {
            Log::error('Error deleting kategori: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus kategori.'], 500);
        }
    }

    public function import()
    {
        return view('kategori.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_kategori' => ['required', 'mimes:xlsx', 'max:1024'] // Ubah nama input file
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_kategori'); // Ubah nama input file
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
                            'kategori_kode' => $value['A'], // Sesuaikan kolom
                            'kategori_nama' => $value['B'], // Sesuaikan kolom
                            'created_at'  => now(),
                        ];
                    }
                }

                if (!empty($insert)) {
                    KategoriModel::insertOrIgnore($insert);
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

        return redirect('/'); // Atau rute lain yang sesuai
    }

    public function export_excel()
    {
        // Ambil data kategori yang akan diekspor
        $kategoris = KategoriModel::all();

        // Load library Excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // Ambil sheet yang aktif

        // Set header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Kategori');
        $sheet->setCellValue('C1', 'Nama Kategori');

        // Bold header kolom
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        // Isi data kategori
        $no = 1; // Nomor data dimulai dari 1
        $baris = 2; // Baris data dimulai dari baris ke 2
        foreach ($kategoris as $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->kategori_kode);
            $sheet->setCellValue('C' . $baris, $value->kategori_nama);
            $baris++;
            $no++;
        }

        // Set auto size untuk kolom
        foreach (range('A', 'C') as $columnID) { // Sesuaikan kolom
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set title sheet
        $sheet->setTitle('Data Kategori');

        // Buat writer dan nama file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Kategori ' . date('Y-m-d H:i:s') . ".xlsx";

        // Set header HTTP untuk download file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        // Simpan file Excel ke output PHP dan keluar
        $writer->save('php://output');
        exit;

        // End function export excel
    }

    public function export_pdf()
    {
        $kategoris = KategoriModel::all();

        $pdf = Pdf::loadView('kategori.export_pdf', ['kategoris' => $kategoris]);

        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Kategori ' . date('Y-m-d H:i:s') . '.pdf');
    }
}