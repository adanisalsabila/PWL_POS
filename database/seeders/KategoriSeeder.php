<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_kode' => 'PRB', 'kategori_nama' => 'Perabotan Rumah', 'created_at' => now(), 'updated_at' => now()],
            ['kategori_kode' => 'ALK', 'kategori_nama' => 'Alat Kebersihan', 'created_at' => now(), 'updated_at' => now()],
            ['kategori_kode' => 'DAP', 'kategori_nama' => 'Peralatan Dapur', 'created_at' => now(), 'updated_at' => now()],
            ['kategori_kode' => 'ELK', 'kategori_nama' => 'Elektronik Rumah Tangga', 'created_at' => now(), 'updated_at' => now()],
            ['kategori_kode' => 'DCR', 'kategori_nama' => 'Dekorasi Rumah', 'created_at' => now(), 'updated_at' => now()],
        ];
        
        DB::table('m_kategori')->insert($data);
    }
}
