<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            ['kategori_nama' => 'Elektronik', 'kategori_deskripsi' => 'Perangkat elektronik'],
            ['kategori_nama' => 'Pakaian', 'kategori_deskripsi' => 'Pakaian pria dan wanita'],
            ['kategori_nama' => 'Makanan', 'kategori_deskripsi' => 'Produk makanan'],
            ['kategori_nama' => 'Minuman', 'kategori_deskripsi' => 'Produk minuman'],
            ['kategori_nama' => 'Perlengkapan Rumah', 'kategori_deskripsi' => 'Perlengkapan rumah tangga'],
        ];

        DB::table('m_kategori')->insert($kategori);
    }
}