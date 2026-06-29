@extends('admin.v_layouts.app')

@section('title', 'Dashboard - Admin SIMBO')
@section('pageTitle', 'Dashboard')

<main class="ml-[250px] w-[calc(100%-250px)] bg-dash-secondary min-h-screen font-worksans p-8 pt-24">

    {{-- ── Header ──────────────────────────────────────────────────── --}}
    <div class="mb-8 flex items-end justify-between">
        <div>
            <h2 class="text-2xl font-bold font-montserrat text-neutral">Ikhtisar Sistem</h2>
            <p class="text-sm text-gray-500 mt-1">Memantau laporan masyarakat dan progres identifikasi hari ini.</p>
        </div>
        <div class="text-sm font-semibold text-gray-500 bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm">
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    {{-- ── Stat Cards ───────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

        @php
            $cards = [
                [
                    'label' => 'Total Laporan',
                    'value' => $totalLaporan,
                    'badge' => $badgeTotalTeks,
                    'badgeColor' => $badgeTotalNaik ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600',
                    'border' => 'border-l-primary',
                    'iconBg' => 'bg-primary/10 text-primary',
                    'icon' =>
                        'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                ],
                [
                    'label' => 'Laporan Menunggu',
                    'value' => $laporanMenunggu,
                    'badge' => $badgeMenungguTeks,
                    'badgeColor' => $badgeMenungguRed ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600',
                    'border' => 'border-l-secondary',
                    'iconBg' => 'bg-secondary/10 text-secondary',
                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                ],
                [
                    'label' => 'Laporan Ditugaskan',
                    'value' => $laporanDiproses,
                    'badge' => $badgeDiprosesTeks,
                    'badgeColor' => 'bg-blue-50 text-blue-600',
                    'border' => 'border-l-blue-600',
                    'iconBg' => 'bg-blue-50 text-blue-600',
                    'icon' =>
                        'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                ],
                [
                    'label' => 'Laporan Selesai',
                    'value' => $laporanSelesai,
                    'badge' => $badgeSelesaiTeks,
                    'badgeColor' => 'bg-green-50 text-green-600',
                    'border' => 'border-l-green-600',
                    'iconBg' => 'bg-green-50 text-green-600',
                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                ],
            ];
        @endphp

        @foreach ($cards as $card)
            <div
                class="bg-white border border-gray-200 border-l-4 {{ $card['border'] }} rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 {{ $card['iconBg'] }} rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $card['icon'] }}"></path>
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold px-2 py-1 rounded-full {{ $card['badgeColor'] }}">
                        {{ $card['badge'] }}
                    </span>
                </div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">{{ $card['label'] }}</p>
                <h3 class="text-3xl font-extrabold font-montserrat text-neutral">
                    {{ number_format($card['value'], 0, ',', '.') }}
                </h3>
            </div>
        @endforeach

    </div>

    {{-- ── Tren + Aktivitas ─────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6 mb-8">

        {{-- Grafik Tren (placeholder visual) --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-base font-bold font-montserrat text-neutral">Analisis Tren Mingguan</h3>
                <span class="bg-inputBg px-4 py-2 text-xs font-bold text-gray-600 rounded-lg border border-gray-200">
                    7 Hari Terakhir
                </span>
            </div>

            {{-- Bar chart sederhana --}}
            <div class="flex items-end justify-between gap-2 h-48 px-2 mb-4">
                @php
                    $bars = [
                        ['hari' => 'Sen', 'h' => '60%'],
                        ['hari' => 'Sel', 'h' => '80%'],
                        ['hari' => 'Rab', 'h' => '45%'],
                        ['hari' => 'Kam', 'h' => '90%'],
                        ['hari' => 'Jum', 'h' => '70%'],
                        ['hari' => 'Sab', 'h' => '35%'],
                        ['hari' => 'Min', 'h' => '55%'],
                    ];
                @endphp
                @foreach ($bars as $bar)
                    <div class="flex flex-col items-center gap-2 flex-1">
                        <div class="w-full rounded-t-lg bg-primary/20 hover:bg-primary transition-colors duration-300 cursor-pointer"
                            style="height: {{ $bar['h'] }}"></div>
                        <span class="text-xs font-semibold text-gray-400">{{ $bar['hari'] }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Metrik ringkasan --}}
            <div class="grid grid-cols-3 text-center border-t border-gray-100 pt-5">

                <div class="border-r border-gray-100 px-2">
                    <p class="text-xs font-semibold text-gray-500 mb-1">Rata-rata Respon</p>
                    <strong class="text-sm font-bold text-neutral">
                        {{ $rataRataRespon }}
                    </strong>
                </div>

                <div class="border-r border-gray-100 px-2">
                    <p class="text-xs font-semibold text-gray-500 mb-1">Akurasi Identifikasi</p>
                    <strong class="text-sm font-bold text-neutral">
                        {{ $akurasiIdentifikasi }}
                    </strong>
                </div>

                <div class="px-2">
                    <p class="text-xs font-semibold text-gray-500 mb-1">Tingkat Pertumbuhan</p>
                    <strong class="text-sm font-bold {{ $pertumbuhanNaik ? 'text-green-600' : 'text-red-500' }}">
                        {{ $pertumbuhanTeks }}
                    </strong>
                </div>

            </div>

            {{-- Aktivitas Terbaru --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-base font-bold font-montserrat text-neutral mb-6">Aktivitas Terbaru</h3>

                <div class="space-y-5">
                    @forelse ($aktivitasTerbaru as $item)
                        @php
                            $statusColor = match (strtolower($item->status_laporan)) {
                                'menunggu' => 'bg-red-50 text-red-600 border-red-100',
                                'diproses' => 'bg-blue-50 text-blue-600 border-blue-100',
                                'selesai' => 'bg-green-50 text-green-600 border-green-100',
                                default => 'bg-gray-50 text-gray-600 border-gray-100',
                            };
                            $dotColor = match (strtolower($item->status_laporan)) {
                                'menunggu' => 'bg-red-100 text-red-500',
                                'diproses' => 'bg-blue-100 text-blue-500',
                                'selesai' => 'bg-green-100 text-green-500',
                                default => 'bg-gray-100 text-gray-400',
                            };
                        @endphp

                        <div class="flex items-start gap-3">
                            <div
                                class="w-9 h-9 rounded-full {{ $dotColor }} flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <h4 class="text-sm font-bold text-neutral truncate">
                                            {{ Str::limit($item->judul_laporan, 28) }}
                                        </h4>
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            {{ optional($item->kategori)->nama_kategori ?? 'Umum' }}
                                        </p>
                                    </div>
                                    <span class="text-[10px] font-semibold text-gray-400 whitespace-nowrap shrink-0">
                                        {{ $item->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <span
                                    class="inline-block mt-2 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-md border {{ $statusColor }}">
                                    {{ $item->status_laporan }}
                                </span>
                            </div>
                        </div>

                    @empty
                        <div class="text-center py-8">
                            <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <p class="text-sm text-gray-400 font-medium">Belum ada aktivitas terbaru.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- ── Tabel Antrian Identifikasi ───────────────────────────────── --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold font-montserrat text-neutral">Antrian Identifikasi</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Laporan yang belum ditugaskan kepada petugas.</p>
                </div>
                <a href="{{ url('/admin/identifikasi') }}"
                    class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr class="text-xs font-bold uppercase tracking-wider text-gray-500">
                            <th class="px-6 py-4">ID Laporan</th>
                            <th class="px-6 py-4">Judul</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Foto</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($laporanAntrean as $laporan)
                            <tr class="hover:bg-gray-50/50 transition-colors">

                                <td class="px-6 py-4">
                                    <span class="text-xs font-mono font-bold text-gray-500">
                                        #RPT-{{ str_pad($laporan->id_laporan, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 font-medium text-neutral max-w-[220px]">
                                    <span class="truncate block">{{ Str::limit($laporan->judul_laporan, 40) }}</span>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full">
                                        {{ optional($laporan->kategori)->nama_kategori ?? 'Umum' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5 text-xs font-medium text-gray-500">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $laporan->fotoLaporan->isNotEmpty() ? '1 Foto' : 'Tidak ada' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="{{ url('/admin/identifikasi/detail/' . $laporan->id_laporan) }}"
                                        class="inline-block bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-primary/90 transition-all shadow-sm">
                                        Identifikasi
                                    </a>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm font-semibold text-gray-400">Semua laporan telah diidentifikasi.
                                        Hebat!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

</main>
