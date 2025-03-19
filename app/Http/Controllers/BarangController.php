<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\BarangModel;

class BarangController extends Controller
{
    public function index()
    {
        $activeMenu = 'barang';
        return view('barang.index', compact('activeMenu'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = BarangModel::select(['barang_id', 'barang_nama', 'kategori_id', 'supplier_id']);
            return DataTables::of($data)->make(true);
        }
        return abort(404);
    }
}