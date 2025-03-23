<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi
    protected $table = 'suppliers';

    // Tentukan kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'nama',
        'kontak',
        'alamat',
    ];

    // Tentukan kolom yang tidak bisa diisi
    // protected $guarded = ['id'];  // Alternatif untuk mencegah mass-assignment pada kolom tertentu

    // Menambahkan relationship jika diperlukan
}
