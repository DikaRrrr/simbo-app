@extends('admin.v_layouts.app')

@section('title', 'Kirim Penugasan - Admin SIMBO')

<!-- Main Content -->
<!-- Sesuaikan margin kiri (ml-[210px] atau ml-[250px]) dengan ukuran sidebar di layout-mu -->
<main class="ml-[250px] w-[calc(100%-250px)] bg-dash-secondary min-h-screen font-worksans p-8">

    <!-- Tombol Kembali -->
    <a href="{{ url('/admin/identifikasi') }}"
        class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-primary transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Identifikasi
    </a>

    <!-- Header Judul -->
    <div class="flex items-center gap-4 mt-6 mb-8">
        <h2 class="text-3xl font-extrabold font-montserrat text-neutral">Kirim Laporan ke Petugas</h2>
        <span class="px-3 py-1 text-sm font-bold rounded-lg bg-white border border-gray-300 text-gray-700 shadow-sm">
            #INF-2023-090
        </span>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 max-w-6xl">

        <!-- KARTU KIRI: Detail Laporan -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden h-fit">
            <!-- Gambar Bukti -->
            <div class="relative">
                <img src="{{ asset('images/pohon-tumbang.png') }}" alt="Pohon tumbang" class="w-full h-56 object-cover">
                <!-- Badge Kategori Overlap Gambar -->
                <div
                    class="absolute top-4 left-4 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-50/90 backdrop-blur-sm text-indigo-700 text-xs font-bold border border-indigo-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    Infrastruktur
                </div>
            </div>

            <!-- Konten Laporan -->
            <div class="p-6 md:p-8">
                <h3 class="text-xl font-bold font-montserrat text-neutral">
                    Pohon Tumbang di Jl. Sudirman
                </h3>

                <!-- Informasi Tambahan -->
                <div
                    class="flex items-center gap-2 mt-3 text-sm text-gray-500 font-medium bg-gray-50 p-3 rounded-xl border border-gray-100">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="truncate">Jl. Sudirman No. 45, Kecamatan Bogor Tengah</span>
                </div>

                <div class="mt-6">
                    <p class="text-sm font-bold text-neutral mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                        Deskripsi Laporan
                    </p>
                    <div
                        class="text-sm leading-relaxed text-gray-600 bg-white border border-gray-200 p-4 rounded-xl shadow-inner">
                        Ada pohon besar tumbang menghalangi jalan utama. Sangat berbahaya bagi pengendara yang melintas.
                        Mohon segera ditangani sebelum terjadi kecelakaan.
                    </div>
                </div>
            </div>
        </div>

        <!-- KARTU KANAN: Formulir Penugasan -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm h-fit overflow-hidden">
            <!-- Garis Aksen Atas -->
            <div class="h-1.5 w-full bg-primary"></div>

            <div class="p-6 md:p-8">
                <h3 class="text-lg font-bold font-montserrat text-neutral mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    Formulir Penugasan
                </h3>

                <form action="#" method="POST">
                    @csrf

                    <div class="border-t border-gray-100 pt-6">
                        <label class="block text-sm font-bold text-neutral mb-3">
                            Pilih Petugas Lapangan
                        </label>

                        <div class="relative">
                            <select name="petugas_id" required
                                class="w-full h-12 appearance-none rounded-xl border border-gray-300 bg-inputBg px-4 text-sm font-medium text-neutral outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all cursor-pointer">
                                <option value="" disabled selected>Pilih petugas yang tersedia...</option>
                                <option value="1">Petugas 1 - Tim Infrastruktur</option>
                                <option value="2">Petugas 2 - Tim Kebersihan</option>
                                <option value="3">Petugas 3 - Tim Reaksi Cepat</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 ml-1">Petugas akan menerima notifikasi langsung di
                            dashboard mereka.</p>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-bold text-neutral mb-3">
                            Prioritas Laporan
                        </label>

                        <div class="grid grid-cols-3 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="prioritas" value="rendah" class="peer sr-only" required>
                                <div
                                    class="flex flex-col items-center justify-center p-3 rounded-xl border-2 border-gray-200 bg-white hover:border-gray-300 peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
                                    <span
                                        class="text-xs font-bold text-gray-700 peer-checked:text-primary">Rendah</span>
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input type="radio" name="prioritas" value="sedang" class="peer sr-only">
                                <div
                                    class="flex flex-col items-center justify-center p-3 rounded-xl border-2 border-gray-200 bg-white hover:border-gray-300 peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
                                    <span
                                        class="text-xs font-bold text-gray-700 peer-checked:text-primary">Sedang</span>
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input type="radio" name="prioritas" value="tinggi" class="peer sr-only">
                                <div
                                    class="flex flex-col items-center justify-center p-3 rounded-xl border-2 border-gray-200 bg-white hover:border-gray-300 peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
                                    <span
                                        class="text-xs font-bold text-gray-700 peer-checked:text-primary">Tinggi</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-bold text-neutral mb-3">
                            Catatan dari Admin
                        </label>
                        <textarea name="catatan_admin" rows="4"
                            placeholder="Tambahkan instruksi khusus, detail patokan lokasi, atau pesan untuk petugas lapangan..."
                            class="w-full rounded-xl border border-gray-300 bg-inputBg px-4 py-3 text-sm font-medium text-neutral outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all resize-none"></textarea>
                    </div>

                    <div class="border-t border-gray-100 mt-8 pt-6 flex justify-end gap-3">
                        <a href="{{ url('/admin/identifikasi') }}"
                            class="px-6 py-3 rounded-xl border border-gray-300 bg-white text-gray-600 text-sm font-bold hover:bg-gray-50 transition-colors shadow-sm">
                            Batal
                        </a>

                        <button type="submit"
                            class="px-6 py-3 rounded-xl bg-primary text-white text-sm font-bold hover:bg-primary/90 hover:shadow-md transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Kirim Tugas
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</main>
