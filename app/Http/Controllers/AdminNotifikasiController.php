<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\UserMasyarakat;
use Illuminate\Http\Request;

class AdminNotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Notifikasi::with('masyarakat')->latest();

        // Filter pencarian berdasarkan judul atau isi
        if ($request->filled('q')) {
            $query->where('judul_notifikasi', 'like', '%' . $request->q . '%')
                  ->orWhere('isi_notifikasi', 'like', '%' . $request->q . '%');
        }

        $notifikasi = $query->paginate(15)->withQueryString();

        return view('admin.v_notifikasi.index', compact('notifikasi'));
    }

    public function create()
    {
        // Ambil data masyarakat untuk opsi dropdown "Kirim ke Pengguna Spesifik"
        $masyarakat = UserMasyarakat::select('id_masyarakat', 'nama_lengkap', 'email')->get();
        return view('admin.v_notifikasi.create', compact('masyarakat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'target_user'      => 'required', // 'semua' atau ID spesifik
            'judul_notifikasi' => 'required|string|max:100',
            'isi_notifikasi'   => 'required|string',
            'tipe_notifikasi'  => 'required|in:pengumuman,sistem',
            'link_target'      => 'nullable|url'
        ]);

        if ($request->target_user === 'semua') {
            // Logika Broadcast ke Semua Pengguna (Bulk Insert)
            $semuaMasyarakat = UserMasyarakat::pluck('id_masyarakat');
            $dataNotifikasi = [];
            
            foreach ($semuaMasyarakat as $id_masy) {
                $dataNotifikasi[] = [
                    'id_masyarakat'    => $id_masy,
                    'judul_notifikasi' => $request->judul_notifikasi,
                    'isi_notifikasi'   => $request->isi_notifikasi,
                    'tipe_notifikasi'  => $request->tipe_notifikasi,
                    'link_target'      => $request->link_target,
                    'status_baca'      => false,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ];
            }
            Notifikasi::insert($dataNotifikasi);
            $pesan = 'Notifikasi berhasil disiarkan ke semua pengguna!';

        } else {
            // Logika Kirim ke Satu Pengguna
            Notifikasi::create([
                'id_masyarakat'    => $request->target_user,
                'judul_notifikasi' => $request->judul_notifikasi,
                'isi_notifikasi'   => $request->isi_notifikasi,
                'tipe_notifikasi'  => $request->tipe_notifikasi,
                'link_target'      => $request->link_target,
            ]);
            $pesan = 'Notifikasi berhasil dikirim ke pengguna terpilih!';
        }

        return redirect()->route('admin.notifikasi.index')->with('success', $pesan);
    }

    public function destroy($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $notifikasi->delete();

        return redirect()->route('admin.notifikasi.index')->with('success', 'Data notifikasi berhasil dihapus.');
    }
}
