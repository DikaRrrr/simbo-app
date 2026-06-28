<?php

namespace App\Http\Controllers;

use App\Models\FotoLaporan;
use App\Models\KategoriLaporan;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MasyarakatController extends Controller
{

    public function index()
    {
        return view('masyarakat.v_beranda.index', ['pageTitle' => 'Beranda']);
    }

    public function laporanIndex()
    {
        $kategoris = KategoriLaporan::all();

        return view('masyarakat.v_laporan.index', ['pageTitle' => 'Laporan'], compact('kategoris'));
    }

    public function storeLaporan(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'judul'      => 'required|string|max:150', // Disesuaikan dengan migration (150)
            'kategori'   => 'required|integer',
            'detail'     => 'required|string',
            'alamat'     => 'required|string|max:255',
            'patokan'    => 'nullable|string|max:255',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'latitude'   => 'required',
            'longitude'  => 'required',
        ]);

        DB::beginTransaction();

        try {
            // 2. Gabungkan alamat, patokan, dan titik koordinat
            $lokasiLengkap = $request->alamat;
            if ($request->filled('patokan')) {
                $lokasiLengkap .= ' (Patokan: ' . $request->patokan . ')';
            }
            $lokasiLengkap .= ' | Koordinat: ' . $request->latitude . ', ' . $request->longitude;

            // 3. Simpan ke tabel Laporan
            $laporan = Laporan::create([
                'id_masyarakat'     => auth()->id(),
                'judul_laporan'     => $request->judul,
                'id_kategori'       => $request->kategori,
                'isi_laporan'       => $request->detail,
                'lokasi'            => $lokasiLengkap,
                'tanggal_laporan'   => now(),
                'status_laporan'    => 'Menunggu', // <-- PERBAIKAN: Harus 'Menunggu' sesuai ENUM migration
                'prioritas_laporan' => 'Sedang',   // <-- PERBAIKAN: Default ENUM
            ]);

            // 4. Simpan ke tabel foto_laporan
            if ($request->hasFile('foto_bukti')) {
                $file = $request->file('foto_bukti');
                $pathFoto = $file->store('bukti_laporan', 'public');

                FotoLaporan::create([
                    'id_laporan' => $laporan->id_laporan,
                    'file_foto'  => $pathFoto,
                ]);
            }

            DB::commit();
            return redirect()->route('masyarakat.beranda')->with('success', 'Laporan berhasil dikirim!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal simpan laporan: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function aktivitasIndex()
    {
        return view('masyarakat.v_aktivitas.index', ['pageTitle' => 'Aktivitas']);
    }

    public function beritaIndex()
    {
        return view('masyarakat.v_berita.index', ['pageTitle' => 'Berita']);
    }

    public function notifikasiIndex()
    {
        return view('masyarakat.v_notifikasi.index', ['pageTitle' => 'Notifikasi']);
    }

    public function profileIndex()
    {
        return view('masyarakat.v_profile.index', ['pageTitle' => 'Profile']);
    }
}
