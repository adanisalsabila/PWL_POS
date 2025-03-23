<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->insert([
            [
                'nama' => 'Supplier A',
                'kontak' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            ],
            [
                'nama' => 'Supplier B',
                'kontak' => '082345678901',
                'alamat' => 'Jl. Pahlawan No. 20, Bandung',
            ],
            [
                'nama' => 'Supplier C',
                'kontak' => '083456789012',
                'alamat' => 'Jl. Soekarno Hatta No. 15, Surabaya',
            ],
            [
                'nama' => 'Supplier D',
                'kontak' => '084567890123',
                'alamat' => 'Jl. Gatot Subroto No. 30, Yogyakarta',
            ],
        ]);
    }
}
