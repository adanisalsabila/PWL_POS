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
            $data = BarangModel::with('kategori')
                ->select(['barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id', 'created_at', 'updated_at']);

            return DataTables::of($data)
                ->addColumn('kategori_nama', function ($row) {
                    return $row->kategori ? $row->kategori->kategori_nama : 'No Kategori';
                })
                ->addColumn('aksi', function ($row) {
                    return '<a href="/barang/' . $row->barang_id . '/edit" class="btn btn-sm btn-warning">Edit</a>' .
                           '<form action="/barang/' . $row->barang_id . '" method="POST" style="display: inline-block;">' .
                           '@csrf @method("DELETE")' .
                           '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin?\')">Hapus</button>' .
                           '</form>';
                })
                ->make(true);
        }

        return abort(404);
    }

    public function destroy($barang_id)
    {
        $barang = BarangModel::findOrFail($barang_id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
   
}