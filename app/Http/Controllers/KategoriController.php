<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\KategoriModel;

class KategoriController extends Controller
{
    public function index()
    {
        $activeMenu = 'kategori'; // Tambahkan ini
        return view('kategori.index', compact('activeMenu')); // Tambahkan compact
    }

    public function list(Request $request) // Ubah nama fungsi
    {
        if ($request->ajax()) {
            $data = KategoriModel::select(['kategori_id', '*']);
            return DataTables::of($data)->make(true);
        }
        return abort(404);
    }
}