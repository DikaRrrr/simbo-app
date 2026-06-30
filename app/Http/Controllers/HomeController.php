<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 3 berita teraktif terbaru untuk ditampilkan di section "Berita Terkini"
        $beritaTerbaru = Berita::where('status_arsip', 'aktif')
            ->with('kategori')
            ->latest('tanggal_publish')
            ->take(3)
            ->get();

        return view('welcome', compact('beritaTerbaru'));
        // Sesuaikan nama view ('beranda') dengan path file aslimu, contoh:
        // return view('v_beranda.index', compact('beritaTerbaru'));
    }

    public function indexBerita(Request $request)
    {
        $query = Berita::where('status_arsip', 'aktif')
            ->with('kategori')
            ->latest('tanggal_publish');

        // Filter pencarian opsional (?q=...)
        if ($request->filled('q')) {
            $query->where('judul_berita', 'like', '%' . $request->q . '%');
        }

        $berita = $query->paginate(9)->withQueryString();

        return view('v_berita.index', compact('berita'));
    }

    /**
     * Halaman baca satu berita (detail)
     */
    public function showBerita($id)
    {
        $berita = Berita::where('status_arsip', 'aktif')
            ->with('kategori')
            ->findOrFail($id);

        // 3 berita lain untuk rekomendasi di bagian bawah
        $beritaLainnya = Berita::where('status_arsip', 'aktif')
            ->where('id_berita', '!=', $id)
            ->latest('tanggal_publish')
            ->take(3)
            ->get();

        return view('v_berita.detail', compact('berita', 'beritaLainnya'));
    }
}
