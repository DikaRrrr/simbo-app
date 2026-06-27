<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_masyarakat',
        'judul_laporan',
        'id_kategori',
        'lokasi',
        'tanggal_laporan',
        'isi_laporan',
        'id_admin',
        'id_petugas',
        'status_laporan',
        'catatan_laporan',
        'prioritas_laporan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_laporan' => 'datetime',
        ];
    }

    public function masyarakat()
    {
        return $this->belongsTo(UserMasyarakat::class, 'id_masyarakat', 'id_masyarakat');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriLaporan::class, 'id_kategori', 'id_kategori');
    }

    public function petugas()
    {
        return $this->belongsTo(UserPetugas::class, 'id_petugas', 'id_petugas');
    }

    public function admin()
    {
        return $this->belongsTo(UserAdmin::class, 'id_admin', 'id_admin');
    }
}