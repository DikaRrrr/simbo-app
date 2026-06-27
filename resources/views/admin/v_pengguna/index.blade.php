@extends('admin.v_layouts.app')

@section('title', 'Manajemen Pengguna - Admin SIMBO')

<!-- Sesuaikan margin kiri (ml-[210px] atau ml-[250px]) dengan ukuran sidebar di layout-mu -->
<main class="ml-[250px] w-[calc(100%-250px)] bg-dash-secondary min-h-screen font-worksans p-8 pt-24">

    {{-- Header Page --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold font-montserrat text-neutral tracking-wide">
                Manajemen Pengguna
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Kelola hak akses dan peran pengguna dalam sistem SIMBO.
            </p>
        </div>
        <a href="{{ url('admin/pengguna/tambah') }}"
            class="bg-primary text-white px-6 py-3 rounded-xl text-sm font-bold hover:bg-primary/90 hover:shadow-md transition-all flex items-center justify-center gap-2 w-full sm:w-auto shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            Tambah Pengguna Baru
        </a>
    </div>

    <!-- Filter Box -->
    <div class="mt-8 bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">

            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto flex-1">
                <!-- Search Bar -->
                <div class="relative w-full sm:w-72 md:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" placeholder="Cari nama atau email..."
                        class="w-full h-11 rounded-xl border border-gray-300 bg-inputBg pl-11 pr-4 text-sm font-medium text-neutral outline-none focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary transition-all">
                </div>

                <!-- Dropdown Role -->
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <label
                        class="text-xs font-bold uppercase tracking-wider text-gray-500 whitespace-nowrap hidden sm:block">
                        Peran:
                    </label>
                    <div class="relative w-full sm:w-48">
                        <select
                            class="w-full h-11 appearance-none rounded-xl border border-gray-300 bg-white pl-4 pr-10 text-xs font-semibold text-gray-700 outline-none focus:border-primary focus:ring-1 focus:ring-primary cursor-pointer">
                            <option>Semua Peran</option>
                            <option>Admin</option>
                            <option>Petugas Lapangan</option>
                            <option>Masyarakat</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Pengaturan Lanjutan -->
            <button
                class="h-11 px-4 border border-gray-300 rounded-xl bg-white hover:bg-gray-50 text-gray-600 flex items-center gap-2 text-xs font-bold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                    </path>
                </svg>
                <span class="hidden md:inline">Opsi</span>
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <div class="mt-6 bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-xs font-bold tracking-wider text-gray-500 uppercase">
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Peran</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Terakhir Login</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($semuaPengguna as $user)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-emerald-100 text-primary border border-emerald-200 flex items-center justify-center text-xs font-bold shrink-0 uppercase">
                                        {{ substr($user['nama'], 0, 2) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-neutral block">{{ $user['nama'] }}</span>
                                        <span class="text-xs text-gray-400 block md:hidden">{{ $user['email'] }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-600 hidden md:table-cell">
                                {{ $user['email'] }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($user['role'] === 'Admin')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 text-xs rounded-md bg-indigo-50 text-indigo-700 border border-indigo-200 font-bold">
                                        Admin
                                    </span>
                                @elseif($user['role'] === 'Petugas Lapangan')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 text-xs rounded-md bg-amber-50 text-amber-800 border border-amber-200 font-bold">
                                        Petugas Lapangan
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 text-xs rounded-md bg-blue-50 text-blue-700 border border-blue-200 font-bold">
                                        Masyarakat
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if ($user['status'] === 'Aktif')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs rounded-full bg-green-50 text-green-700 font-bold border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-600 font-bold border border-gray-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-xs font-semibold text-gray-500">
                                {{ \Carbon\Carbon::parse($user['created_at'])->translatedFormat('d M Y, H:i') }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.pengguna.edit', ['role' => $user['role_key'], 'id' => $user['id']]) }}"
                                        title="Edit Pengguna"
                                        class="p-1.5 text-gray-400 hover:text-primary hover:bg-primary/10 rounded-lg transition-colors flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>

                                    <form
                                        action="{{ route('admin.pengguna.destroy', ['role' => $user['role_key'], 'id' => $user['id']]) }}"
                                        method="POST" class="m-0 inline-block form-hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" title="Hapus Pengguna" data-nama="{{ $user['nama'] }}"
                                            class="btn-hapus p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <p class="text-sm text-gray-500 font-medium">Belum ada pengguna yang terdaftar di
                                    sistem.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-t border-gray-200">
                <p class="text-xs font-semibold text-gray-500">
                    Menampilkan 1 sampai 3 dari 45 entri
                </p>
                <div class="flex items-center gap-1.5">
                    <button
                        class="w-8 h-8 flex items-center justify-center border border-gray-300 bg-white text-gray-400 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button
                        class="w-8 h-8 flex items-center justify-center bg-primary text-white text-xs font-bold rounded-lg shadow-sm">
                        1
                    </button>
                    <button
                        class="w-8 h-8 flex items-center justify-center border border-gray-300 bg-white text-gray-600 hover:bg-gray-100 text-xs font-bold rounded-lg transition-colors">
                        2
                    </button>
                    <button
                        class="w-8 h-8 flex items-center justify-center border border-gray-300 bg-white text-gray-600 hover:bg-gray-100 text-xs font-bold rounded-lg transition-colors">
                        3
                    </button>
                    <span class="text-xs text-gray-400 px-1">...</span>
                    <button
                        class="w-8 h-8 flex items-center justify-center border border-gray-300 bg-white text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">

        <!-- Activity Card -->
        <div
            class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl p-6 sm:p-8 relative overflow-hidden shadow-sm flex flex-col justify-between">
            <div class="relative z-10">
                <div class="flex items-center gap-2 text-primary font-bold text-xs uppercase tracking-wider mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                    Keamanan & Log
                </div>
                <h3 class="text-xl font-bold font-montserrat text-neutral">
                    Laporan Aktivitas Admin
                </h3>
                <p class="text-sm text-gray-500 leading-relaxed mt-2 max-w-xl">
                    Pantau riwayat audit sistem dan perubahan hak akses atau kredensial yang dilakukan oleh
                    administrator dalam 24 jam terakhir.
                </p>
            </div>

            <div class="relative z-10 mt-6 pt-4 border-t border-gray-100">
                <a href="#"
                    class="inline-flex items-center gap-1.5 text-xs font-bold text-primary hover:underline">
                    Lihat Audit Log Lengkap
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>

            <!-- Background Watermark Icon -->
            <div class="absolute -right-6 -bottom-6 text-gray-100 pointer-events-none opacity-60">
                <svg class="w-56 h-56" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z">
                    </path>
                </svg>
            </div>
        </div>

        <!-- Security Score Card -->
        <div
            class="bg-primary rounded-2xl p-6 sm:p-8 text-white relative overflow-hidden shadow-md flex flex-col justify-between min-h-[200px]">
            <div class="relative z-10">
                <div
                    class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center mb-4 text-accent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-white/80">
                    Skor Keamanan Sistem
                </p>
                <div class="flex items-baseline gap-3 mt-1">
                    <h3 class="text-4xl sm:text-5xl font-extrabold font-montserrat tracking-tight">
                        94%
                    </h3>
                </div>
            </div>

            <div class="relative z-10 mt-6 pt-4 border-t border-white/10 flex items-center justify-between">
                <span class="text-xs text-white/70">Kondisi Server</span>
                <span
                    class="px-2.5 py-1 rounded-md bg-accent/20 border border-accent/30 text-accent font-bold text-xs uppercase tracking-wider">
                    Sangat Aman
                </span>
            </div>

            <!-- Lingkaran Dekorasi -->
            <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-white/5 pointer-events-none blur-xl">
            </div>
        </div>

    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil semua tombol dengan class btn-hapus
        const btnHapus = document.querySelectorAll('.btn-hapus');

        btnHapus.forEach(button => {
            button.addEventListener('click', function() {
                // Cari elemen form terdekat dari tombol yang diklik
                const form = this.closest('.form-hapus');
                // Ambil nama pengguna dari atribut data-nama
                const namaPengguna = this.getAttribute('data-nama');

                // Tampilkan SweetAlert
                Swal.fire({
                    title: 'Hapus Pengguna?',
                    text: `Apakah Anda yakin ingin menghapus data ${namaPengguna}? Tindakan ini tidak dapat dibatalkan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', // Warna merah (Tailwind text-red-500)
                    cancelButtonColor: '#9ca3af', // Warna abu-abu (Tailwind text-gray-400)
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true // Membalik posisi tombol batal dan hapus
                }).then((result) => {
                    // Jika user klik "Ya, Hapus!"
                    if (result.isConfirmed) {
                        form.submit(); // Submit form secara otomatis
                    }
                });
            });
        });
    });
</script>
