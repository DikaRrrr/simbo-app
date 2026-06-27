@extends('admin.v_layouts.app')

@section('title', 'Tambah Pengguna - Admin SIMBO')

<main class="ml-[250px] w-[calc(100%-250px)] bg-dash-secondary min-h-screen font-worksans p-8">

    <a href="{{ url('/admin/pengguna') }}"
        class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-primary transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Manajemen Pengguna
    </a>

    <div class="mb-8">
        <h2 class="font-montserrat text-3xl font-extrabold text-neutral tracking-wide">
            Tambah Pengguna Baru
        </h2>
        <p class="text-sm text-gray-500 mt-2">
            Daftarkan entitas pengguna baru ke dalam sistem SIMBO berdasarkan peran spesifik.
        </p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-[1fr_320px] gap-8 max-w-6xl">

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden h-fit">

            <div class="h-1.5 w-full bg-primary"></div>

            <form action="{{ route('admin.pengguna.store') }}" method="POST" class="p-6 md:p-8">
                @csrf

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
                        <label class="block text-sm font-bold text-neutral mb-4">
                            Pilih Peran Pengguna
                        </label>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            <label class="cursor-pointer relative">
                                <input type="radio" name="role" value="admin" class="peer sr-only"
                                    {{ old('role') == 'admin' ? 'checked' : '' }}>
                                <div
                                    class="h-full border-2 border-gray-200 rounded-xl bg-white px-4 py-4 peer-checked:border-primary peer-checked:bg-primary/5 hover:border-primary/50 transition-all">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="mt-0.5 w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-primary shrink-0">
                                            <div class="w-2 h-2 rounded-full bg-primary hidden peer-checked:block">
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-neutral">Administrator</p>
                                            <p
                                                class="text-[10px] font-semibold uppercase tracking-wide text-gray-500 mt-1">
                                                Akses Penuh</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer relative">
                                <input type="radio" name="role" value="petugas" class="peer sr-only"
                                    {{ old('role') == 'petugas' ? 'checked' : '' }}>
                                <div
                                    class="h-full border-2 border-gray-200 rounded-xl bg-white px-4 py-4 peer-checked:border-primary peer-checked:bg-primary/5 hover:border-primary/50 transition-all">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="mt-0.5 w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-primary shrink-0">
                                            <div class="w-2 h-2 rounded-full bg-primary hidden peer-checked:block">
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-neutral">Petugas Lapangan</p>
                                            <p
                                                class="text-[10px] font-semibold uppercase tracking-wide text-gray-500 mt-1">
                                                Operasional</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer relative">
                                <input type="radio" name="role" value="masyarakat" class="peer sr-only"
                                    {{ old('role') == 'masyarakat' ? 'checked' : '' }}>
                                <div
                                    class="h-full border-2 border-gray-200 rounded-xl bg-white px-4 py-4 peer-checked:border-primary peer-checked:bg-primary/5 hover:border-primary/50 transition-all">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="mt-0.5 w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-primary shrink-0">
                                            <div class="w-2 h-2 rounded-full bg-primary hidden peer-checked:block">
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-neutral">Masyarakat</p>
                                            <p
                                                class="text-[10px] font-semibold uppercase tracking-wide text-gray-500 mt-1">
                                                Pelapor Laporan</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                        </div>
                    </div>
                </section>

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

                        <div id="form-masyarakat" class="space-y-5 transition-all">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-neutral mb-2">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" placeholder="Contoh: Budi Santoso"
                                        value="{{ old('nama_lengkap') }}"
                                        class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-neutral mb-2">Alamat Email</label>
                                    <input type="email" name="email" placeholder="budi@email.com"
                                        value="{{ old('email') }}"
                                        class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-neutral mb-2">NIK</label>
                                    <input type="text" name="nik" placeholder="16 digit NIK"
                                        value="{{ old('nik') }}"
                                        class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-neutral mb-2">Nomor HP</label>
                                    <input type="text" name="no_hp" placeholder="081234567890"
                                        value="{{ old('no_hp') }}"
                                        class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-neutral mb-2">Password</label>
                                    <input type="password" name="password"
                                        placeholder="Buat password untuk masyarakat"
                                        class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-neutral mb-2">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" placeholder="Masukkan alamat domisili lengkap" value="{{ old('alamat') }}"
                                    class="w-full rounded-xl border border-gray-300 bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all resize-none"></textarea>
                            </div>
                        </div>

                        <div id="form-admin" class="space-y-5 hidden transition-all">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-neutral mb-2">Nama Admin</label>
                                    <input type="text" name="nama_admin" placeholder="Nama lengkap admin"
                                        value="{{ old('nama_admin') }}"
                                        class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-neutral mb-2">Email Admin</label>
                                    <input type="email" name="email" placeholder="Email admin"
                                        value="{{ old('email') }}"
                                        class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-neutral mb-2">Password Login</label>
                                    <input type="password" name="password" placeholder="Buat password yang kuat"
                                        class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                </div>
                            </div>
                        </div>

                        <div id="form-petugas" class="space-y-5 hidden transition-all">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-neutral mb-2">Nama Petugas</label>
                                    <input type="text" name="nama_petugas" placeholder="Nama lengkap petugas"
                                        value="{{ old('nama_petugas') }}"
                                        class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-neutral mb-2">Email Petugas</label>
                                    <input type="email" name="email" placeholder="Email petugas"
                                        value="{{ old('email') }}"
                                        class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-neutral mb-2">Wilayah Tugas</label>
                                    <div class="relative">
                                        <select name="wilayah_tugas"
                                            class="w-full h-12 appearance-none rounded-xl border border-gray-300 bg-inputBg px-4 text-sm font-medium text-neutral outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all cursor-pointer">
                                            <option value="" disabled selected>Pilih wilayah penugasan...
                                            </option>
                                            <option value="Bogor Tengah">Kecamatan Bogor Tengah</option>
                                            <option value="Bogor Timur">Kecamatan Bogor Timur</option>
                                            <option value="Bogor Selatan">Kecamatan Bogor Selatan</option>
                                            <option value="Bogor Barat">Kecamatan Bogor Barat</option>
                                            <option value="Bogor Utara">Kecamatan Bogor Utara</option>
                                            <option value="Tanah Sareal">Kecamatan Tanah Sareal</option>
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
                                    <label class="block text-sm font-bold text-neutral mb-2">Password Login</label>
                                    <input type="password" name="password" placeholder="Buat password petugas"
                                        class="w-full h-12 rounded-xl border border-gray-300 bg-inputBg px-4 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <section class="mt-8 border-t border-gray-100 pt-6">
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <div>
                            <h3 class="text-sm font-bold text-neutral">
                                Status Akun Langsung Aktif?
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">
                                Jika diaktifkan, pengguna dapat langsung login ke dalam sistem.
                            </p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">

                            {{-- Nilai default "Tidak Aktif" jika checkbox tidak dicentang --}}
                            <input type="hidden" name="status_akun" value="Tidak Aktif">

                            <input type="checkbox" name="status_akun" value="Aktif" class="sr-only peer" checked>
                            <div
                                class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:bg-primary transition-colors">
                            </div>
                            <div
                                class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-5">
                            </div>
                        </label>
                    </div>
                </section>

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
                        Simpan Pengguna
                    </button>
                </div>

            </form>
        </div>

        <aside class="bg-primary/5 border border-primary/20 rounded-2xl h-fit p-6 shadow-sm">
            <div class="flex items-center gap-2 text-primary mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="font-montserrat text-lg font-bold">
                    Panduan Registrasi
                </h3>
            </div>

            <p class="text-sm text-neutral/80 leading-relaxed">
                Pastikan data kredensial (<strong class="text-primary">Email</strong> atau <strong
                    class="text-primary">Username</strong>) yang dimasukkan unik dan belum pernah didaftarkan untuk
                menghindari bentrok data di dalam database.
            </p>

            <ul class="mt-6 space-y-4 text-sm text-neutral/70 font-medium">
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Formulir otomatis menyesuaikan struktur tabel database berdasarkan peran.</span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Password akan di-enkripsi secara otomatis menggunakan Hash (Bcrypt).</span>
                </li>
            </ul>
        </aside>

    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const radios = document.querySelectorAll('input[name="role"]');
        const forms = {
            'admin': document.getElementById('form-admin'),
            'petugas': document.getElementById('form-petugas'),
            'masyarakat': document.getElementById('form-masyarakat')
        };

        function updateFormVisibility(selectedRole) {
            // Loop untuk semua form
            for (const [role, element] of Object.entries(forms)) {
                const inputs = element.querySelectorAll('input, select, textarea');

                if (role === selectedRole) {
                    element.classList.remove('hidden'); // Tampilkan
                    inputs.forEach(el => {
                        el.disabled = false; // Aktifkan input agar dikirim
                        el.required = true; // Wajib diisi
                    });
                } else {
                    element.classList.add('hidden'); // Sembunyikan
                    inputs.forEach(el => {
                        el.disabled = true; // MATIKAN input agar TIDAK dikirim
                        el.required = false;
                    });
                }
            }
        }

        // Listener untuk radio
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                updateFormVisibility(this.value);
            });
        });

        // Jalankan saat pertama dimuat
        const checkedRadio = document.querySelector('input[name="role"]:checked');
        if (checkedRadio) updateFormVisibility(checkedRadio.value);
    });
</script>
