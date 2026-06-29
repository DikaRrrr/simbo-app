<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\FotoLaporan;
use App\Models\KategoriLaporan;
use App\Models\Laporan;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MasyarakatController extends Controller
{

    public function index()
    {
        $userId = auth()->id();

        // ── Statistik laporan milik user ini ──────────────────────────
        $totalLaporan    = Laporan::where('id_masyarakat', $userId)->count();
        $diprosesLaporan = Laporan::where('id_masyarakat', $userId)
            ->where('status_laporan', 'Diproses')->count();
        $selesaiLaporan  = Laporan::where('id_masyarakat', $userId)
            ->where('status_laporan', 'Selesai')->count();

        // ── 5 Aktivitas terbaru berdasarkan laporan user ───────────────
        $aktivitasTerbaru = Laporan::where('id_masyarakat', $userId)
            ->with('kategori')
            ->latest('updated_at')
            ->take(5)
            ->get();

        // ── 3 Berita terbaru yang aktif ────────────────────────────────
        $beritaTerbaru = \App\Models\Berita::with('kategori')
            ->where('status_arsip', 'aktif') // Pastikan hanya berita aktif
            ->latest('tanggal_publish')
            ->take(3) // Misalnya ambil 3 berita terbaru
            ->get();

        return view('masyarakat.v_beranda.index', compact(
            'totalLaporan',
            'diprosesLaporan',
            'selesaiLaporan',
            'aktivitasTerbaru',
            'beritaTerbaru',
        ));
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
            'detail'     => 'required|string|',
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

    public function aktivitasIndex(Request $request)
    {
        $userId = auth()->id();

        // Filter status (opsional dari query string)
        $statusFilter = $request->query('status');

        $query = Laporan::where('id_masyarakat', $userId)
            ->with(['kategori', 'fotoUtama'])
            ->latest('updated_at');

        if ($statusFilter && $statusFilter !== 'semua') {
            $query->where('status_laporan', ucfirst($statusFilter));
        }

        $laporan = $query->paginate(10);

        // Hitung jumlah per status untuk tab counter
        $counter = [
            'semua'    => Laporan::where('id_masyarakat', $userId)->count(),
            'menunggu' => Laporan::where('id_masyarakat', $userId)->where('status_laporan', 'Menunggu')->count(),
            'diproses' => Laporan::where('id_masyarakat', $userId)->where('status_laporan', 'Diproses')->count(),
            'selesai'  => Laporan::where('id_masyarakat', $userId)->where('status_laporan', 'Selesai')->count(),
            'ditolak'  => Laporan::where('id_masyarakat', $userId)->where('status_laporan', 'Ditolak')->count(),
        ];

        return view('masyarakat.v_aktivitas.index', compact('laporan', 'counter', 'statusFilter'));
    }

    public function aktivitasDetail($id)
    {
        $userId = auth()->id();

        // Pastikan laporan ini milik user yang login
        $laporan = Laporan::where('id_masyarakat', $userId)
            ->with([
                'kategori',
                'fotoLaporan',  // hasMany — semua foto
                'fotoUtama',    // hasOne  — foto pertama (milik warga)
                'masyarakat',
                'petugas',      // relasi ke user_petugas jika ada
            ])
            ->findOrFail($id);

        // Pisahkan catatan admin dan catatan petugas
        $catatanPecah   = explode("\n\n--- Catatan Petugas ---\n", $laporan->catatan_laporan ?? '');
        $catatanAdmin   = trim($catatanPecah[0] ?? '');
        $catatanPetugas = trim($catatanPecah[1] ?? '');

        // Foto penyelesaian dari petugas (foto kedua di tabel)
        $fotoPenyelesaian = $laporan->fotoLaporan->count() > 1
            ? $laporan->fotoLaporan->last()
            : null;

        // Timeline history status (jika kamu punya tabel aktivitas/log)
        // Jika tidak ada tabel khusus, kita simulasikan dari data laporan
        $timeline = collect([
            [
                'status'    => 'Laporan Masuk',
                'desc'      => 'Laporan Anda berhasil dikirim ke sistem SIMBO.',
                'waktu'     => $laporan->created_at,
                'done'      => true,
                'icon'      => 'ph-paper-plane-right',
                'color'     => 'bg-neutral',
            ],
            [
                'status'    => 'Ditinjau Admin',
                'desc'      => !empty($catatanAdmin)
                    ? $catatanAdmin
                    : 'Admin sedang meninjau laporan Anda.',
                'waktu'     => in_array($laporan->status_laporan, ['Diproses', 'Selesai'])
                    ? $laporan->updated_at
                    : null,
                'done'      => in_array($laporan->status_laporan, ['Diproses', 'Selesai', 'Ditolak']),
                'icon'      => 'ph-shield-check',
                'color'     => 'bg-blue-500',
            ],
            [
                'status'    => 'Ditangani Petugas',
                'desc'      => !empty($catatanPetugas)
                    ? $catatanPetugas
                    : 'Petugas lapangan sedang menangani masalah.',
                'waktu'     => $laporan->status_laporan === 'Selesai'
                    ? $laporan->updated_at
                    : null,
                'done'      => $laporan->status_laporan === 'Selesai',
                'icon'      => 'ph-hard-hat',
                'color'     => 'bg-amber-500',
            ],
            [
                'status'    => 'Laporan Selesai',
                'desc'      => 'Masalah telah berhasil ditangani. Terima kasih telah melaporkan!',
                'waktu'     => $laporan->status_laporan === 'Selesai'
                    ? $laporan->updated_at
                    : null,
                'done'      => $laporan->status_laporan === 'Selesai',
                'icon'      => 'ph-check-circle',
                'color'     => 'bg-green-600',
            ],
        ]);

        // Jika ditolak, override timeline
        if ($laporan->status_laporan === 'Ditolak') {
            $timeline = collect([
                [
                    'status' => 'Laporan Masuk',
                    'desc'   => 'Laporan Anda berhasil dikirim ke sistem SIMBO.',
                    'waktu'  => $laporan->created_at,
                    'done'   => true,
                    'icon'   => 'ph-paper-plane-right',
                    'color'  => 'bg-neutral',
                ],
                [
                    'status' => 'Ditolak oleh Admin',
                    'desc'   => !empty($catatanAdmin)
                        ? $catatanAdmin
                        : 'Laporan tidak dapat diproses oleh admin.',
                    'waktu'  => $laporan->updated_at,
                    'done'   => true,
                    'icon'   => 'ph-x-circle',
                    'color'  => 'bg-red-500',
                ],
            ]);
        }

        return view('masyarakat.v_aktivitas.detail', compact(
            'laporan',
            'catatanAdmin',
            'catatanPetugas',
            'fotoPenyelesaian',
            'timeline'
        ));
    }


    public function beritaIndex(Request $request)
    {
        // 1. Ambil data kategori untuk tombol filter
        $kategoris = KategoriLaporan::all();

        // 2. Query dasar: Ambil berita yang aktif dan relasi kategorinya
        $query = Berita::with('kategori')->where('status_arsip', 'aktif');

        // 3. Fitur Pencarian (Search Bar)
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul_berita', 'like', "%{$keyword}%")
                    ->orWhere('isi_berita', 'like', "%{$keyword}%");
            });
        }

        // 4. Fitur Filter Kategori (berdasarkan klik tombol kategori)
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // 5. Eksekusi query dengan urutan terbaru dan pagination (misal 6 per halaman)
        $beritas = $query->latest('tanggal_publish')->paginate(6)->withQueryString();

        return view('masyarakat.v_berita.index', compact('beritas', 'kategoris'));
    }

    public function beritaShow($id)
    {
        // Mengambil data berita beserta relasi kategorinya
        // Pastikan statusnya aktif agar berita yang diarsipkan tidak bisa diakses publik
        $berita = \App\Models\Berita::with('kategori')
            ->where('status_arsip', 'aktif')
            ->findOrFail($id);

        return view('masyarakat.v_berita.show', compact('berita'));
    }

    public function notifikasiIndex()
    {
        return view('masyarakat.v_notifikasi.index', ['pageTitle' => 'Notifikasi']);
    }

    public function profileIndex()
    {
        $user = Auth::user();

        return view('masyarakat.v_profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('user_masyarakat', 'email')->ignore($user->id_masyarakat, 'id_masyarakat'),
            ],
            'no_hp' => ['required', 'string', 'max:20'],
            'nik' => [
                'required',
                'string',
                'max:20',
                Rule::unique('user_masyarakat', 'nik')->ignore($user->id_masyarakat, 'id_masyarakat'),
            ],
            'pekerjaan' => ['nullable', 'string', 'max:100'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'kelurahan' => ['nullable', 'string', 'max:100'],
            'alamat' => ['required', 'string', 'max:1000'],
            'foto_profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'password_saat_ini' => ['nullable', 'required_with:password_baru', 'string'],
            'password_baru' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'foto_profile.max' => 'Ukuran foto maksimal 2MB.',
            'foto_profile.image' => 'File yang diunggah harus berupa gambar.',
            'foto_profile.mimes' => 'Format foto harus JPG, JPEG, atau PNG.',
            'password_saat_ini.required_with' => 'Kata sandi saat ini wajib diisi saat mengganti kata sandi.',
            'password_baru.confirmed' => 'Konfirmasi kata sandi baru tidak sama.',
        ]);

        if ($request->filled('password_baru')) {
            if (! Hash::check($request->password_saat_ini, $user->password)) {
                return back()
                    ->withErrors(['password_saat_ini' => 'Kata sandi saat ini tidak sesuai.'])
                    ->withInput();
            }

            $validated['password'] = Hash::make($request->password_baru);
        }

        if ($request->boolean('remove_photo') && $user->foto_profile) {
            Storage::disk('public')->delete($user->foto_profile);
            $validated['foto_profile'] = null;
        }

        if ($request->hasFile('foto_profile')) {
            if ($user->foto_profile) {
                Storage::disk('public')->delete($user->foto_profile);
            }

            $validated['foto_profile'] = $request->file('foto_profile')->store('profile-masyarakat', 'public');
        }

        unset($validated['password_saat_ini'], $validated['password_baru'], $validated['password_baru_confirmation']);

        $user->update($validated);

        return redirect()
            ->route('masyarakat.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
