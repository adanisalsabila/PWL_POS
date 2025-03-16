<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokModel extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan nama model (dalam hal ini 'm_stok')
    protected $table = 'm_stok';

    // Tentukan kolom yang bisa diisi (fillable)
    protected $fillable = [
        'stok_name', // kolom yang sesuai dengan nama di tabel m_stok
    ];

    // Jika kolom 'created_at' dan 'updated_at' tidak ada di tabel, matikan fitur timestamp
    public $timestamps = false;
}
