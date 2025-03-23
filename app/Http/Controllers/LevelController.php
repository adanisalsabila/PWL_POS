<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
            $level = LevelModel::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $level,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Level tidak ditemukan.',
                'error' => $e->getMessage(),
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
}