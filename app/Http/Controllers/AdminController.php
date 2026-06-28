<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriLaporan;
use App\Models\Laporan;
use App\Models\UserAdmin;
use App\Models\UserMasyarakat;
use App\Models\UserPetugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Login menggunakan guard 'admin'
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/admin/dashboard')->with('success', 'Selamat datang Admin!');
        }

        return back()->withErrors(['email' => 'Login gagal!']);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    public function identifikasiIndex()
    {
        $laporans = Laporan::where('status_laporan', 'Menunggu')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.v_laporan.index', compact('laporans'), ['pageTitle' => 'Identifikasi Laporan']);
    }

    // 1. Method untuk menampilkan halaman detail penugasan
    public function detailIdentifikasi($id)
    {
        // Tambahkan 'fotoLaporan' dan 'kategori' agar datanya terbawa ke View
        $laporan = Laporan::with(['masyarakat', 'fotoLaporan', 'fotoUtama', 'kategori'])->findOrFail($id);

        // Sesuaikan dengan model petugas kamu
        $petugas = UserPetugas::where('status_akun', 'Aktif')->get();

        return view('admin.v_laporan.detail', compact('laporan', 'petugas'));
    }

    // 2. Method untuk memproses penugasan
    public function assignPetugas(Request $request, $id)
    {
        $request->validate([
            'petugas_id'    => 'required',
            'prioritas'     => 'required|in:rendah,sedang,tinggi,Rendah,Sedang,Tinggi',
            'catatan_admin' => 'nullable|string'
        ]);

        $laporan = Laporan::findOrFail($id);

        // Update data laporan
        $laporan->update([
            'id_admin'          => auth()->id(), // PENTING: Mencatat admin siapa yang menugaskan (Gunakan guard jika perlu, misal auth()->guard('admin')->id())
            'id_petugas'        => $request->petugas_id,
            'status_laporan'    => 'Diproses',
            'prioritas_laporan' => ucfirst(strtolower($request->prioritas)), // Memastikan format selalu: Rendah, Sedang, Tinggi
            'catatan_laporan'   => $request->catatan_admin,
        ]);

        // Pastikan nama route ini sesuai dengan di web.php kamu
        return redirect()->route('identifikasi.index')
            ->with('success', 'Laporan berhasil ditugaskan ke petugas!');
    }

    public function tolakLaporan(Request $request, $id)
    {
        // Validasi agar alasan penolakan wajib diisi
        $request->validate([
            'catatan_penolakan' => 'required|string|min:10'
        ], [
            'catatan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'catatan_penolakan.min' => 'Alasan penolakan minimal berisi 10 karakter.'
        ]);

        $laporan = Laporan::findOrFail($id);

        // Update status menjadi Ditolak
        $laporan->update([
            'id_admin'        => auth()->id(), // Mencatat admin yang menolak
            'status_laporan'  => 'Ditolak',    // Sesuai dengan ENUM di migration Anda
            'catatan_laporan' => $request->catatan_penolakan,
        ]);

        return redirect()->route('identifikasi.index')
            ->with('success', 'Laporan #' . str_pad($laporan->id_laporan, 4, '0', STR_PAD_LEFT) . ' telah ditolak.');
    }

    public function indexPengguna()
    {
        $admins = UserAdmin::all()->map(function ($user) {
            return [
                'id' => $user->id_admin ?? $user->id,
                'nama' => $user->nama_admin,
                'email' => $user->email,
                'role' => 'Admin',
                'role_key' => 'admin',
                'status' => $user->status_akun ?? 'Aktif',
                'created_at' => $user->created_at,
            ];
        });

        $petugas = UserPetugas::all()->map(function ($user) {
            return [
                'id' => $user->id_petugas ?? $user->id,
                'nama' => $user->nama_petugas,
                'email' => $user->email,
                'role' => 'Petugas Lapangan',
                'role_key' => 'petugas',
                'status' => $user->status_akun ?? 'Aktif',
                'created_at' => $user->created_at,
            ];
        });

        $masyarakat = UserMasyarakat::all()->map(function ($user) {
            return [
                'id' => $user->id_masyarakat ?? $user->id,
                'nama' => $user->nama_lengkap,
                'email' => $user->email,
                'role' => 'Masyarakat',
                'role_key' => 'masyarakat',
                'status' => $user->status_akun ?? 'Aktif',
                'created_at' => $user->created_at,
            ];
        });

        // Gabungkan ketiga data
        $semuaPengguna = $admins->concat($petugas)->concat($masyarakat)->sortByDesc('created_at');

        return view('admin.v_pengguna.index', compact('semuaPengguna'), ['pageTitle' => 'Manajemen Pengguna']);
    }

    public function storePengguna(Request $request)
    {
        $role = $request->role;

        $request->validate([
            'role' => 'required|in:admin,petugas,masyarakat'
        ]);

        $statusAkun = $request->input('status_akun') === 'Aktif' ? 'Aktif' : 'Nonaktif';

        if ($role === 'masyarakat') {
            $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'email'        => 'required|email|unique:user_masyarakat,email',
                'nik'          => 'required|numeric|unique:user_masyarakat,nik',
                'no_hp'        => 'required|numeric',
                'password'     => 'required|min:6',
                'alamat'       => 'required|string',
            ]);

            UserMasyarakat::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email'        => $request->email,
                'nik'          => $request->nik,
                'no_hp'        => $request->no_hp,
                'password'     => Hash::make($request->password),
                'alamat'       => $request->alamat,
                'status_akun'  => $statusAkun,
            ]);
        } elseif ($role === 'admin') {
            $request->validate([
                'nama_admin' => 'required|string|max:255',
                'email'      => 'required|email|unique:user_admin,email',
                'password'   => 'required|min:6',
            ]);

            UserAdmin::create([
                'nama_admin'  => $request->nama_admin,
                'email'       => $request->email,
                'password'    => Hash::make($request->password),
                'status_akun' => $statusAkun, // ✅ fix
            ]);
        } elseif ($role === 'petugas') {
            $request->validate([
                'nama_petugas'  => 'required|string|max:255',
                'email'         => 'required|email|unique:user_petugas,email',
                'wilayah_tugas' => 'required|string',
                'password'      => 'required|min:6',
            ]);

            UserPetugas::create([
                'nama_petugas'  => $request->nama_petugas,
                'email'         => $request->email,
                'wilayah_tugas' => $request->wilayah_tugas,
                'password'      => Hash::make($request->password),
                'status_akun'   => $statusAkun, // ✅ fix
            ]);
        }

        return redirect()->back()->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function editPengguna($role, $id)
    {
        $user = match ($role) {
            'admin'      => UserAdmin::findOrFail($id),
            'petugas'    => UserPetugas::findOrFail($id),
            'masyarakat' => UserMasyarakat::findOrFail($id),
            default      => abort(404),
        };

        return view('admin.v_pengguna.edit', compact('user', 'role'), ['pageTitle' => 'Edit Pengguna']);
    }

    public function updatePengguna(Request $request, $role, $id)
    {
        $statusAkun = $request->input('status_akun') === 'Aktif' ? 'Aktif' : 'Nonaktif';

        if ($role === 'masyarakat') {
            $user = UserMasyarakat::findOrFail($id);

            $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'email'        => 'required|email|unique:user_masyarakat,email,' . $id . ',id_masyarakat',
                'nik'          => 'required|numeric|unique:user_masyarakat,nik,' . $id . ',id_masyarakat',
                'no_hp'        => 'required|numeric',
                'password'     => 'nullable|min:6',
                'alamat'       => 'required|string',
            ]);

            $data = [
                'nama_lengkap' => $request->nama_lengkap,
                'email'        => $request->email,
                'nik'          => $request->nik,
                'no_hp'        => $request->no_hp,
                'alamat'       => $request->alamat,
                'status_akun'  => $statusAkun,
            ];
        } elseif ($role === 'admin') {
            $user = UserAdmin::findOrFail($id);

            $request->validate([
                'nama_admin' => 'required|string|max:255',
                'email'      => 'required|email|unique:user_admin,email,' . $id . ',id_admin',
                'password'   => 'nullable|min:6',
            ]);

            $data = [
                'nama_admin'  => $request->nama_admin,
                'email'       => $request->email,
                'status_akun' => $statusAkun,
            ];
        } elseif ($role === 'petugas') {
            $user = UserPetugas::findOrFail($id);

            $request->validate([
                'nama_petugas'  => 'required|string|max:255',
                'email'         => 'required|email|unique:user_petugas,email,' . $id . ',id_petugas',
                'wilayah_tugas' => 'required|string',
                'password'      => 'nullable|min:6',
            ]);

            $data = [
                'nama_petugas'  => $request->nama_petugas,
                'email'         => $request->email,
                'wilayah_tugas' => $request->wilayah_tugas,
                'status_akun'   => $statusAkun,
            ];
        } else {
            abort(404);
        }

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroyPengguna($role, $id)
    {
        try {
            if ($role === 'admin') {
                $user = UserAdmin::findOrFail($id);
            } elseif ($role === 'petugas') {
                $user = UserPetugas::findOrFail($id);
            } elseif ($role === 'masyarakat') {
                $user = UserMasyarakat::findOrFail($id);
            } else {
                return redirect()->back()->with('error', 'Peran pengguna tidak dikenali.');
            }

            $user->delete();

            return redirect()->back()->with('success', 'Pengguna berhasil dihapus dari sistem.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }

    // 1. Menampilkan Halaman Arsip Berita (dengan Filter & Pagination)
    public function indexBerita(Request $request)
    {
        // Ambil data kategori untuk dropdown filter
        $kategoriList = KategoriLaporan::all();

        // Query dasar berita
        $query = Berita::with('kategori')->latest('tanggal_publish');

        // Filter berdasarkan Pencarian (Judul)
        if ($request->filled('q')) {
            $query->where('judul_berita', 'like', '%' . $request->q . '%');
        }

        // Filter berdasarkan Kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter berdasarkan Rentang Waktu (Tanggal Publish)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_publish', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('tanggal_publish', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('tanggal_publish', '<=', $request->end_date);
        }

        // Pagination (misal 10 data per halaman), gunakan withQueryString agar filter tidak hilang saat pindah halaman
        $berita = $query->paginate(10)->withQueryString();

        return view('admin.v_berita.index', compact('berita', 'kategoriList'), ['pageTitle' => 'Manajemen Berita']);
    }

    public function createBerita()
    {
        // Mengambil kategori untuk ditampilkan di dropdown
        $kategoris = KategoriLaporan::all();

        return view('admin.v_berita.create', compact('kategoris'));
    }

    public function storeBerita(Request $request)
    {
        // Validasi data input
        $request->validate([
            'judul_berita'    => 'required|string|max:150',
            'isi_berita'      => 'required|string',
            'id_kategori'     => 'required|integer',
            'gambar_berita'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'tanggal_publish' => 'nullable|date',
            'status_arsip'    => 'required|in:aktif,diarsipkan',
        ]);

        // Proses upload gambar (jika ada)
        $namaGambar = null;
        if ($request->hasFile('gambar_berita')) {
            $file = $request->file('gambar_berita');
            $namaGambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/berita'), $namaGambar);
        }

        // Simpan ke database
        Berita::create([
            'judul_berita'    => $request->judul_berita,
            'isi_berita'      => $request->isi_berita,
            'id_kategori'     => $request->id_kategori,
            'gambar_berita'   => $namaGambar,
            'tanggal_publish' => $request->tanggal_publish ?? now(),
            'status_arsip'    => $request->status_arsip,
            'id_admin'     => auth()->id(), // Aktifkan jika tabel berita memerlukan ID Admin
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita baru berhasil diterbitkan!');
    }

    // 2. Menampilkan Form Edit
    public function editBerita($id)
    {
        $berita = Berita::findOrFail($id);
        $kategoris = KategoriLaporan::all();

        return view('admin.v_berita.edit', compact('berita', 'kategoris'), ['pageTitle' => 'Edit Berita']);
    }

    // 3. Memproses Update Data
    public function updateBerita(Request $request, $id)
    {
        $request->validate([
            'judul_berita'    => 'required|string|max:150',
            'isi_berita'      => 'required|string',
            'id_kategori'     => 'required|integer',
            'gambar_berita'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'tanggal_publish' => 'nullable|date',
            'status_arsip'    => 'required|in:aktif,diarsipkan',
        ]);

        $berita = Berita::findOrFail($id);
        $namaGambar = $berita->gambar_berita;

        // Jika admin mengupload gambar baru
        if ($request->hasFile('gambar_berita')) {
            // Hapus gambar lama jika ada
            if ($berita->gambar_berita && File::exists(public_path('uploads/berita/' . $berita->gambar_berita))) {
                File::delete(public_path('uploads/berita/' . $berita->gambar_berita));
            }

            // Upload gambar baru
            $file = $request->file('gambar_berita');
            $namaGambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/berita'), $namaGambar);
        }

        $berita->update([
            'judul_berita'    => $request->judul_berita,
            'isi_berita'      => $request->isi_berita,
            'id_kategori'     => $request->id_kategori,
            'gambar_berita'   => $namaGambar,
            'tanggal_publish' => $request->tanggal_publish ?? $berita->tanggal_publish,
            'status_arsip'    => $request->status_arsip,
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    // 4. Memproses Hapus Data
    public function destroyBerita($id)
    {
        $berita = Berita::findOrFail($id);

        // Hapus file gambar fisik
        if ($berita->gambar_berita && File::exists(public_path('uploads/berita/' . $berita->gambar_berita))) {
            File::delete(public_path('uploads/berita/' . $berita->gambar_berita));
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}
