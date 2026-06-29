@extends('masyarakat.v_layouts.app')

@section('title', 'Beranda - SIMBO')
@section('page_title', 'Beranda')

@section('content')
<div class="w-full" x-data="{ showPelajari: false }">

    {{-- ══════════════════════════════════════════════════════════════
         KONTEN BERANDA — muncul saat showPelajari = false
    ══════════════════════════════════════════════════════════════ --}}
    <div x-show="!showPelajari"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="space-y-8">

        {{-- 1. Hero Section --}}
        <section class="rounded-2xl p-8 border border-gray-200 shadow-sm relative overflow-hidden bg-cover bg-center"
            style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('images/hero-bogor.jpg') }}');">
            <div class="relative z-10">
                <h2 class="text-3xl font-bold text-white mb-2">
                    Halo, {{ auth()->user()->nama_lengkap ?? 'Warga Bogor' }}!
                </h2>
                <h3 class="text-xl font-semibold text-gray-200 mb-4">Selamat Datang di SIMBO</h3>
                <p class="text-sm text-gray-300 max-w-2xl leading-relaxed">
                    Sampaikan aspirasi dan pengaduan Anda dengan mudah. Bersama, kita wujudkan pelayanan
                    publik yang cepat, transparan, dan responsif untuk Kota Bogor.
                </p>
            </div>
        </section>

        {{-- 2. Statistics Grid --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col items-center justify-center text-center border-t-4 border-t-neutral">
                <p class="text-4xl font-extrabold text-neutral">{{ $totalLaporan ?? 0 }}</p>
                <p class="text-xs font-bold text-gray-500 mt-2 uppercase tracking-wider">Total Laporan Saya</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col items-center justify-center text-center border-t-4 border-t-yellow-500">
                <p class="text-4xl font-extrabold text-neutral">{{ $diprosesLaporan ?? 0 }}</p>
                <p class="text-xs font-bold text-gray-500 mt-2 uppercase tracking-wider">Sedang Diproses</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col items-center justify-center text-center border-t-4 border-t-green-500">
                <p class="text-4xl font-extrabold text-neutral">{{ $selesaiLaporan ?? 0 }}</p>
                <p class="text-xs font-bold text-gray-500 mt-2 uppercase tracking-wider">Selesai</p>
            </div>
        </section>

        {{-- 3. Action Buttons --}}
        <section class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('laporan.index') }}"
                class="bg-primary text-white flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-md hover:shadow-lg">
                <i class="ph ph-plus-circle text-xl"></i>
                Membuat Laporan
            </a>
            <button @click="showPelajari = true"
                class="bg-white border border-gray-300 text-gray-700 flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm hover:bg-gray-50 transition-all shadow-sm">
                <i class="ph ph-info text-xl"></i>
                Pelajari Lebih Lanjut
            </button>
        </section>

        {{-- 4. Aktivitas Terbaru --}}
        <section>
            <h3 class="text-lg font-bold text-neutral mb-4 flex items-center gap-2">
                <i class="ph ph-clock-counter-clockwise text-primary text-xl"></i>
                Aktivitas Terbaru
            </h3>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
                @forelse ($aktivitasTerbaru as $item)
                    @php
                        $config = match ($item->status_laporan) {
                            'Menunggu' => ['icon' => 'ph-clock',            'bg' => 'bg-orange-100', 'text' => 'text-orange-600', 'badgeBg' => 'bg-orange-50', 'badgeText' => 'text-orange-600', 'badgeBorder' => 'border-orange-100', 'label' => 'Menunggu'],
                            'Diproses' => ['icon' => 'ph-arrows-clockwise', 'bg' => 'bg-blue-100',   'text' => 'text-blue-600',   'badgeBg' => 'bg-blue-50',   'badgeText' => 'text-blue-600',   'badgeBorder' => 'border-blue-100',   'label' => 'Proses'],
                            'Selesai'  => ['icon' => 'ph-check-circle',     'bg' => 'bg-green-100',  'text' => 'text-green-600',  'badgeBg' => 'bg-green-50',  'badgeText' => 'text-green-600',  'badgeBorder' => 'border-green-100',  'label' => 'Selesai'],
                            'Ditolak'  => ['icon' => 'ph-x-circle',        'bg' => 'bg-red-100',    'text' => 'text-red-600',    'badgeBg' => 'bg-red-50',    'badgeText' => 'text-red-600',    'badgeBorder' => 'border-red-100',    'label' => 'Ditolak'],
                            default    => ['icon' => 'ph-info',             'bg' => 'bg-gray-100',   'text' => 'text-gray-600',   'badgeBg' => 'bg-gray-50',   'badgeText' => 'text-gray-600',   'badgeBorder' => 'border-gray-100',   'label' => '-'],
                        };
                    @endphp
                    <a href="{{ route('aktivitas.detail', ['id' => $item->id_laporan]) }}"
                        class="flex items-start gap-4 p-4 hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-0">
                        <div class="w-10 h-10 rounded-full {{ $config['bg'] }} {{ $config['text'] }} flex items-center justify-center shrink-0 mt-0.5">
                            <i class="ph {{ $config['icon'] }} text-xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-neutral truncate">{{ $item->judul_laporan }}</h4>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ optional($item->kategori)->nama_kategori ?? 'Umum' }}
                                · #RPT-{{ str_pad($item->id_laporan, 4, '0', STR_PAD_LEFT) }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1.5">
                                {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}
                            </p>
                        </div>
                        <div class="shrink-0 mt-0.5">
                            <span class="px-2.5 py-1 rounded-md {{ $config['badgeBg'] }} {{ $config['badgeText'] }} text-xs font-bold border {{ $config['badgeBorder'] }}">
                                {{ $config['label'] }}
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="p-10 text-center">
                        <i class="ph ph-tray text-4xl text-gray-300 mb-3"></i>
                        <p class="text-sm font-semibold text-gray-400">Belum ada aktivitas laporan.</p>
                        <a href="{{ route('laporan.index') }}"
                            class="inline-block mt-3 text-xs font-bold text-primary hover:underline">
                            Buat laporan pertama Anda →
                        </a>
                    </div>
                @endforelse
            </div>

            @if ($aktivitasTerbaru->isNotEmpty())
                <div class="mt-3 text-right">
                    <a href="{{ route('aktivitas.index') }}"
                        class="text-xs font-bold text-primary hover:underline inline-flex items-center gap-1">
                        Lihat semua aktivitas <i class="ph ph-arrow-right"></i>
                    </a>
                </div>
            @endif
        </section>

        {{-- 5. Berita Terbaru --}}
        <section class="pb-4">
            <h3 class="text-lg font-bold text-neutral mb-4 flex items-center gap-2">
                <i class="ph ph-newspaper text-primary text-xl"></i>
                Berita Terbaru
            </h3>

            @if ($beritaTerbaru->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($beritaTerbaru as $berita)
                        <article class="bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm flex flex-col group cursor-pointer hover:shadow-md transition-all">
                            <div class="h-40 bg-gray-100 relative overflow-hidden">
                                @if ($berita->gambar_berita)
                                    <img src="{{ asset('uploads/berita/' . $berita->gambar_berita) }}" alt="{{ $berita->judul_berita }}"
                                        class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <i class="ph ph-image text-5xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5 flex-1 flex flex-col">
                                <span class="text-xs font-bold text-primary mb-2 uppercase tracking-wider">
                                    {{ optional($berita->kategori)->nama_kategori ?? 'Umum' }}
                                </span>
                                <h4 class="text-sm font-bold text-neutral mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                                    {{ $berita->judul_berita }}
                                </h4>
                                <div class="mt-auto pt-4 flex items-center justify-between text-gray-400 border-t border-gray-50">
                                    <span class="text-xs font-medium">
                                        {{ \Carbon\Carbon::parse($berita->tanggal_publish)->diffForHumans() }}
                                    </span>
                                    <i class="ph ph-arrow-right text-lg group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="mt-4 text-right">
                    <a href="{{ route('berita.index') }}"
                        class="text-xs font-bold text-primary hover:underline inline-flex items-center gap-1">
                        Lihat semua berita <i class="ph ph-arrow-right"></i>
                    </a>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-200 p-10 text-center shadow-sm">
                    <i class="ph ph-newspaper text-4xl text-gray-300 mb-3"></i>
                    <p class="text-sm font-semibold text-gray-400">Belum ada berita yang dipublikasikan.</p>
                </div>
            @endif
        </section>

    </div>
    {{-- ── END KONTEN BERANDA ────────────────────────────────────── --}}


    {{-- ══════════════════════════════════════════════════════════════
         KONTEN PELAJARI — muncul saat showPelajari = true
         Menggantikan konten beranda, bukan overlay di atasnya
    ══════════════════════════════════════════════════════════════ --}}
    <div x-show="showPelajari"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-3"
        class="space-y-10">

        {{-- Tombol Kembali --}}
        <div class="flex items-center justify-between">
            <button @click="showPelajari = false"
                class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-neutral transition-colors">
                <i class="ph ph-arrow-left text-base"></i>
                Kembali ke Beranda
            </button>
            <span class="text-xs text-gray-400 font-medium">Panduan Penggunaan SIMBO</span>
        </div>

        {{-- Section 1: Alur Pengaduan --}}
        <section class="text-center">
            <h2 class="text-3xl font-extrabold text-neutral mb-3">
                Proses Laporan yang Mudah & Transparan
            </h2>
            <p class="text-sm text-gray-500 max-w-xl mx-auto leading-relaxed">
                Ikuti langkah-langkah berikut untuk mengajukan laporan Anda kepada petugas SIMBO.
            </p>
        </section>

        {{-- 5 Step Cards --}}
        <section>
            @php
                $steps = [
                    ['icon' => 'ph-user-plus',        'title' => 'Daftar & Login',   'desc' => 'Buat akun gratis dan login ke platform Buitenzorg'],
                    ['icon' => 'ph-camera',           'title' => 'Upload Foto',       'desc' => 'Upload foto yang ingin di laporkan'],
                    ['icon' => 'ph-note-pencil',      'title' => 'Detail Laporan',    'desc' => 'Tulis deskripsi laporan terkait masalah yang terjadi'],
                    ['icon' => 'ph-map-pin',          'title' => 'Atur Lokasi',       'desc' => 'Atur lokasi laporan sesuai tempat kejadian'],
                    ['icon' => 'ph-magnifying-glass', 'title' => 'Tinjau Laporan',    'desc' => 'Pantau status laporan dan notifikasi laporan'],
                ];
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-5 gap-8">
                @foreach ($steps as $i => $step)
                    <div class="flex flex-col items-center text-center group">
                        <div class="relative mb-5">
                            <div class="w-20 h-20 rounded-full bg-neutral text-white flex items-center justify-center shadow-md group-hover:bg-primary transition-colors duration-300">
                                <i class="ph {{ $step['icon'] }} text-3xl"></i>
                            </div>
                            <span class="absolute -top-1 -right-1 w-6 h-6 rounded-full bg-primary text-white text-[11px] font-extrabold flex items-center justify-center border-2 border-white shadow-sm">
                                {{ $i + 1 }}
                            </span>
                        </div>
                        <h4 class="text-sm font-extrabold text-neutral mb-2 group-hover:text-primary transition-colors">
                            {{ $step['title'] }}
                        </h4>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Section 2: CTA --}}
        <section class="pb-6">
            <div class="bg-neutral rounded-2xl p-12 text-center text-white">
                <h2 class="text-3xl font-extrabold mb-4">Siap Membuat Laporan?</h2>
                <p class="text-sm text-white/75 max-w-lg mx-auto leading-relaxed mb-8">
                    Mulai dari menyampaikan pengaduan hingga memantau tindak lanjut laporan
                    dalam satu platform, untuk pelayanan publik yang lebih baik.
                </p>
                <div class="flex items-center justify-center gap-3 flex-wrap">
                    <a href="{{ route('laporan.index') }}"
                        class="px-8 py-3.5 rounded-xl bg-white text-neutral font-extrabold text-sm hover:bg-gray-100 transition-all shadow-md">
                        Mulai Lapor Sekarang
                    </a>
                    <button @click="showPelajari = false"
                        class="px-6 py-3.5 rounded-xl border border-white/30 text-white font-bold text-sm hover:bg-white/10 transition-all">
                        Kembali ke Beranda
                    </button>
                </div>
            </div>
        </section>

    </div>
    {{-- ── END KONTEN PELAJARI ───────────────────────────────────── --}}

</div>
@endsection