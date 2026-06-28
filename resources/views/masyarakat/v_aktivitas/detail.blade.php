@extends('masyarakat.v_layouts.app')

@section('title', 'Detail Laporan - SIMBO')
@section('page_title', 'Detail Laporan')

@section('content')

    @php
        $statusConfig = match ($laporan->status_laporan) {
            'Menunggu' => [
                'bg' => 'bg-orange-50',
                'text' => 'text-orange-700',
                'border' => 'border-orange-200',
                'dot' => 'bg-orange-500',
                'barColor' => 'bg-orange-400',
                'barWidth' => 'w-1/4',
            ],
            'Diproses' => [
                'bg' => 'bg-blue-50',
                'text' => 'text-blue-700',
                'border' => 'border-blue-200',
                'dot' => 'bg-blue-500',
                'barColor' => 'bg-blue-500',
                'barWidth' => 'w-2/4',
            ],
            'Selesai' => [
                'bg' => 'bg-green-50',
                'text' => 'text-green-700',
                'border' => 'border-green-200',
                'dot' => 'bg-green-600',
                'barColor' => 'bg-green-500',
                'barWidth' => 'w-full',
            ],
            'Ditolak' => [
                'bg' => 'bg-red-50',
                'text' => 'text-red-700',
                'border' => 'border-red-200',
                'dot' => 'bg-red-500',
                'barColor' => 'bg-red-400',
                'barWidth' => 'w-full',
            ],
            default => [
                'bg' => 'bg-gray-50',
                'text' => 'text-gray-700',
                'border' => 'border-gray-200',
                'dot' => 'bg-gray-400',
                'barColor' => 'bg-gray-300',
                'barWidth' => 'w-0',
            ],
        };
    @endphp

    <div class="max-w-3xl mx-auto space-y-5">

        {{-- ── Tombol Kembali ─────────────────────────────────────────── --}}
        <a href="{{ route('aktivitas.index') }}"
            class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-neutral transition-colors mb-2">
            <i class="ph ph-arrow-left text-sm"></i>
            Kembali ke Aktivitas
        </a>

        {{-- ══════════════════════════════════════════════════════════════
         KARTU 1 — Header Laporan
    ══════════════════════════════════════════════════════════════ --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

            {{-- Foto Bukti --}}
            <div class="relative h-52 bg-gray-100 flex items-center justify-center overflow-hidden">
                @if ($laporan->fotoUtama && $laporan->fotoUtama->file_foto)
                    <img src="{{ asset('storage/' . $laporan->fotoUtama->file_foto) }}" alt="Foto Bukti Laporan"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                @else
                    <div class="flex flex-col items-center text-gray-300">
                        <i class="ph ph-image-broken text-5xl mb-2"></i>
                        <span class="text-xs font-medium">Tidak ada foto dilampirkan</span>
                    </div>
                @endif

                {{-- Badge Status overlay --}}
                <div class="absolute top-4 left-4">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold border
                    {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                        {{ $laporan->status_laporan }}
                    </span>
                </div>

                {{-- Nomor tiket overlay --}}
                <div class="absolute top-4 right-4">
                    <span
                        class="px-3 py-1.5 rounded-full bg-black/50 backdrop-blur-sm text-white text-xs font-mono font-bold">
                        #RPT-{{ str_pad($laporan->id_laporan, 4, '0', STR_PAD_LEFT) }}
                    </span>
                </div>

                {{-- Judul di atas foto --}}
                @if ($laporan->fotoUtama)
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <h2 class="text-base font-bold text-white drop-shadow leading-snug">
                            {{ $laporan->judul_laporan }}
                        </h2>
                    </div>
                @endif
            </div>

            {{-- Judul (jika tidak ada foto) --}}
            @if (!$laporan->fotoUtama)
                <div class="px-5 pt-5">
                    <h2 class="text-lg font-bold text-neutral leading-snug">{{ $laporan->judul_laporan }}</h2>
                </div>
            @endif

            {{-- Meta Info --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-0 border-t border-gray-100 mt-4">

                <div class="flex flex-col items-center justify-center p-4 border-r border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Kategori</p>
                    <p class="text-xs font-bold text-neutral text-center">
                        {{ optional($laporan->kategori)->nama_kategori ?? '-' }}
                    </p>
                </div>

                <div class="flex flex-col items-center justify-center p-4 border-r border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Prioritas</p>
                    <span
                        class="text-xs font-bold
                    {{ $laporan->prioritas_laporan === 'Tinggi' ? 'text-red-600' : ($laporan->prioritas_laporan === 'Sedang' ? 'text-amber-600' : 'text-green-600') }}">
                        {{ $laporan->prioritas_laporan ?? '-' }}
                    </span>
                </div>

                <div class="flex flex-col items-center justify-center p-4 border-r border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal</p>
                    <p class="text-xs font-bold text-neutral text-center">
                        {{ \Carbon\Carbon::parse($laporan->created_at)->format('d M Y') }}
                    </p>
                </div>

                <div class="flex flex-col items-center justify-center p-4">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Diperbarui</p>
                    <p class="text-xs font-bold text-neutral text-center">
                        {{ \Carbon\Carbon::parse($laporan->updated_at)->diffForHumans() }}
                    </p>
                </div>

            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════
         KARTU 2 — Isi & Lokasi Laporan
    ══════════════════════════════════════════════════════════════ --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 space-y-4">

            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Detail Laporan</h3>

            {{-- Isi Laporan --}}
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Masalah</p>
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 text-sm text-gray-600 leading-relaxed">
                    {{ $laporan->isi_laporan }}
                </div>
            </div>

            {{-- Lokasi --}}
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Lokasi Kejadian</p>
                <div class="flex items-start gap-2 bg-gray-50 border border-gray-100 rounded-xl p-4">
                    <i class="ph ph-map-pin text-red-500 text-lg shrink-0 mt-0.5"></i>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $laporan->lokasi }}</p>
                </div>
            </div>

        </div>

        {{-- ══════════════════════════════════════════════════════════════
         KARTU 3 — Timeline Status
    ══════════════════════════════════════════════════════════════ --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">

            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-5">Riwayat Status</h3>

            <div class="relative">

                {{-- Garis vertikal penghubung --}}
                <div class="absolute left-4 top-4 bottom-4 w-px bg-gray-200"></div>

                <div class="space-y-6">
                    @foreach ($timeline as $i => $step)
                        <div class="flex items-start gap-4 relative">

                            {{-- Dot / Ikon Step --}}
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 z-10 border-2
                            {{ $step['done'] ? $step['color'] . ' text-white border-transparent' : 'bg-white border-gray-200 text-gray-300' }}">
                                <i class="ph {{ $step['icon'] }} text-sm"></i>
                            </div>

                            {{-- Konten Step --}}
                            <div class="flex-1 pb-1">
                                <div class="flex items-center justify-between gap-2 flex-wrap mb-1">
                                    <p class="text-sm font-bold {{ $step['done'] ? 'text-neutral' : 'text-gray-400' }}">
                                        {{ $step['status'] }}
                                    </p>
                                    @if ($step['waktu'])
                                        <span class="text-[10px] text-gray-400 font-medium">
                                            {{ \Carbon\Carbon::parse($step['waktu'])->translatedFormat('d M Y, H:i') }}
                                        </span>
                                    @else
                                        <span class="text-[10px] text-gray-300 font-medium italic">Belum terjadi</span>
                                    @endif
                                </div>

                                @if ($step['done'] && !empty($step['desc']))
                                    <p
                                        class="text-xs text-gray-500 leading-relaxed bg-gray-50 rounded-xl p-3 border border-gray-100">
                                        {{ $step['desc'] }}
                                    </p>
                                @elseif (!$step['done'])
                                    <p class="text-xs text-gray-300 italic">Menunggu proses sebelumnya...</p>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════
         KARTU 4 — Foto Penyelesaian (hanya muncul jika ada)
    ══════════════════════════════════════════════════════════════ --}}
        @if ($fotoPenyelesaian)
            <div class="bg-white rounded-2xl border border-green-200 shadow-sm overflow-hidden">

                <div class="px-5 py-4 border-b border-green-100 flex items-center gap-2 bg-green-50">
                    <div class="w-7 h-7 rounded-full bg-green-600 flex items-center justify-center">
                        <i class="ph ph-camera-check text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-green-800">Bukti Penyelesaian</p>
                        <p class="text-[10px] text-green-600">Foto dari petugas lapangan setelah masalah ditangani</p>
                    </div>
                </div>

                <div class="p-4">
                    <img src="{{ asset('storage/' . $fotoPenyelesaian->file_foto) }}" alt="Foto Penyelesaian"
                        class="w-full rounded-xl object-cover max-h-64 border border-green-100">
                </div>

            </div>
        @endif

        </div>

    </div>

@endsection
