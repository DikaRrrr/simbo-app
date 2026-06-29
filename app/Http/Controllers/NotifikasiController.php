<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\UserMasyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{

    public function registerMasyarakat(Request $request)
    {
        // ... (Kode insert data pendaftaran user baru) ...
        $userBaru = UserMasyarakat::create([ /* ... */]);

        // --- TRIGGER NOTIFIKASI SISTEM ---
        Notifikasi::create([
            'id_masyarakat'   => $userBaru->id_masyarakat,
            'id_laporan'      => null,
            'tipe_notifikasi' => 'sistem',
            'judul_notifikasi'=> 'Selamat Datang di SIMBO!',
            'isi_notifikasi'  => "Selamat datang di SIMBO! Akun Anda berhasil didaftarkan. Lengkapi profil Anda untuk mulai membuat laporan.",
            'link_target'     => route('profil.index'), // Arahkan ke halaman profil
        ]);

        // Login otomatis atau arahkan ke halaman login
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil!');
    }
    // Pastikan Anda menyesuaikan Auth guard dengan yang Anda gunakan untuk masyarakat
    // Misalnya: auth()->guard('masyarakat')->id() atau auth()->id()

    public function index()
    {
        $userId = auth()->id(); // Ambil ID Masyarakat yang login

        // Ambil notifikasi, urutkan dari yang terbaru
        $notifikasi = Notifikasi::where('id_masyarakat', $userId)
            ->latest()
            ->paginate(10);

        // Hitung jumlah notifikasi yang belum dibaca
        $unreadCount = Notifikasi::where('id_masyarakat', $userId)
            ->where('status_baca', false)
            ->count();

        return view('masyarakat.v_notifikasi.index', compact('notifikasi', 'unreadCount'));
    }

    public function markAsRead($id)
    {
        $notif = Notifikasi::where('id_masyarakat', auth()->id())->findOrFail($id);

        // Jika belum dibaca, ubah statusnya menjadi sudah dibaca
        if (!$notif->status_baca) {
            $notif->update(['status_baca' => true]);
        }

        // Redirect ke link tujuan notifikasi (misal: halaman detail laporan)
        // Jika link_target kosong, kembali ke halaman notifikasi
        if ($notif->link_target) {
            return redirect($notif->link_target);
        }

        return redirect()->route('notifikasi.index');
    }

    public function markAllAsRead()
    {
        // Ubah semua notifikasi milik user ini yang statusnya false menjadi true
        Notifikasi::where('id_masyarakat', auth()->id())
            ->where('status_baca', false)
            ->update(['status_baca' => true]);

        return redirect()->route('notifikasi.index')->with('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    }
}
