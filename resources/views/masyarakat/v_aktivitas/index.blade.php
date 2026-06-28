@extends('masyarakat.v_layouts.app')

@section('title', 'Aktivitas - SIMBO')
@section('page_title', 'Aktivitas')

@section('content')
<div class="space-y-5 w-full">

    {{-- ── Filter Tab Status ──────────────────────────────────────── --}}
    <div class="flex items-center gap-2 flex-wrap">

        @php
            $tabs = [
                'semua'    => ['label' => 'Semua',     'color' => 'bg-neutral text-white',      'border' => 'border-neutral'],
                'menunggu' => ['label' => 'Menunggu',  'color' => 'bg-orange-500 text-white',   'border' => 'border-orange-500'],
                'diproses' => ['label' => 'Diproses',  'color' => 'bg-blue-500 text-white',     'border' => 'border-blue-500'],
                'selesai'  => ['label' => 'Selesai',   'color' => 'bg-green-600 text-white',    'border' => 'border-green-600'],
                'ditolak'  => ['label' => 'Ditolak',   'color' => 'bg-red-500 text-white',      'border' => 'border-red-500'],
            ];
            $activeTab = $statusFilter ?? 'semua';
        @endphp

        @foreach ($tabs as $key => $tab)
            @php $isActive = $activeTab === $key; @endphp
            <a href="{{ route('aktivitas.index', ['status' => $key]) }}"
                class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold border-2 transition-all
                    {{ $isActive
                        ? $tab['color'] . ' ' . $tab['border']
                        : 'bg-white text-gray-500 border-gray-200 hover:border-gray-300' }}">
                {{ $tab['label'] }}
                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-extrabold
                    {{ $isActive ? 'bg-white/20' : 'bg-gray-100 text-gray-500' }}">
                    {{ $counter[$key] }}
                </span>
            </a>
        @endforeach

    </div>

    {{-- ── Daftar Kartu Laporan ────────────────────────────────────── --}}
    <div class="space-y-4">

        @forelse ($laporan as $item)
            @php
                $statusConfig = match($item->status_laporan) {
                    'Menunggu' => [
                        'icon'        => 'ph-clock',
                        'iconBg'      => 'bg-orange-100',
                        'iconColor'   => 'text-orange-500',
                        'badgeBg'     => 'bg-orange-50',
                        'badgeText'   => 'text-orange-700',
                        'badgeBorder' => 'border-orange-200',
                        'barColor'    => 'bg-orange-400',
                        'barWidth'    => 'w-1/4',
                        'stepActive'  => 1,
                        'label'       => 'Menunggu',
                        'desc'        => 'Laporan Anda sedang menunggu ditinjau oleh admin.',
                    ],
                    'Diproses' => [
                        'icon'        => 'ph-arrows-clockwise',
                        'iconBg'      => 'bg-blue-100',
                        'iconColor'   => 'text-blue-500',
                        'badgeBg'     => 'bg-blue-50',
                        'badgeText'   => 'text-blue-700',
                        'badgeBorder' => 'border-blue-200',
                        'barColor'    => 'bg-blue-500',
                        'barWidth'    => 'w-2/4',
                        'stepActive'  => 2,
                        'label'       => 'Sedang Diproses',
                        'desc'        => 'Petugas lapangan sedang menangani laporan Anda.',
                    ],
                    'Selesai' => [
                        'icon'        => 'ph-check-circle',
                        'iconBg'      => 'bg-green-100',
                        'iconColor'   => 'text-green-600',
                        'badgeBg'     => 'bg-green-50',
                        'badgeText'   => 'text-green-700',
                        'badgeBorder' => 'border-green-200',
                        'barColor'    => 'bg-green-500',
                        'barWidth'    => 'w-full',
                        'stepActive'  => 3,
                        'label'       => 'Selesai',
                        'desc'        => 'Laporan Anda telah berhasil ditangani oleh petugas.',
                    ],
                    'Ditolak' => [
                        'icon'        => 'ph-x-circle',
                        'iconBg'      => 'bg-red-100',
                        'iconColor'   => 'text-red-500',
                        'badgeBg'     => 'bg-red-50',
                        'badgeText'   => 'text-red-700',
                        'badgeBorder' => 'border-red-200',
                        'barColor'    => 'bg-red-400',
                        'barWidth'    => 'w-full',
                        'stepActive'  => 0,
                        'label'       => 'Ditolak',
                        'desc'        => 'Laporan Anda tidak dapat diproses oleh admin.',
                    ],
                    default => [
                        'icon'        => 'ph-info',
                        'iconBg'      => 'bg-gray-100',
                        'iconColor'   => 'text-gray-500',
                        'badgeBg'     => 'bg-gray-50',
                        'badgeText'   => 'text-gray-700',
                        'badgeBorder' => 'border-gray-200',
                        'barColor'    => 'bg-gray-300',
                        'barWidth'    => 'w-0',
                        'stepActive'  => 0,
                        'label'       => '-',
                        'desc'        => '',
                    ],
                };

                $steps = ['Laporan Masuk', 'Ditinjau Admin', 'Ditangani Petugas', 'Selesai'];
            @endphp

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-all">

                {{-- ── Kartu Header ──────────────────────────────── --}}
                <div class="flex items-start gap-4 p-5 border-b border-gray-100">

                    {{-- Ikon Status --}}
                    <div class="w-12 h-12 rounded-xl {{ $statusConfig['iconBg'] }} {{ $statusConfig['iconColor'] }} flex items-center justify-center shrink-0">
                        <i class="ph {{ $statusConfig['icon'] }} text-2xl"></i>
                    </div>

                    {{-- Info Utama --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <span class="text-xs font-mono font-bold text-gray-400">
                                #RPT-{{ str_pad($item->id_laporan, 4, '0', STR_PAD_LEFT) }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border
                                {{ $statusConfig['badgeBg'] }} {{ $statusConfig['badgeText'] }} {{ $statusConfig['badgeBorder'] }}">
                                {{ $statusConfig['label'] }}
                            </span>
                            @if ($item->prioritas_laporan)
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border
                                    {{ $item->prioritas_laporan === 'Tinggi' ? 'bg-red-50 text-red-700 border-red-200' : ($item->prioritas_laporan === 'Sedang' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-gray-50 text-gray-600 border-gray-200') }}">
                                    Prioritas {{ $item->prioritas_laporan }}
                                </span>
                            @endif
                        </div>
                        <h3 class="text-sm font-bold text-neutral truncate">{{ $item->judul_laporan }}</h3>
                        <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1.5">
                            <i class="ph ph-tag text-xs"></i>
                            {{ optional($item->kategori)->nama_kategori ?? 'Umum' }}
                            <span class="text-gray-300">·</span>
                            <i class="ph ph-clock text-xs"></i>
                            Diperbarui {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}
                        </p>
                    </div>

                    {{-- Tombol Detail --}}
                    <a href="{{ route('aktivitas.detail', ['id' => $item->id_laporan]) }}"
                        class="shrink-0 px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-600 text-xs font-bold hover:bg-primary hover:text-white hover:border-primary transition-all flex items-center gap-1.5">
                        Detail
                        <i class="ph ph-arrow-right text-xs"></i>
                    </a>

                </div>

                {{-- ── Progress Bar & Steps ────────────────────────── --}}
                @if ($item->status_laporan !== 'Ditolak')
                    <div class="px-5 py-4">

                        {{-- Progress Bar --}}
                        <div class="w-full h-1.5 bg-gray-100 rounded-full mb-4 overflow-hidden">
                            <div class="h-full rounded-full {{ $statusConfig['barColor'] }} {{ $statusConfig['barWidth'] }} transition-all duration-500"></div>
                        </div>

                        {{-- Step Indicators --}}
                        <div class="grid grid-cols-4 gap-2">
                            @foreach ($steps as $i => $step)
                                @php $isDone = ($i + 1) <= $statusConfig['stepActive']; @endphp
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center mb-1.5
                                        {{ $isDone ? $statusConfig['barColor'] . ' text-white' : 'bg-gray-100 text-gray-400' }}">
                                        @if ($isDone)
                                            <i class="ph ph-check text-[10px] font-bold"></i>
                                        @else
                                            <span class="text-[9px] font-bold">{{ $i + 1 }}</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] font-semibold leading-tight
                                        {{ $isDone ? 'text-neutral' : 'text-gray-400' }}">
                                        {{ $step }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @else
                    {{-- State Ditolak --}}
                    <div class="px-5 py-4 flex items-center gap-3 bg-red-50/50">
                        <i class="ph ph-warning-circle text-red-400 text-lg shrink-0"></i>
                        <p class="text-xs text-red-600 font-medium">{{ $statusConfig['desc'] }}</p>
                    </div>
                @endif

                {{-- ── Footer Kartu ────────────────────────────────── --}}
                <div class="px-5 py-3 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-1.5 text-xs text-gray-400">
                        <i class="ph ph-map-pin text-xs"></i>
                        <span class="truncate max-w-[280px]">{{ $item->lokasi }}</span>
                    </div>
                    <span class="text-xs text-gray-400 shrink-0">
                        {{ \Carbon\Carbon::parse($item->tanggal_laporan ?? $item->created_at)->format('d M Y') }}
                    </span>
                </div>

            </div>
        @empty

            {{-- ── Empty State ─────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-16 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                    <i class="ph ph-tray text-3xl text-gray-300"></i>
                </div>
                <h3 class="text-base font-bold text-neutral mb-1">Belum Ada Aktivitas</h3>
                <p class="text-sm text-gray-400 max-w-xs leading-relaxed mb-6">
                    @if ($statusFilter && $statusFilter !== 'semua')
                        Tidak ada laporan dengan status "{{ ucfirst($statusFilter) }}" saat ini.
                    @else
                        Anda belum pernah mengajukan laporan. Mulai laporkan masalah di sekitar Anda.
                    @endif
                </p>
                <a href="{{ route('laporan.index') }}"
                    class="px-6 py-2.5 rounded-xl bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-all shadow-sm flex items-center gap-2">
                    <i class="ph ph-plus-circle text-lg"></i>
                    Buat Laporan
                </a>
            </div>

        @endforelse

    </div>

    {{-- ── Pagination ──────────────────────────────────────────────── --}}
    @if ($laporan->hasPages())
        <div class="flex justify-center mt-6">
            {{ $laporan->appends(request()->query())->links() }}
        </div>
    @endif

</div>
@endsection