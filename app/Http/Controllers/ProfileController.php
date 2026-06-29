<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileMasyarakatController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return view('v_profile.index', compact('user'));
    }

    public function update(Request $request)
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