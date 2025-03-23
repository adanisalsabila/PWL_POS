<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('nama');  // Kolom 'nama'
            $table->string('kontak'); // Kolom 'kontak'
            $table->string('alamat'); // Kolom 'alamat'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn(['nama', 'kontak', 'alamat']); // Hapus kolom saat rollback
        });
    }
}
