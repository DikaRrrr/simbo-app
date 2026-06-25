<?php

namespace App\Http\Controllers;

use App\Models\UserMasyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // PROSES REGISTRASI
    public function register(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'nik' => 'required|unique:user_masyarakat,nik|max:16',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user_masyarakat,email',
            'nohp' => 'required|string|max:15',
            'password' => 'required|min:6',
            'alamat' => 'required|string',
        ]);

        // 2. Simpan ke database
        UserMasyarakat::create([
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->nohp,
            'password' => Hash::make($request->password), // Enkripsi password
            'alamat' => $request->alamat,
        ]);

        // 3. Alihkan ke halaman login dengan pesan sukses
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan masuk.');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Jika berhasil, arahkan ke beranda
            return redirect()->intended('/')->with('success', 'Berhasil masuk!');
        }

        // 3. Jika gagal, kembalikan ke halaman login beserta error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // PROSES LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
