<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    public function showLogin()
    {
        return view('petugas.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('petugas')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/petugas/dashboard')->with('success', 'Selamat datang Petugas!');
        }
        return back()->withErrors(['email' => 'Login gagal!']);
    }

    public function logout(Request $request)
    {
        Auth::guard('petugas')->logout();
        return redirect('/petugas/login');
    }

    public function dashboard()
    {
        $petugas = Auth::guard('petugas')->user();

        $totalLaporan = Laporan::count();
        $totalDiproses = Laporan::whereIn('status_laporan', ['Diproses', 'diproses'])->count();
        $totalSelesai = Laporan::whereIn('status_laporan', ['Selesai', 'selesai'])->count();
        $totalBerita = Berita::count();
        $totalBeritaPetugas = Berita::where('id_petugas', $petugas->id_petugas)->count();

        $laporanTerbaru = Laporan::with(['masyarakat', 'kategori'])
            ->latest('created_at')
            ->take(5)
            ->get();

        $beritaTerbaru = Berita::where('id_petugas', $petugas->id_petugas)
            ->latest('tanggal_publish')
            ->take(3)
            ->get();

        return view('petugas.dashboard', compact(
            'totalLaporan',
            'totalDiproses',
            'totalSelesai',
            'totalBerita',
            'totalBeritaPetugas',
            'laporanTerbaru',
            'beritaTerbaru'
        ));
    }

    public function laporanIndex(Request $request)
    {
        // 1. Ambil ID petugas yang sedang login
        // Sesuaikan 'petugas' dengan nama guard auth yang kamu gunakan, 
        // atau gunakan Auth::user()->id_petugas jika menggunakan default auth.
        $petugasLoginId = Auth::guard('petugas')->user()->id_petugas;

        // 2. Tambahkan kondisi where('id_petugas', ...) agar hanya mengambil tugas miliknya
        $query = Laporan::with(['masyarakat', 'kategori', 'petugas'])
            ->where('id_petugas', $petugasLoginId);

        // 3. Filter berdasarkan status (opsional dari request)
        if ($request->filled('status')) {
            $query->where('status_laporan', $request->status);
        }

        // 4. Filter berdasarkan kata kunci pencarian
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($builder) use ($keyword) {
                $builder->where('judul_laporan', 'like', "%{$keyword}%")
                    ->orWhere('isi_laporan', 'like', "%{$keyword}%")
                    ->orWhere('lokasi', 'like', "%{$keyword}%");
            });
        }

        // 5. Urutkan dan Pagination
        $laporan = $query->latest('created_at')->paginate(10)->withQueryString();

        return view('petugas.v_laporan.index', compact('laporan'));
    }

    public function beritaIndex(Request $request)
    {
        $petugas = Auth::guard('petugas')->user();
        $query = Berita::where('id_petugas', $petugas->id_petugas)->latest('tanggal_publish');

        if ($request->filled('status')) {
            $query->where('status_arsip', $request->status);
        }

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($builder) use ($keyword) {
                $builder->where('judul_berita', 'like', "%{$keyword}%")
                    ->orWhere('isi_berita', 'like', "%{$keyword}%");
            });
        }

        $berita = $query->paginate(10)->withQueryString();
        $totalBeritaPetugas = Berita::where('id_petugas', $petugas->id_petugas)->count();
        $totalAktif = Berita::where('id_petugas', $petugas->id_petugas)->where('status_arsip', 'aktif')->count();
        $totalDiarsipkan = Berita::where('id_petugas', $petugas->id_petugas)->where('status_arsip', 'diarsipkan')->count();

        return view('petugas.v_berita.index', compact('berita', 'totalBeritaPetugas', 'totalAktif', 'totalDiarsipkan'));
    }

    public function beritaCreate()
    {
        return view('petugas.v_berita.create');
    }

    public function beritaStore(Request $request)
    {
        $petugas = Auth::guard('petugas')->user();

        $data = $request->validate([
            'judul_berita' => 'required|string|max:150',
            'isi_berita' => 'required|string',
            'tanggal_publish' => 'nullable|date',
            'status_arsip' => 'required|in:aktif,diarsipkan',
        ]);

        $data['id_petugas'] = $petugas->id_petugas;
        $data['tanggal_publish'] = $data['tanggal_publish'] ?? now();
        $data['tanggal_arsip'] = $data['status_arsip'] === 'diarsipkan' ? now() : null;

        Berita::create($data);

        return redirect()->route('petugas.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function beritaEdit(int $id)
    {
        $berita = $this->findBeritaPetugas($id);

        return view('petugas.v_berita.edit', compact('berita'));
    }

    public function beritaUpdate(Request $request, int $id)
    {
        $berita = $this->findBeritaPetugas($id);

        $data = $request->validate([
            'judul_berita' => 'required|string|max:150',
            'isi_berita' => 'required|string',
            'tanggal_publish' => 'nullable|date',
            'status_arsip' => 'required|in:aktif,diarsipkan',
        ]);

        $data['tanggal_publish'] = $data['tanggal_publish'] ?? $berita->tanggal_publish;
        $data['tanggal_arsip'] = $data['status_arsip'] === 'diarsipkan'
            ? ($berita->tanggal_arsip ?? now())
            : null;

        $berita->update($data);

        return redirect()->route('petugas.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function beritaDestroy(int $id)
    {
        $berita = $this->findBeritaPetugas($id);
        $berita->delete();

        return redirect()->route('petugas.berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    private function findBeritaPetugas(int $id): Berita
    {
        $petugas = Auth::guard('petugas')->user();

        return Berita::where('id_berita', $id)
            ->where('id_petugas', $petugas->id_petugas)
            ->firstOrFail();
    }
}
