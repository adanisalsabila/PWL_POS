<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah level_id tersedia di tabel m_level
        $levelIds = DB::table('m_level')->pluck('level_id')->toArray();

        if (empty($levelIds)) {
            $this->command->error('Tabel m_level kosong. Harap isi terlebih dahulu.');
            return;
        }

        // Matikan foreign key checks untuk sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel m_user
        DB::table('m_user')->truncate();

        // Nyalakan foreign key checks kembali
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Data yang akan di-seed
        $data = [
            [
                'level_id' => $levelIds[0] ?? 1,
                'username' => 'admin',
                'nama' => 'Administrator',
                'password' => Hash::make('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level_id' => $levelIds[1] ?? 2,
                'username' => 'manager',
                'nama' => 'Manager',
                'password' => Hash::make('12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level_id' => $levelIds[2] ?? 3,
                'username' => 'staff',
                'nama' => 'Staff/Kasir',
                'password' => Hash::make('12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Masukkan data ke tabel m_user
        DB::table('m_user')->insert($data);

        $this->command->info('Data m_user berhasil di-seed.');
    }
}
