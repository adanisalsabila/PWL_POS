<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriModel extends Model
{
    protected $table = 'm_kategori'; // Table name
    protected $primaryKey = 'kategori_id'; // Primary key

    // Define the relationship with BarangModel
    public function barang(): HasMany
    {
        // Correct the foreign key to 'kategori_id' instead of 'barang_id'
        return $this->hasMany(BarangModel::class, 'kategori_id', 'kategori_id');
    }
}
