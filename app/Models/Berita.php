<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'id_berita';

    protected $fillable = [
        'id_petugas',
        'id_admin_arsip',
        'judul_berita',
        'isi_berita',
        'tanggal_publish',
        'tanggal_arsip',
        'status_arsip',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_publish' => 'datetime',
            'tanggal_arsip' => 'datetime',
        ];
    }

    public function petugas()
    {
        return $this->belongsTo(UserPetugas::class, 'id_petugas', 'id_petugas');
    }

    public function adminArsip()
    {
        return $this->belongsTo(UserAdmin::class, 'id_admin_arsip', 'id_admin');
    }
}