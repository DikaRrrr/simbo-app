@extends('masyarakat.v_layouts.app')

@section('title', 'Notifikasi Anda - SIMBO')

@section('content')
<div class="p-8 max-w-4xl mx-auto w-full">
    
    {{-- Header Notifikasi --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-montserrat font-black text-3xl text-gray-900 tracking-tight flex items-center gap-3">
                Notifikasi 
                @if($unreadCount > 0)
                    <span class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full">
                        {{ $unreadCount }} Baru
                    </span>
                @endif
            </h1>
            <p class="text-gray-500 text-sm mt-1">Pantau pembaruan laporan dan informasi penting lainnya.</p>
        </div>

        {{-- Tombol Tandai Semua Dibaca --}}
        @if($unreadCount > 0)
            <form action="{{ route('notifikasi.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-2 text-sm font-bold text-primary hover:text-primary/80 transition-colors bg-surface-container-high px-4 py-2 rounded-lg">
                    <i class="ph ph-check-double text-lg"></i>
                    Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    {{-- List Notifikasi --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="divide-y divide-gray-100">
            @forelse($notifikasi as $notif)
                {{-- 
                    Logika UI: 
                    Jika belum dibaca -> background biru muda, pakai link route 'read' agar status berubah.
                    Jika sudah dibaca -> background putih, langsung arahkan ke link_target.
                --}}
                @php
                    $isUnread = !$notif->status_baca;
                    $bgClass = $isUnread ? 'bg-blue-50/50 hover:bg-blue-50' : 'bg-white hover:bg-gray-50';
                    $targetUrl = $isUnread ? route('notifikasi.read', $notif->id_notifikasi) : ($notif->link_target ?? '#');
                @endphp

                <a href="{{ $targetUrl }}" class="flex items-start p-6 transition-colors duration-200 {{ $bgClass }} group relative">
                    
                    {{-- Indikator Belum Dibaca (Titik Merah di kiri) --}}
                    @if($isUnread)
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary rounded-r-full"></div>
                    @endif

                    {{-- Ikon berdasarkan tipe notifikasi --}}
                    <div class="flex-shrink-0 mr-5 mt-1">
                        @if($notif->tipe_notifikasi == 'laporan')
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                <i class="ph ph-clipboard-text text-2xl {{ $isUnread ? 'animate-pulse' : '' }}"></i>
                            </div>
                        @elseif($notif->tipe_notifikasi == 'pengumuman')
                            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                <i class="ph ph-megaphone text-2xl {{ $isUnread ? 'animate-pulse' : '' }}"></i>
                            </div>
                        @else
                            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-600">
                                <i class="ph ph-bell text-2xl"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Konten Text --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <h4 class="text-base font-bold text-gray-900 truncate">
                                {{ $notif->judul_notifikasi }}
                            </h4>
                            <span class="text-xs font-semibold text-gray-400 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 line-clamp-2">
                            {{ $notif->isi_notifikasi }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="p-12 text-center flex flex-col items-center justify-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <i class="ph ph-bell-z text-4xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Tidak ada notifikasi</h3>
                    <p class="text-sm text-gray-500">Saat ini Anda belum memiliki notifikasi baru.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $notifikasi->links() }}
    </div>

</div>
@endsection