<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserAdmin extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'user_admin';
    protected $primaryKey = 'id_admin';
    protected $fillable = ['email', 'password', 'nama_admin', 'status_akun'];
    protected $hidden = ['password'];
}