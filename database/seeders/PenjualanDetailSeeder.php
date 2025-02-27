<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PenjualanDetailSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua id dari t_penjualan dan m_barang
        $penjualanIds = DB::table('t_penjualan')->pluck('penjualan_id')->toArray();
        $barangIds = DB::table('m_barang')->pluck('barang_id')->toArray();

        if (empty($penjualanIds) || empty($barangIds)) {
            $this->command->error('Pastikan tabel t_penjualan dan m_barang memiliki data.');
            return;
        }

        $data = [];
        foreach ($penjualanIds as $penjualanId) {
            for ($i = 0; $i < 3; $i++) { // 3 barang per penjualan
                $data[] = [
                    'penjualan_id' => $penjualanId,
                    'barang_id' => $barangIds[array_rand($barangIds)],
                    'jumlah' => rand(1, 5),
                    'harga' => rand(100000, 3000000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert 30 data
        $chunks = array_chunk($data, 30);
        foreach ($chunks as $chunk) {
            DB::table('t_penjualan_detail')->insert($chunk);
        }

        $this->command->info(count($data) . ' data berhasil ditambahkan ke t_penjualan_detail!');
    }
}