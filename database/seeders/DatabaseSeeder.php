<?php

namespace Database\Seeders;

use App\Models\UserAdmin;
use App\Models\UserMasyarakat;
use App\Models\UserPetugas;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        UserAdmin::create([
            'email' => 'admin@simbo.com',
            'password'   => Hash::make('simbo123'),
            'nama_admin' => 'Administrator Utama'
        ]);

        UserPetugas::create([
            'email' => 'petugas@simbo.com',
            'password'   => Hash::make('simbo123'),
            'nama_petugas' => 'Petugas 1',
            'wilayah_tugas' => 'Wilayah 1'
        ]);

        UserMasyarakat::create([
            'nik' => '1234567890123456',
            'email' => 'masyarakat@simbo.com',
            'password'   => Hash::make('simbo123'),
            'nama_lengkap' => 'Masyarakat 1',
            'no_hp' => '081234567890',
            'alamat' => 'Alamat Masyarakat 1'
        ]);

        DB::table('kategori_laporan')->insert([
        ['id_kategori' => 1, 'nama_kategori' => 'Infrastruktur'],
        ['id_kategori' => 2, 'nama_kategori' => 'Lingkungan'],
        ['id_kategori' => 3, 'nama_kategori' => 'Keamanan'],
    ]);

        DB::table('laporan')->insert([
            'id_masyarakat'     => 1, // Pastikan ada data di tabel user_masyarakat dengan ID 1
            'judul_laporan'     => 'Jalan Berlubang Membahayakan Pengendara',
            'id_kategori'       => 1, // 1 = Infrastruktur (Sesuai dengan view Blade kamu)
            'lokasi'            => 'Jl. Sudirman Raya, di depan Bank BCA',
            'tanggal_laporan'   => Carbon::now(),
            'isi_laporan'       => 'Terdapat lubang sedalam kurang lebih 15cm dengan diameter 50cm. Sangat berbahaya ketika hujan karena tertutup genangan air.',
            'id_admin'          => null, // Belum diidentifikasi
            'id_petugas'        => null, // Belum ditugaskan
            'status_laporan'    => 'Menunggu', // Wajib 'Menunggu' agar muncul di halaman
            'catatan_laporan'   => null,
            'prioritas_laporan' => 'Tinggi',
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);
    }
}
