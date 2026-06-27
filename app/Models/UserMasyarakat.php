<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserMasyarakat extends Authenticatable
{
    protected $table = 'user_masyarakat';
    protected $primaryKey = 'id_masyarakat';

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'no_hp',
        'email',
        'password',
        'alamat',
        'status_akun',
    ];

    protected $hidden = [
        'password',
    ];
}
