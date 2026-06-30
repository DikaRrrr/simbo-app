<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\FotoLaporan;
use App\Models\KategoriLaporan;
use App\Models\Laporan;
use App\Models\Notifikasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

        // 1. Ambil ID petugas yang sedang login
        $petugasId = Auth::guard('petugas')->user()->id_petugas;

        // 2. Ambil statistik laporan untuk dashboard (Opsional, tapi bagus untuk UI)
        $totalLaporan = Laporan::where('id_petugas', $petugasId)->count();
        $diproses = Laporan::where('id_petugas', $petugasId)->where('status_laporan', 'Diproses')->count();
        $selesai = Laporan::where('id_petugas', $petugasId)->where('status_laporan', 'Selesai')->count();

        // 3. Ambil 5 Laporan Terbaru yang ditugaskan ke petugas ini
        // INI ADALAH VARIABEL YANG TADI ERROR DI VIEW ANDA
        $laporanTerbaru = Laporan::with(['masyarakat', 'kategori'])
            ->where('id_petugas', $petugasId)
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

        return view('petugas.v_laporan.index', compact('laporan'), ['pageTitle' => 'Manajemen Laporan']);
    }

    public function laporanEdit($id)
    {
        // Panggil relasi  yang baru
        $laporan = Laporan::with(['masyarakat', 'kategori', 'fotoUtama', 'fotoLaporan'])->findOrFail($id);

        // Memisahkan catatan agar di form petugas hanya muncul catatan miliknya sendiri
        $catatanPecah = explode("\n\n--- Catatan Petugas ---\n", $laporan->catatan_laporan);
        $catatanAdmin = $catatanPecah[0] ?? '';
        $catatanPetugas = $catatanPecah[1] ?? '';

        return view('petugas.v_laporan.edit', compact('laporan', 'catatanAdmin', 'catatanPetugas'));
    }

    public function laporanUpdate(Request $request, $id)
    {
        $request->validate([
            'status_laporan'    => 'required|in:Menunggu,Diproses,Selesai,Ditolak',
            'catatan_petugas'   => 'nullable|string', // Namanya disesuaikan
            'foto_penyelesaian' => 'required_if:status_laporan,Selesai|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $laporan = Laporan::findOrFail($id);

        // 1. LOGIKA MENGGABUNGKAN CATATAN (Agar catatan admin tidak hilang)
        $catatanPecah = explode("\n\n--- Catatan Petugas ---\n", $laporan->catatan_laporan);
        $catatanAsliAdmin = $catatanPecah[0] ?? ''; // Ambil catatan admin yang asli

        if ($request->filled('catatan_petugas')) {
            // Gabungkan catatan admin dan catatan petugas baru
            $laporan->catatan_laporan = $catatanAsliAdmin . "\n\n--- Catatan Petugas ---\n" . $request->catatan_petugas;
        } else {
            // Jika petugas mengosongkan catatannya, kembalikan hanya catatan admin
            $laporan->catatan_laporan = $catatanAsliAdmin;
        }

        $laporan->status_laporan = $request->status_laporan;
        $laporan->save();

        // 2. LOGIKA UPLOAD FOTO PENYELESAIAN KE TABEL `foto_laporan`
        if ($request->hasFile('foto_penyelesaian')) {
            $file = $request->file('foto_penyelesaian');
            $pathFoto = $file->store('bukti_penyelesaian', 'public');

            // Hapus foto penyelesaian sebelumnya (jika petugas meng-edit foto/upload ulang)
            // Asumsinya: Foto pertama (offset 0) adalah milik warga, foto kedua dan seterusnya dihapus dulu
            $fotoLama = FotoLaporan::where('id_laporan', $id)->orderBy('id_foto', 'asc')->skip(1)->first();
            if ($fotoLama) {
                $fotoLama->delete();
                // Opsional: hapus fisik file Storage::disk('public')->delete($fotoLama->file_foto);
            }

            // Insert Foto Baru
            FotoLaporan::create([
                'id_laporan' => $laporan->id_laporan,
                'file_foto'  => $pathFoto,
            ]);
        }

        // 3. LOGIKA KIRIM WHATSAPP
        if ($request->has('kirim_wa')) {

            // ── Format nomor telepon ──────────────────────────────────────
            $noTelp = $laporan->masyarakat->no_hp ?? '';
            if (str_starts_with($noTelp, '0')) {
                $noTelp = '62' . substr($noTelp, 1);
            }

            // ── Data laporan ──────────────────────────────────────────────
            $namaPelapor  = $laporan->masyarakat->nama_lengkap ?? 'Warga Bogor';
            $tiket        = '#RPT-' . str_pad($laporan->id_laporan, 4, '0', STR_PAD_LEFT);
            $judul        = $laporan->judul_laporan;
            $kategori     = $laporan->kategori->nama_kategori ?? '-';
            $lokasi       = $laporan->lokasi;
            $tanggal      = \Carbon\Carbon::now()->translatedFormat('l, d F Y');
            $jam          = \Carbon\Carbon::now()->format('H:i') . ' WIB';
            $catatanText  = $request->filled('catatan_petugas')
                ? $request->catatan_petugas
                : 'Tidak ada catatan tambahan dari petugas.';

            // ── Label status ──────────────────────────────────────────────
            $statusLabel = match ($laporan->status_laporan) {
                'Selesai'  => '✅ SELESAI — Laporan telah berhasil ditangani',
                'Diproses' => '🔄 SEDANG DIPROSES — Petugas sedang menangani laporan',
                'Menunggu' => '⏳ MENUNGGU — Laporan dalam antrian penanganan',
                'Ditolak'  => '❌ DITOLAK — Laporan tidak dapat diproses',
                default    => $laporan->status_laporan,
            };

            // ── URL foto penyelesaian (foto kedua di tabel) ───────────────
            $fotoPenyelesaian = FotoLaporan::where('id_laporan', $laporan->id_laporan)
                ->orderBy('id_foto', 'asc')
                ->skip(1)
                ->first();

            $urlFoto = $fotoPenyelesaian
                ? asset('storage/' . $fotoPenyelesaian->file_foto)
                : null;

            // ── Susun pesan profesional ───────────────────────────────────
            $pesan = "NOTIFIKASI SIMBO\n";

            $pesan .= "Yth. Bapak/Ibu {$namaPelapor},\n\n";
            $pesan .= "Kami dari Tim Petugas SIMBO menyampaikan pembaruan resmi ";
            $pesan .= "terkait laporan yang Anda ajukan kepada kami.\n\n";

            $pesan .= "DETAIL LAPORAN\n";
            $pesan .= "Nomor Tiket  : {$tiket}\n";
            $pesan .= "Judul        : {$judul}\n";
            $pesan .= "Kategori     : {$kategori}\n";
            $pesan .= "Lokasi       : {$lokasi}\n";
            $pesan .= "Diperbarui   : {$tanggal}, {$jam}\n\n";

            $pesan .= "STATUS TERKINI\n";
            $pesan .= "{$statusLabel}\n\n";

            $pesan .= "CATATAN PETUGAS\n";
            $pesan .= "{$catatanText}\n\n";

            // Sertakan link foto jika ada
            if ($urlFoto) {
                $pesan .= "Dokumentasi foto penyelesaian dapat Anda lihat melalui website\n";
            }

            $pesan .= "Atas kepercayaan Bapak/Ibu kepada layanan SIMBO, ";
            $pesan .= "kami mengucapkan terima kasih.\n\n";
            $pesan .= "Hormat kami,\n";
            $pesan .= "Tim Petugas SIMBO\n";
            $pesan .= "Sistem Informasi Pengaduan Masyarakat Bogor\n";

            return redirect()->away('https://wa.me/' . $noTelp . '?text=' . urlencode($pesan));
        }

        // --- TRIGGER NOTIFIKASI LAPORAN ---
        Notifikasi::create([
            'id_masyarakat'   => $laporan->id_masyarakat,
            'id_laporan'      => $laporan->id_laporan,
            'tipe_notifikasi' => 'laporan',
            'judul_notifikasi' => 'Status Laporan Diperbarui',
            'isi_notifikasi'  => "Status laporan Anda tentang '{$laporan->judul_laporan}' telah diubah menjadi: " . strtoupper($request->status_laporan),

            // Arahkan user ke halaman detail laporannya saat notif diklik
            'link_target'     => route('aktivitas.detail', $laporan->id_laporan),
        ]);

        return redirect()->route('petugas.laporan.index')->with('success', 'Status laporan berhasil diperbarui!');
    }


    public function exportPdfLaporan(Request $request)
    {
        // Ambil query data yang sama dengan fungsi index() Anda
        $query = Laporan::with(['masyarakat', 'kategori']);

        // Terapkan filter yang sama (Pencarian & Status)
        if ($request->filled('q')) {
            $query->where('judul_laporan', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('status')) {
            $query->where('status_laporan', $request->status);
        }

        $laporan = $query->latest()->get(); // Tidak pakai paginate karena untuk PDF kita butuh semua data hasil filter

        // Render ke PDF (Buat file view baru khusus untuk cetak PDF)
        $pdf = Pdf::loadView('petugas.v_laporan.pdf', compact('laporan'));

        // Download file dengan nama dinamis
        return $pdf->stream('Laporan-Masyarakat-' . date('Y-m-d') . '.pdf');
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
        $kategoris = KategoriLaporan::all();

        return view('petugas.v_berita.create', compact('kategoris'));
    }

    public function beritaStore(Request $request)
    {
        $petugas = Auth::guard('petugas')->user();

        $data = $request->validate([
            'judul_berita' => 'required|string|max:150',
            'isi_berita' => 'required|string',
            'gambar_berita' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
            'tanggal_publish' => 'nullable|date',
            'status_arsip' => 'required|in:aktif,diarsipkan',
            'id_kategori' => 'nullable|exists:kategori_laporan,id_kategori',
        ]);

        if ($request->hasFile('gambar_berita')) {
            $data['gambar_berita'] = $this->storeBeritaImage($request);
        }

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
            'gambar_berita' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
            'tanggal_publish' => 'nullable|date',
            'status_arsip' => 'required|in:aktif,diarsipkan',
        ]);

        if ($request->hasFile('gambar_berita')) {
            $this->deleteBeritaImage($berita->gambar_berita);
            $data['gambar_berita'] = $this->storeBeritaImage($request);
        }

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

        $this->deleteBeritaImage($berita->gambar_berita);
        $berita->delete();

        return redirect()->route('petugas.berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function exportPdfBerita(Request $request)
    {
        // 1. Ambil relasi (sesuaikan jika nama relasi kategori Anda berbeda)
        $query = Berita::with(['kategori']);

        // 2. Terapkan filter pencarian yang sama dengan fungsi index()
        if ($request->filled('q')) {
            $query->where('judul_berita', 'like', '%' . $request->q . '%');
        }

        // 3. Terapkan filter status
        if ($request->filled('status')) {
            $query->where('status_arsip', $request->status);
        }

        // 4. (Opsional) Jika hanya ingin mengekspor berita milik petugas yang login
        // $query->where('id_petugas', Auth::guard('petugas')->id());

        // 5. Ambil semua data hasil filter
        $berita = $query->orderBy('tanggal_publish', 'desc')->get();

        // 6. Generate PDF
        $pdf = Pdf::loadView('petugas.v_berita.pdf', compact('berita'));

        return $pdf->stream('Rekap-Berita-SIMBO-' . date('Y-m-d') . '.pdf');
    }

    private function findBeritaPetugas(int $id): Berita
    {
        $petugas = Auth::guard('petugas')->user();

        return Berita::where('id_berita', $id)
            ->where('id_petugas', $petugas->id_petugas)
            ->firstOrFail();
    }

    private function findLaporanPetugas(int $id): Laporan
    {
        $petugas = Auth::guard('petugas')->user();

        return Laporan::with(['masyarakat', 'kategori'])
            ->where('id_laporan', $id)
            ->where('id_petugas', $petugas->id_petugas)
            ->firstOrFail();
    }

    private function storeBeritaImage(Request $request): string
    {
        $file = $request->file('gambar_berita');
        $filename = now()->format('YmdHis') . '_' . Str::random(12) . '.' . $file->getClientOriginalExtension();
        $destination = public_path('uploads/berita');

        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $filename);

        return 'uploads/berita/' . $filename;
    }

    private function deleteBeritaImage(?string $path): void
    {
        if (! $path) {
            return;
        }

        $publicFile = public_path($path);
        if (file_exists($publicFile)) {
            @unlink($publicFile);
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
