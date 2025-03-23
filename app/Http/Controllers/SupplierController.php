<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

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
}
