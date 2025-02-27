<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_barang', function (Blueprint $table) {
            $table->id('barang_id'); // Primary key
            $table->unsignedBigInteger('kategori_id'); // Foreign key ke tabel m_kategori
            $table->string('barang_kode', 10); // Kode barang, max 10 karakter
            $table->string('barang_nama', 100); // Nama barang, max 100 karakter
            $table->integer('harga_beli'); // Harga beli barang
            $table->integer('harga_jual'); // Harga jual barang
            $table->timestamps(); // created_at dan updated_at

            // Foreign key constraint
            $table->foreign('kategori_id')->references('kategori_id')->on('m_kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_barang');
    }
};
