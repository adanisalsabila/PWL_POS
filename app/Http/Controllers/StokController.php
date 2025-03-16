<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\StokModel;

class StokController extends Controller
{
    public function dashboardStok()
{
    return view('dashboard.stok');
}

public function dashboardStokList(Request $request)
    {
        if ($request->ajax()) {
            $data = StokModel::select(['id', 'barang_id', 'jumlah_stok', 'tanggal_masuk']); // Pilih kolom yang ingin ditampilkan
            return DataTables::of($data)->make(true);
        }
        return abort(404); // Jika bukan permintaan AJAX
    }
}
