<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    // Menampilkan data supplier (untuk AJAX)
    public function index(Request $request)
    {
        // Menetapkan nilai aktif pada menu sidebar
        $activeMenu = 'supplier';

        // Jika permintaan adalah AJAX, kembalikan data supplier dalam format JSON
        if ($request->ajax()) {
            $suppliers = Supplier::all(); // Ambil semua data supplier
            return response()->json($suppliers); // Mengembalikan data supplier dalam format JSON
        }

        // Jika permintaan bukan AJAX, tampilkan halaman supplier index (view) dengan variabel activeMenu
        return view('supplier.index', compact('activeMenu')); // Tampilkan view supplier.index
    }

    // Menambahkan supplier baru
    public function store(Request $request)
    {
        // Validasi input dari user
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        // Buat supplier baru
        $supplier = Supplier::create($validated);

        // Jika permintaan adalah AJAX, kirimkan response JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Supplier created successfully.',
                'supplier' => $supplier,
            ]);
        }

        // Jika bukan AJAX, redirect ke halaman index dengan pesan sukses
        return redirect()->route('supplier.index')->with('success', 'Supplier created successfully.');
    }

    // Menampilkan data supplier untuk keperluan edit (AJAX)
    public function edit($id)
    {
        // Cari supplier berdasarkan ID
        $supplier = Supplier::findOrFail($id);

        // Jika permintaan adalah AJAX, kembalikan data supplier dalam format JSON
        return response()->json($supplier);
    }

    // Memperbarui data supplier
    public function update(Request $request, $id)
    {
        // Validasi input dari user
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        // Cari supplier berdasarkan ID
        $supplier = Supplier::findOrFail($id);

        // Update data supplier
        $supplier->update($validated);

        // Jika permintaan adalah AJAX, kirimkan response JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Supplier updated successfully.',
                'supplier' => $supplier,
            ]);
        }

        // Jika bukan AJAX, redirect ke halaman index dengan pesan sukses
        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
    }

    // Menghapus supplier
    public function destroy($id)
    {
        // Cari supplier berdasarkan ID
        $supplier = Supplier::findOrFail($id);

        // Hapus supplier
        $supplier->delete();

        // Jika permintaan adalah AJAX, kirimkan response JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Supplier deleted successfully.',
            ]);
        }

        // Jika bukan AJAX, redirect ke halaman index dengan pesan sukses
        return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully.');
    }
    public function import()
    {
        return view('supplier.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_supplier' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_supplier');
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
                            'name'      => $value['A'],
                            'contact'   => $value['B'],
                            'address'   => $value['C'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (!empty($insert)) {
                    Supplier::insertOrIgnore($insert);
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
        $suppliers = Supplier::all();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Supplier');
        $sheet->setCellValue('C1', 'Kontak');
        $sheet->setCellValue('D1', 'Alamat');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($suppliers as $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->name);
            $sheet->setCellValue('C' . $baris, $value->contact);
            $sheet->setCellValue('D' . $baris, $value->address);
            $baris++;
            $no++;
        }

        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Supplier');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Supplier ' . date('Y-m-d H:i:s') . ".xlsx";

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
        $suppliers = Supplier::all();

        $pdf = Pdf::loadView('supplier.export_pdf', ['suppliers' => $suppliers]);

        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Supplier ' . date('Y-m-d H:i:s') . '.pdf');
    }
}