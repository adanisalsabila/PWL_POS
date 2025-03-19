<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\StokModel;

class StokController extends Controller
{
    public function index()
    {
        $activeMenu = 'stok'; // Tambahkan ini
        return view('stok.index', compact('activeMenu')); // Tambahkan compact
    }

    public function list(Request $request) // Ubah nama fungsi
    {
        if ($request->ajax()) {
            $data = StokModel::select(['stok_id', 'barang_id', 'jumlah_stok', 'tanggal_masuk']);
            return DataTables::of($data)->make(true);
        }
        return abort(404);
    }
}