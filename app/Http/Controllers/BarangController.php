<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\BarangModel;

class BarangController extends Controller
{
    public function dashboardBarang()
{
    return view('dashboard.barang');
}

// In BarangController
public function dashboardBarangList(Request $request)
{
    if ($request->ajax()) {
        $data = BarangModel::select(['id', 'nama', 'kategori_id', 'supplier_id']);
        return DataTables::of($data)->make(true);
    }
    return abort(404); // If it's not an AJAX request
}

}
