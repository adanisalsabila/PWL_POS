<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    public function run(): void
    {
        $stok = [];
        for ($i = 1; $i <= 10; $i++) {
            $stok[] = [
                'barang_id' => $i,
                'stok_jumlah' => rand(10, 100),
                'stok_tanggal' => Carbon::now(),
            ];
        }

        DB::table('t_stok')->insert($stok);
    }
}