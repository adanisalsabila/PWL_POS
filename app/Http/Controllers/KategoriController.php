<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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

    public function edit($id)
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
}