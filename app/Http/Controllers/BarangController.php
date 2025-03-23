<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    // Menampilkan halaman utama Barang
    public function index()
    {
        $kategori = KategoriModel::all(); // Mengambil data kategori

        if ($kategori->isEmpty()) {
            // Jika tidak ada kategori, bisa menampilkan pesan error atau melakukan hal lain
            return redirect()->route('kategori.index')->with('error', 'Tidak ada kategori tersedia.');
        }

        $activeMenu = 'barang'; // Menetapkan active menu
        return view('barang.index', compact('activeMenu', 'kategori'));
    }

    // Menampilkan data Barang dengan AJAX
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = BarangModel::with('kategori')
                ->select(['barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id', 'created_at', 'updated_at']);

            return DataTables::of($data)
                ->addColumn('kategori_nama', function ($row) {
                    return $row->kategori ? $row->kategori->kategori_nama : 'No Kategori';
                })
                ->addColumn('aksi', function ($row) {
                    return '<a href="javascript:void(0)" onclick="editBarang(' . $row->barang_id . ')" class="btn btn-warning btn-sm">Edit</a>' .
                        '<a href="javascript:void(0)" onclick="showBarang(' . $row->barang_id . ')" class="btn btn-info btn-sm">Detail</a>' .
                        '<a href="javascript:void(0)" onclick="confirmDelete(' . $row->barang_id . ')" class="btn btn-danger btn-sm">Hapus</a>';
                })
                ->make(true);
        }

        return abort(404);
    }

    // Menampilkan modal tambah barang dengan AJAX
    public function createAjax()
    {
        $kategori = KategoriModel::all();
        return view('barang.create_ajax', compact('kategori'));
    }

    // Menyimpan data Barang baru menggunakan Ajax
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required|string|max:50',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'kategori_id' => 'required|exists:kategori,kategori_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            $barang = BarangModel::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Barang berhasil ditambahkan!',
                'data' => $barang,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan barang: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Menampilkan modal edit barang dengan AJAX
    public function editAjax($id)
    {
        $barang = BarangModel::findOrFail($id);
        $kategori = KategoriModel::all();
        return view('barang.edit_ajax', compact('barang', 'kategori'));
    }

    // Memperbarui data Barang menggunakan Ajax
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required|string|max:50',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'kategori_id' => 'required|exists:kategori,kategori_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            $barang = BarangModel::findOrFail($id);
            $barang->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Barang berhasil diperbarui!',
                'data' => $barang,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui barang: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Menampilkan modal konfirmasi hapus barang
    public function confirmDelete($id)
    {
        return view('barang.confirm_ajax', compact('id'));
    }

    // Menghapus data Barang menggunakan Ajax
    public function destroy($id)
    {
        try {
            $barang = BarangModel::findOrFail($id);
            $barang->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Barang berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus barang: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Menampilkan modal detail barang
    public function show($id)
    {
        $barang = BarangModel::with('kategori')->findOrFail($id);
        return view('barang.show', compact('barang'));
    }
}