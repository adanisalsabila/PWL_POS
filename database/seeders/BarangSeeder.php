<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $barang = [
            ['kategori_id' => 1, 'barang_nama' => 'Laptop', 'barang_deskripsi' => 'Laptop terbaru', 'barang_harga' => 10000000],
            ['kategori_id' => 1, 'barang_nama' => 'Smartphone', 'barang_deskripsi' => 'Smartphone canggih', 'barang_harga' => 5000000],
            ['kategori_id' => 2, 'barang_nama' => 'Kaos', 'barang_deskripsi' => 'Kaos katun', 'barang_harga' => 100000],
            ['kategori_id' => 2, 'barang_nama' => 'Celana Jeans', 'barang_deskripsi' => 'Celana jeans pria', 'barang_harga' => 200000],
            ['kategori_id' => 3, 'barang_nama' => 'Nasi Goreng', 'barang_deskripsi' => 'Nasi goreng spesial', 'barang_harga' => 25000],
            ['kategori_id' => 3, 'barang_nama' => 'Mie Ayam', 'barang_deskripsi' => 'Mie ayam bakso', 'barang_harga' => 20000],
            ['kategori_id' => 4, 'barang_nama' => 'Es Teh', 'barang_deskripsi' => 'Es teh manis', 'barang_harga' => 5000],
            ['kategori_id' => 4, 'barang_nama' => 'Jus Jeruk', 'barang_deskripsi' => 'Jus jeruk segar', 'barang_harga' => 10000],
            ['kategori_id' => 5, 'barang_nama' => 'Piring', 'barang_deskripsi' => 'Piring keramik', 'barang_harga' => 15000],
            ['kategori_id' => 5, 'barang_nama' => 'Gelas', 'barang_deskripsi' => 'Gelas kaca', 'barang_harga' => 10000],
        ];

        DB::table('m_barang')->insert($barang);
    }
}