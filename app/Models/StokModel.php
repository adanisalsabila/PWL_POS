<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokModel extends Model
{
    protected $table = 't_stok'; // Table name
    protected $primaryKey = 'stok_id'; // Primary key
    public $timestamps = true; // Enable timestamps
    protected $fillable = ['barang_id', 'user_id', 'stok_tanggal']; // Ensure correct columns are here

    // Define the relationship with BarangModel
    public function barang(): BelongsTo
    {
        return $this->belongsTo(BarangModel::class, 'barang_id', 'barang_id');
    }

    // Define the relationship with UserModel
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
}
