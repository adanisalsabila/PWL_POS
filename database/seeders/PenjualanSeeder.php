<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $penjualan = [];
        for ($i = 1; $i <= 10; $i++) {
            $penjualan[] = [
                'user_id' => rand(1, 3), // Asumsi user_id 1, 2, atau 3
                'penjualan_tanggal' => Carbon::now(),
                'penjualan_total' => rand(100000, 1000000),
            ];
        }

        DB::table('t_penjualan')->insert($penjualan);
    }
}