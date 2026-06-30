@extends('masyarakat.v_layouts.app')

@section('content')
<div class="p-8 max-w-5xl mx-auto w-full">
    
    {{-- Header Buitenzorg News --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-gray-200 pb-6">
        <div>
            <h1 class="font-montserrat font-black text-2xl text-primary tracking-tighter">
                BUITENZORG <span class="font-normal italic text-gray-500">NEWS</span>
            </h1>
            <p class="text-sm text-gray-500 mt-1">Platform berita terkini terkait KOTA BOGOR</p>
        </div>
        
        {{-- Search Bar Mini --}}
        <form action="{{ route('berita.index') }}" method="GET" class="relative w-full md:w-72">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">search</span>
            <input name="q" type="text" placeholder="Cari berita..." 
                class="w-full pl-9 pr-4 py-2 bg-gray-100 border-none rounded-full focus:ring-2 focus:ring-primary text-sm transition-all">
        </form>
    </div>

    {{-- Judul Berita --}}
    <h1 class="text-3xl md:text-4xl font-bold font-montserrat text-gray-900 leading-tight mb-6">
        {{ $berita->judul_berita }}
    </h1>

    {{-- Metadata Berita --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div class="text-sm">
            <span class="font-bold text-gray-900">SIMBO News,</span> 
            <span class="text-gray-600">{{ \Carbon\Carbon::parse($berita->tanggal_publish)->translatedFormat('d F Y, H:i') }} WIB</span>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="text-right">
                {{-- Ambil nama penulis jika ada relasi user/admin, jika tidak pakai Admin SIMBO --}}
                <p class="font-bold text-sm text-gray-900">{{ $berita->admin->nama ?? 'Admin SIMBO' }}</p>
                <p class="text-xs text-gray-500">Penulis</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-gray-300 overflow-hidden flex items-center justify-center border border-gray-200">
                <i class="ph ph-user text-gray-500 text-xl"></i>
            </div>
        </div>
    </div>

    {{-- Hero Image --}}
    @if ($berita->gambar_berita)
        <div class="w-full h-[300px] md:h-[450px] rounded-2xl overflow-hidden mb-10 shadow-sm">
            <img src="{{ asset($berita->gambar_berita) }}" alt="{{ $berita->judul_berita }}"
                class="w-full h-full object-cover">
        </div>
    @endif

    {{-- Konten Berita --}}
    <div class="bg-[#f5f5f5] rounded-3xl p-6 md:p-10 mb-10">
        {{-- Karena output dari CKEditor berupa tag HTML, kita harus menggunakan {!! !!} --}}
        <div class="prose max-w-none text-gray-800 prose-p:leading-relaxed prose-headings:font-montserrat prose-headings:text-gray-900 prose-a:text-primary">
            {!! $berita->isi_berita !!}
        </div>
    </div>

    {{-- Tombol Kembali --}}
    <div class="mt-8 border-t border-gray-200 pt-8">
        <a href="{{ route('masyarakat.berita.index') }}" class="inline-flex items-center gap-2 text-primary font-bold hover:underline">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali ke Indeks Berita
        </a>
    </div>

</div>
@endsection