<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateBarangKategoriKodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $barang = DB::table('barang')->get();

        foreach ($barang as $item) {
            $kategori = DB::table('kategori')->where('kategori_id', $item->kategori_id)->first();
            if ($kategori) {
                DB::table('barang')->where('barang_id', $item->barang_id)->update(['kategori_kode' => $kategori->kategori_kode]);
            }
        }
    }
}

