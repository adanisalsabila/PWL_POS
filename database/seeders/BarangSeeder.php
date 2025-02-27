<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barang = [
            // Perabotan Rumah (kategori_id = 1)
            ['kategori_id' => 1, 'barang_kode' => 'LEM001', 'barang_nama' => 'Lemari Kayu', 'harga_beli' => 1500000, 'harga_jual' => 1800000],
            ['kategori_id' => 1, 'barang_kode' => 'KRS001', 'barang_nama' => 'Kursi Plastik', 'harga_beli' => 50000, 'harga_jual' => 75000],

            // Alat Kebersihan (kategori_id = 2)
            ['kategori_id' => 2, 'barang_kode' => 'SAP001', 'barang_nama' => 'Sapu Lidi', 'harga_beli' => 20000, 'harga_jual' => 30000],
            ['kategori_id' => 2, 'barang_kode' => 'PEL001', 'barang_nama' => 'Pel Lantai', 'harga_beli' => 40000, 'harga_jual' => 55000],

            // Peralatan Dapur (kategori_id = 3)
            ['kategori_id' => 3, 'barang_kode' => 'PAN001', 'barang_nama' => 'Panci Stainless', 'harga_beli' => 100000, 'harga_jual' => 130000],
            ['kategori_id' => 3, 'barang_kode' => 'PIS001', 'barang_nama' => 'Pisau Dapur', 'harga_beli' => 25000, 'harga_jual' => 40000],

            // Elektronik Rumah Tangga (kategori_id = 4)
            ['kategori_id' => 4, 'barang_kode' => 'KUL001', 'barang_nama' => 'Kulkas 2 Pintu', 'harga_beli' => 3000000, 'harga_jual' => 3500000],
            ['kategori_id' => 4, 'barang_kode' => 'BLD001', 'barang_nama' => 'Blender', 'harga_beli' => 400000, 'harga_jual' => 500000],

            // Dekorasi Rumah (kategori_id = 5)
            ['kategori_id' => 5, 'barang_kode' => 'VAS001', 'barang_nama' => 'Vas Bunga', 'harga_beli' => 75000, 'harga_jual' => 100000],
            ['kategori_id' => 5, 'barang_kode' => 'LAM001', 'barang_nama' => 'Lampu Hias', 'harga_beli' => 150000, 'harga_jual' => 200000],
        ];

        DB::table('m_barang')->insert($barang);
    }
}
