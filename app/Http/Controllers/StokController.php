<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\StokModel;

class StokController extends Controller
{
    public function index()
    {
        $activeMenu = 'stok'; // Ensure active menu is set
        return view('stok.index', compact('activeMenu')); // Pass active menu to view
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            // Update the column name to match the database column (stok_jumlah)
            $data = StokModel::select(['stok_id', 'barang_id', 'stok_tanggal']); // Updated column names
            return DataTables::of($data)->make(true);
        }
        return abort(404);
    }
}
