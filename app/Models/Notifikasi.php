<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';

    // Kolom yang diizinkan untuk diisi massal (mass assignment)
    protected $fillable = [
        'id_laporan',
        'id_masyarakat',
        'tipe_notifikasi',
        'link_target',
        'isi_notifikasi',
        'judul_notifikasi',
        'status_baca'
    ];

    // Relasi ke tabel Laporan
    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }

    // Relasi ke tabel User Masyarakat
    public function masyarakat()
    {
        return $this->belongsTo(UserMasyarakat::class, 'id_masyarakat', 'id_masyarakat');
    }
}