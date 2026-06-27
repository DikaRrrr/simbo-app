<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserPetugas extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'user_petugas';
    protected $primaryKey = 'id_petugas';
    protected $fillable = ['email', 'password', 'nama_petugas', 'wilayah_tugas', 'status_akun'];
    protected $hidden = ['password'];
}