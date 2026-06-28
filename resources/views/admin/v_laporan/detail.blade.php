@extends('admin.v_layouts.app')

@section('title', 'Kirim Penugasan - Admin SIMBO')
@section('pageTitle', 'Identifikasi Laporan')

<main class="ml-[250px] w-[calc(100%-250px)] bg-dash-secondary min-h-screen font-worksans p-8 pt-24"
    x-data="{ showRejectModal: false }">

    {{-- Tombol Kembali --}}
    <a href="{{ url('/admin/identifikasi') }}"
        class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-primary transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Identifikasi
    </a>

    {{-- Header --}}
    <div class="flex flex-wrap items-center gap-3 mb-8">
        <h2 class="text-3xl font-extrabold font-montserrat text-neutral">Kirim Laporan ke Petugas</h2>
        <span
            class="px-3 py-1.5 text-sm font-bold rounded-lg bg-white border border-gray-200 text-gray-500 shadow-sm font-mono">
            #RPT-{{ str_pad($laporan->id_laporan, 4, '0', STR_PAD_LEFT) }}
        </span>
        <span
            class="px-3 py-1.5 text-xs font-bold rounded-full bg-amber-50 border border-amber-200 text-amber-700 uppercase tracking-wide flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
            Menunggu Penugasan
        </span>
    </div>

    {{-- Grid 2 Kolom: Kiri (Detail) + Kanan (Form) --}}
    <div class="grid grid-cols-1 xl:grid-cols-[1fr_400px] gap-8 max-w-6xl">

        {{-- ===== KOLOM KIRI: Detail Laporan ===== --}}
        <div class="space-y-5">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Gambar Bukti & Header Dinamis --}}
                <div class="relative bg-gray-100 min-h-[16rem] flex items-center justify-center">

                    @if ($laporan->fotoUtama && $laporan->fotoUtama->file_foto)
                        <img src="{{ asset('storage/' . $laporan->fotoUtama->file_foto) }}" alt="Bukti laporan"
                            class="w-full h-72 object-cover">
                    @else
                        <div class="text-gray-400 flex flex-col items-center py-12">
                            <i class="ph ph-image-broken text-5xl mb-2"></i>
                            <span class="text-sm font-medium">Tidak ada foto bukti dilampirkan</span>
                        </div>
                    @endif

                    {{-- Gradient overlay agar teks tetap terbaca --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

                    {{-- Badge Kategori Dinamis --}}
                    <div
                        class="absolute top-4 left-4 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/90 backdrop-blur-sm text-indigo-700 text-xs font-bold border border-indigo-200 shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        {{ optional($laporan->kategori)->nama_kategori ?? 'Kategori Umum' }}
                    </div>

                    {{-- Judul di atas gambar --}}
                    <div class="absolute bottom-0 left-0 right-0 p-5">
                        <h3 class="text-xl font-bold text-white drop-shadow-md leading-snug">
                            {{ $laporan->judul_laporan }}
                        </h3>
                    </div>
                </div>

                {{-- Info Detail --}}
                <div class="p-6 space-y-4">
                    {{-- Lokasi --}}
                    <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Lokasi
                                Kejadian</p>
                            <p class="text-sm font-semibold text-neutral">{{ $laporan->lokasi }}</p>
                        </div>
                    </div>

                    {{-- Tanggal Dilaporkan --}}
                    <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Dilaporkan
                                Pada</p>
                            <p class="text-sm font-semibold text-neutral">
                                {{ \Carbon\Carbon::parse($laporan->created_at)->translatedFormat('d F Y, H:i') }} WIB
                            </p>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">Deskripsi Laporan
                        </p>
                        <div
                            class="text-sm leading-relaxed text-gray-600 bg-gray-50 border border-gray-200 p-4 rounded-xl">
                            {{ $laporan->isi_laporan }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Data Pelapor --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-4">Data Pelapor</p>
                <div class="flex items-center gap-4">
                    <div
                        class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center text-sm font-bold shrink-0 uppercase">
                        {{ substr(optional($laporan->masyarakat)->nama_lengkap ?? 'AN', 0, 2) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-neutral">
                            {{ optional($laporan->masyarakat)->nama_lengkap ?? 'Anonim' }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ optional($laporan->masyarakat)->email ?? 'Email tidak tersedia' }}
                        </p>
                    </div>
                    <span
                        class="ml-auto px-2.5 py-1 text-[10px] font-bold rounded-full bg-blue-50 border border-blue-200 text-blue-700 uppercase">
                        Masyarakat
                    </span>
                </div>
            </div>
        </div>

        {{-- ===== KOLOM KANAN: Formulir Penugasan ===== --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm h-fit overflow-hidden">
            <div class="h-1.5 w-full bg-primary"></div>

            <div class="p-6 md:p-8">
                <div class="mb-6">
                    <h3 class="text-lg font-bold font-montserrat text-neutral flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        Formulir Penugasan
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">Tentukan petugas dan prioritas untuk menangani laporan ini.
                    </p>
                </div>

                <form action="{{ route('admin.identifikasi.assign', $laporan->id_laporan) }}" method="POST"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Pilih Petugas --}}
                    <div>
                        <label class="block text-sm font-bold text-neutral mb-2">Petugas Lapangan <span
                                class="text-red-500 ml-0.5">*</span></label>
                        <div class="relative">
                            <select name="petugas_id" required
                                class="w-full h-12 appearance-none rounded-xl border border-gray-300 bg-inputBg px-4 text-sm font-medium text-neutral outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all cursor-pointer">
                                <option value="" disabled selected>Pilih petugas yang tersedia...</option>
                                @foreach ($petugas as $p)
                                    <option value="{{ $p->id_petugas ?? $p->id }}">
                                        {{ $p->nama_petugas }} — {{ $p->wilayah_tugas ?? 'Semua Wilayah' }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Prioritas Laporan (Struktur Radio Button Tailwind Diperbaiki) --}}
                    <div>
                        <label class="block text-sm font-bold text-neutral mb-3">Prioritas Laporan <span
                                class="text-red-500 ml-0.5">*</span></label>
                        <div class="grid grid-cols-3 gap-3">

                            {{-- Rendah --}}
                            <div class="relative">
                                <input type="radio" name="prioritas" id="p_rendah" value="Rendah"
                                    class="peer sr-only" required>
                                <label for="p_rendah"
                                    class="flex flex-col items-center gap-2 p-3.5 rounded-xl border-2 border-gray-200 bg-white cursor-pointer hover:border-green-300 peer-checked:border-green-500 peer-checked:bg-green-50 transition-all">
                                    <span class="w-2.5 h-2.5 rounded-full bg-green-400"></span>
                                    <span class="text-xs font-bold text-gray-600">Rendah</span>
                                </label>
                            </div>

                            {{-- Sedang --}}
                            <div class="relative">
                                <input type="radio" name="prioritas" id="p_sedang" value="Sedang"
                                    class="peer sr-only">
                                <label for="p_sedang"
                                    class="flex flex-col items-center gap-2 p-3.5 rounded-xl border-2 border-gray-200 bg-white cursor-pointer hover:border-amber-300 peer-checked:border-amber-500 peer-checked:bg-amber-50 transition-all">
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                                    <span class="text-xs font-bold text-gray-600">Sedang</span>
                                </label>
                            </div>

                            {{-- Tinggi --}}
                            <div class="relative">
                                <input type="radio" name="prioritas" id="p_tinggi" value="Tinggi"
                                    class="peer sr-only">
                                <label for="p_tinggi"
                                    class="flex flex-col items-center gap-2 p-3.5 rounded-xl border-2 border-gray-200 bg-white cursor-pointer hover:border-red-300 peer-checked:border-red-500 peer-checked:bg-red-50 transition-all">
                                    <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                                    <span class="text-xs font-bold text-gray-600">Tinggi</span>
                                </label>
                            </div>

                        </div>
                    </div>

                    {{-- Catatan Admin --}}
                    <div>
                        <label class="block text-sm font-bold text-neutral mb-2">Catatan dari Admin</label>
                        <textarea name="catatan_admin" rows="4" placeholder="Tambahkan instruksi khusus untuk petugas lapangan..."
                            class="w-full rounded-xl border border-gray-300 bg-inputBg px-4 py-3 text-sm font-medium text-neutral outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all resize-none"></textarea>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="border-t border-gray-100 pt-6 flex justify-end gap-2">

                        <button type="button" @click="showRejectModal = true"
                            class="px-5 py-3 rounded-xl border border-red-200 bg-red-50 text-red-600 text-sm font-bold hover:bg-red-100 transition-colors flex items-center gap-2">
                            <i class="ph ph-x-circle text-base"></i>
                            Tolak Laporan
                        </button>

                        <button type="submit"
                            class="px-5 py-3 rounded-xl bg-primary text-white text-sm font-bold hover:bg-primary/90 hover:shadow-md transition-all flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Kirim Tugas
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>

    <div x-show="showRejectModal" x-cloak
        class="fixed inset-0 z-[99999] flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100">

        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showRejectModal = false"></div>

        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-100 p-6 space-y-4 transition-all transform"
            x-show="showRejectModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">

            <div class="flex items-center gap-3 text-red-600">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                    <i class="ph ph-warning-octagon text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold font-montserrat text-neutral">Tolak Laporan ini?</h3>
                    <p class="text-xs text-gray-400">Tindakan ini akan membatalkan proses penugasan.</p>
                </div>
            </div>

            <form action="{{ route('admin.identifikasi.tolak', $laporan->id_laporan) }}" method="POST"
                class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Alasan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="catatan_penolakan" rows="4" required
                        placeholder="Berikan alasan yang jelas mengapa laporan ini ditolak (misal: Laporan hoaks, lokasi di luar wilayah Bogor, atau informasi kurang lengkap)..."
                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm font-medium text-neutral outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:bg-white transition-all resize-none"></textarea>
                    {{-- TAMBAHKAN INI --}}
                    @error('catatan_penolakan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="showRejectModal = false"
                        class="px-4 py-2.5 rounded-xl border border-gray-300 bg-white text-gray-600 text-xs font-bold hover:bg-gray-50 transition-colors shadow-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2.5 rounded-xl bg-red-600 text-white text-xs font-bold hover:bg-red-700 transition-colors shadow-sm flex items-center gap-1.5">
                        <i class="ph ph-trash text-sm"></i>
                        Ya, Tolak Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
