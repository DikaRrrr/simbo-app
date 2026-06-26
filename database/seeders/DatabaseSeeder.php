<?php

namespace Database\Seeders;

use App\Models\UserAdmin;
use App\Models\UserMasyarakat;
use App\Models\UserPetugas;
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
    }
}
