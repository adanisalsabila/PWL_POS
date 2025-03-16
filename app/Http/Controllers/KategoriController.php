<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\KategoriModel;


class KategoriController extends Controller
{
    public function index(){
        // Insert data
        $data = [
            'kategori_kode' => 'SNK',
            'kategori_nama' => 'Snack/Makanan Ringan',
            'created_at' => now()
        ];
        DB::table('m_kategori')->insert($data);
        echo 'Insert data baru berhasil';

        //Update data
        $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'Camilan']);
        echo '<br>Update data berhasil. Jumlah data yang diupdate: '.$row.' baris';

        // Delete data
        $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
        echo '<br>Delete data berhasil. Jumlah data yang dihapus: '.$row.' baris';

        // Get data
        $data = DB::table('m_kategori')->get();
        return view('kategori', ['data' => $data]);
    }

    public function dashboardKategori()
{
    return view('dashboard.kategori');
}

public function dashboardKategoriList(Request $request)
{
    if ($request->ajax()) {
        $data = KategoriModel::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return ''; // Tambahkan aksi jika perlu
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
    
}
