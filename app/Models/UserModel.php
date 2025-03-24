<?php

namespace App\Models;
use App\Models\LevelModel;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticable;


class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_users';
    protected $primaryKey = 'user_id';

    protected $fillable = ['level_id', 'level_kode', 'username', 'nama', 'password', 'created_at', 'updated_at'];

    protected $hidden = ['password']; //jgn ditampilkan saat select

    protected $casts = ['password' => 'hashed']; //casting password agar otomatis di hash

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    public function getRoleName(): string {
        return $this->level->level_idj;
    }

    public function hasRole($role): bool {
        return $this->level->level_kode == $role;
    }

}