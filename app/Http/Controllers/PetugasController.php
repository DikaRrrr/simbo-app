<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    public function showLogin() { return view('petugas.login'); }

    public function login(Request $request) {
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

    public function logout(Request $request) {
        Auth::guard('petugas')->logout();
        return redirect('/petugas/login');
    }
}