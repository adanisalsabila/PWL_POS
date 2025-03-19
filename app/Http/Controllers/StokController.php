<?php
namespace App\Http\Controllers;

use App\Models\StokModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
            $data = StokModel::with(['barang', 'user'])->select(['stok_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah']);
            return DataTables::of($data)
                ->addColumn('aksi', function($row) {
                    $editUrl = route('stok.edit', $row->stok_id);
                    $deleteUrl = route('stok.destroy', $row->stok_id);

                    return '<a href="'.$editUrl.'" class="btn btn-sm btn-warning">Edit</a>' .
                        '<form action="'.$deleteUrl.'" method="POST" style="display:inline;">' .
                            csrf_field() .
                            method_field('DELETE') .
                            '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin?\')">Hapus</button>' .
                        '</form>';
                })
                ->rawColumns(['aksi']) // Allow HTML rendering
                ->make(true);
        }
        return abort(404);
    }

    // Show form for creating new stock entry
    public function create()
    {
        $barang = BarangModel::all();
        $users = UserModel::all();
        return view('stok.create_ajax', compact('barang', 'users'));
    }

    // Store new stock entry
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'user_id' => 'required',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer',
        ]);

        StokModel::create($request->all());

        return redirect()->route('stok.index')->with('success', 'Stok added successfully!');
    }

    // Show form for editing stock entry
    public function edit($id)
    {
        $stok = StokModel::findOrFail($id);
        $barang = BarangModel::all();
        $users = UserModel::all();
        return view('stok.edit_ajax', compact('stok', 'barang', 'users'));
    }

    // Update the stock entry
    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required',
            'user_id' => 'required',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer',
        ]);

        $stok = StokModel::findOrFail($id);
        $stok->update($request->all());

        return redirect()->route('stok.index')->with('success', 'Stok updated successfully!');
    }

    // Delete stock entry
    public function destroy($id)
    {
        StokModel::destroy($id);
        return redirect()->route('stok.index')->with('success', 'Stok deleted successfully!');
    }
}
