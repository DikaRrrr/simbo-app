<?php

namespace App\Http\Controllers;

use App\Models\UserAdmin;
use App\Models\UserMasyarakat;
use App\Models\UserPetugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
}
