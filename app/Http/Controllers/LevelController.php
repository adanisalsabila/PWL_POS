<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Log;

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
            dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($row) {
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
        $request->validate([
            'level_kode' => 'required|string|max:10',
            'level_nama' => 'required|string|max:50',
        ]);

        try {
            $level = LevelModel::create([
                'level_kode' => $request->level_kode,
                'level_nama' => $request->level_nama,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Level berhasil ditambahkan!',
                'data' => $level
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing level: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan level.'
            ], 500);
        }
    }

    // Menampilkan form untuk edit Level
    public function edit($id)
    {
        $level = LevelModel::findOrFail($id);
        return response()->json($level); // Mengirim data Level sebagai JSON
    }

    // Memperbarui data Level dengan Ajax
    public function update(Request $request, $id)
    {
        $request->validate([
            'level_kode' => 'required|string|max:10',
            'level_nama' => 'required|string|max:50',
        ]);

        $level = LevelModel::findOrFail($id);
        $level->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Level berhasil diperbarui!',
            'data' => $level
        ]);
    }

    // Menghapus data Level dengan Ajax
    public function destroy($id)
    {
        $level = LevelModel::findOrFail($id);
        $level->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Level berhasil dihapus!',
        ]);
    }
}
