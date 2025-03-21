<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\KategoriModel;

class KategoriController extends Controller
{
    public function index()
    {
        $activeMenu = 'kategori'; // Set active menu
        return view('kategori.index', compact('activeMenu')); // Pass active menu to the view
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            // Explicitly select the columns needed
            $data = KategoriModel::select(['kategori_id', 'kategori_kode', 'kategori_nama']);
            
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    // Add action buttons for editing and deleting
                    $editRoute = route('kategori.edit', $row->kategori_id);
                    $deleteRoute = route('kategori.destroy', $row->kategori_id);

                    return '<a href="'.$editRoute.'" class="btn btn-warning btn-sm">Edit</a>
                            <form action="'.$deleteRoute.'" method="POST" style="display:inline;">
                                '.csrf_field().' 
                                '.method_field('DELETE').'
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>';
                })
                ->make(true);
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'kategori_kode' => 'required|string',
            'kategori_nama' => 'required|string'
        ]);

        // Store new category
        $kategori = new KategoriModel();
        $kategori->kategori_kode = $request->kategori_kode;
        $kategori->kategori_nama = $request->kategori_nama;
        $kategori->save();

        return response()->json(['success' => 'Kategori berhasil ditambahkan!']);
    }

    public function edit($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        return response()->json($kategori);
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request
        $request->validate([
            'kategori_kode' => 'required|string',
            'kategori_nama' => 'required|string'
        ]);

        $kategori = KategoriModel::findOrFail($id);
        $kategori->kategori_kode = $request->kategori_kode;
        $kategori->kategori_nama = $request->kategori_nama;
        $kategori->save();

        return response()->json(['success' => 'Kategori berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        $kategori->delete();

        return response()->json(['success' => 'Kategori berhasil dihapus!']);
    }
}

