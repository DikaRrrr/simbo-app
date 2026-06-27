@extends('admin.v_layouts.app')

@section('title', 'Edit Pengguna - Admin SIMBO')

<main class="ml-[250px] w-[calc(100%-250px)] bg-dash-secondary min-h-screen font-worksans p-8">

    <a href="{{ url('/admin/pengguna') }}"
        class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-primary transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Manajemen Pengguna
    </a>

    <div class="mb-8">
        <h2 class="font-montserrat text-3xl font-extrabold text-neutral tracking-wide">Edit Pengguna</h2>
        <p class="text-sm text-gray-500 mt-2">Perbarui data pengguna yang ada di dalam sistem SIMBO.</p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-[1fr_320px] gap-8 max-w-6xl">

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden h-fit">
            <div class="h-1.5 w-full bg-primary"></div>

            <form action="{{ route('admin.pengguna.update', ['role' => $role, 'id' => $user->getKey()]) }}"
                method="POST" class="p-6 md:p-8">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-bold">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            Terjadi kesalahan:
                        </div>
                        <ul class="list-disc pl-5 font-medium text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Peran (Read Only) --}}
                <section>
                    <h3 class="font-montserrat text-lg font-bold text-neutral flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        Peran & Akses
                    </h3>
                    <div class="border-t border-gray-100 mt-4 pt-5">
                        <p class="text-xs text-gray-400 mb-3">Peran pengguna tidak dapat diubah.</p>
                        <div
                            class="inline-flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-primary bg-primary/5">
                            @if ($role === 'admin')
                                <p class="text-sm font-bold text-primary">Administrator</p>
                                <span class="text-[10px] font-semibold uppercase tracking-wide text-gray-500">Akses
                                    Penuh</span>
                            @elseif ($role === 'petugas')
                                <p class="text-sm font-bold text-primary">Petugas Lapangan</p>
                                <span
                                    class="text-[10px] font-semibold uppercase tracking-wide text-gray-500">Operasional</span>
                            @else
                                <p class="text-sm font-bold text-primary">Masyarakat</p>
                                <span class="text-[10px] font-semibold uppercase tracking-wide text-gray-500">Pelapor
                                    Laporan</span>
                            @endif
                        </div>
                    </div>
                </section>

                {{-- Informasi Profil --}}
                <section class="mt-10">
                    <h3 class="font-montserrat text-lg font-bold text-neutral flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                            </path>
                        </svg>
                        Informasi Profil
                    </h3>

                    <div class="border-t border-gray-100 mt-4 pt-6">

                        @if ($role === 'masyarakat')
                            <div class="space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-bold text-neutral mb-2">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap"
                                            value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                                            class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-neutral mb-2">Alamat Email</label>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                            class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-neutral mb-2">NIK</label>
                                        <input type="text" name="nik" value="{{ old('nik', $user->nik) }}"
                                            class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-neutral mb-2">Nomor HP</label>
                                        <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                            class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-bold text-neutral mb-2">
                                            Password Baru
                                            <span class="text-xs font-normal text-gray-400 ml-1">
                                                (Kosongkan jika tidak ingin diubah)
                                            </span>
                                        </label>
                                        <input type="password" name="password" placeholder="Masukkan password baru..."
                                            class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-neutral mb-2">Alamat Lengkap</label>
                                    <textarea name="alamat" rows="3"
                                        class="w-full rounded-xl border border-gray-300 bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all resize-none">{{ old('alamat', $user->alamat) }}</textarea>
                                </div>
                            </div>
                        @elseif ($role === 'admin')
                            <div class="space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-bold text-neutral mb-2">Nama Admin</label>
                                        <input type="text" name="nama_admin"
                                            value="{{ old('nama_admin', $user->nama_admin) }}"
                                            class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-neutral mb-2">Email Admin</label>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                            class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-bold text-neutral mb-2">
                                            Password Baru
                                            <span class="text-xs font-normal text-gray-400 ml-1">
                                                (Kosongkan jika tidak ingin diubah)
                                            </span>
                                        </label>
                                        <input type="password" name="password"
                                            placeholder="Masukkan password baru..."
                                            class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                    </div>
                                </div>
                            </div>
                        @elseif ($role === 'petugas')
                            <div class="space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-bold text-neutral mb-2">Nama Petugas</label>
                                        <input type="text" name="nama_petugas"
                                            value="{{ old('nama_petugas', $user->nama_petugas) }}"
                                            class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-neutral mb-2">Email Petugas</label>
                                        <input type="email" name="email"
                                            value="{{ old('email', $user->email) }}"
                                            class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-neutral mb-2">Wilayah Tugas</label>
                                        <div class="relative">
                                            <select name="wilayah_tugas"
                                                class="w-full h-12 appearance-none rounded-xl border border-gray-300 bg-inputBg px-4 text-sm font-medium text-neutral outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all cursor-pointer">
                                                <option value="" disabled>Pilih wilayah penugasan...</option>
                                                @foreach (['Bogor Tengah', 'Bogor Timur', 'Bogor Selatan', 'Bogor Barat', 'Bogor Utara', 'Tanah Sareal'] as $wilayah)
                                                    <option value="{{ $wilayah }}"
                                                        {{ old('wilayah_tugas', $user->wilayah_tugas) == $wilayah ? 'selected' : '' }}>
                                                        Kecamatan {{ $wilayah }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-neutral mb-2">
                                            Password Baru
                                            <span class="text-xs font-normal text-gray-400 ml-1">
                                                (Kosongkan jika tidak ingin diubah)
                                            </span>
                                        </label>
                                        <input type="password" name="password"
                                            placeholder="Masukkan password baru..."
                                            class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </section>

                {{-- Status Akun --}}
                <section class="mt-8 border-t border-gray-100 pt-6">
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <div>
                            <h3 class="text-sm font-bold text-neutral">Status Akun Aktif?</h3>
                            <p class="text-xs text-gray-500 mt-1">Jika diaktifkan, pengguna dapat langsung login ke
                                dalam sistem.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="status_akun" value="Nonaktif">
                            <input type="checkbox" name="status_akun" value="Aktif" class="sr-only peer"
                                {{ old('status_akun', $user->status_akun) === 'Aktif' ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:bg-primary transition-colors">
                            </div>
                            <div
                                class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-5">
                            </div>
                        </label>
                    </div>
                </section>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ url('/admin/pengguna') }}"
                        class="px-6 py-3 rounded-xl border border-gray-300 bg-white text-gray-600 text-sm font-bold hover:bg-gray-50 transition-colors shadow-sm">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3 rounded-xl bg-primary text-white text-sm font-bold hover:bg-primary/90 hover:shadow-md transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

        {{-- Sidebar Panduan --}}
        <aside class="bg-primary/5 border border-primary/20 rounded-2xl h-fit p-6 shadow-sm">
            <div class="flex items-center gap-2 text-primary mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="font-montserrat text-lg font-bold">Panduan Edit</h3>
            </div>
            <p class="text-sm text-neutral/80 leading-relaxed">
                Kosongkan kolom <strong class="text-primary">Password</strong> jika tidak ingin mengubah kata sandi
                pengguna.
            </p>
            <ul class="mt-6 space-y-4 text-sm text-neutral/70 font-medium">
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Peran pengguna tidak dapat diubah untuk menjaga integritas data.</span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Email harus unik dan belum digunakan oleh pengguna lain.</span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <span>Password baru akan dienkripsi ulang menggunakan Bcrypt.</span>
                </li>
            </ul>
        </aside>

    </div>
</main>
