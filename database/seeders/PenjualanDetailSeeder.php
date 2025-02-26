<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    public function run(): void
    {
        $penjualanDetail = [];
        $barangIds = range(1, 10);
        $penjualanIds = range(1, 10);

        foreach ($penjualanIds as $penjualanId) {
            $selectedBarang = array_rand(array_flip($barangIds), 3);
            foreach ($selectedBarang as $barangId) {
                $penjualanDetail[] = [
                    'penjualan_id' => $penjualanId,
                    'barang_id' => $barangId,
                    'penjualan_detail_jumlah' => rand(1, 5),
                    'penjualan_detail_harga' => rand(50000, 500000),
                ];
            }
        }

        DB::table('t_penjualan_detail')->insert($penjualanDetail);
    }
}