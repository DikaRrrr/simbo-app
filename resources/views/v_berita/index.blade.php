@extends('v_layouts.app')

@section('title', 'Berita Terkini - SIMBO')

@section('content')
    <main class="w-full bg-white">

        {{-- ════════════════════════════════════════════════════════
         HEADER HALAMAN
    ════════════════════════════════════════════════════════ --}}
        <section class="bg-primary py-16 md:py-20 text-white text-center">
            <div class="max-w-3xl mx-auto px-6">
                <span
                    class="bg-white/10 border border-white/20 text-white font-montserrat font-bold px-6 py-2 rounded-full text-xs md:text-sm tracking-wide inline-block mb-6">
                    Arsip Berita
                </span>
                <h1 class="font-montserrat text-3xl md:text-4xl font-extrabold leading-tight mb-4">
                    Kabar Terkini Seputar Kota Bogor
                </h1>
                <p class="font-worksans text-sm md:text-base text-white/80 leading-relaxed">
                    Update layanan publik, infrastruktur, dan informasi penting lainnya dari tim SIMBO.
                </p>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12 md:py-16">

            {{-- ── Search Bar ──────────────────────────────────────── --}}
            <form action="{{ route('berita.index') }}" method="GET" class="mb-10 max-w-md mx-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-neutral/40">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul berita..."
                        class="w-full h-12 rounded-full border border-tertiary bg-white pl-11 pr-4 text-sm font-medium text-neutral outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all shadow-sm">
                </div>
            </form>

            {{-- ── Grid Berita ─────────────────────────────────────── --}}
            @if ($berita->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-10">
                    @foreach ($berita as $item)
                        <a href="{{ route('berita.show', $item->id_berita) }}" class="group cursor-pointer">
                            <div
                                class="bg-tertiary aspect-[4/3] rounded-[2rem] overflow-hidden transform group-hover:-translate-y-2 transition-all duration-300 shadow-md mb-5 relative">
                                @if ($item->gambar_berita)
                                    <img src="{{ asset($item->gambar_berita) }}"
                                        alt="{{ $item->judul_berita }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-neutral/20">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8" />
                                        </svg>
                                    </div>
                                @endif

                                {{-- Badge kategori --}}
                                <span
                                    class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-primary text-[10px] font-bold px-3 py-1 rounded-full shadow-sm">
                                    {{ optional($item->kategori)->nama_kategori ?? 'Umum' }}
                                </span>
                            </div>

                            <h4
                                class="font-montserrat font-bold text-base leading-snug text-neutral group-hover:text-primary transition-colors line-clamp-2 mb-2">
                                {{ $item->judul_berita }}
                            </h4>
                            <p class="font-worksans text-xs text-neutral/50">
                                {{ \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('d F Y') }}
                            </p>
                        </a>
                    @endforeach
                </div>

                {{-- ── Pagination ──────────────────────────────────── --}}
                <div class="mt-14 flex justify-center">
                    {{ $berita->links() }}
                </div>
            @else
                {{-- ── Empty State ─────────────────────────────────── --}}
                <div class="py-20 text-center">
                    <div class="w-16 h-16 rounded-full bg-tertiary/30 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-neutral/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="font-montserrat font-bold text-neutral mb-1">
                        @if (request('q'))
                            Berita "{{ request('q') }}" tidak ditemukan
                        @else
                            Belum ada berita
                        @endif
                    </h3>
                    <p class="text-sm text-neutral/50">
                        @if (request('q'))
                            Coba gunakan kata kunci lain.
                        @else
                            Berita akan tampil di sini setelah dipublikasikan.
                        @endif
                    </p>
                    @if (request('q'))
                        <a href="{{ route('berita.index') }}"
                            class="inline-block mt-4 text-xs font-bold text-primary hover:underline">
                            ← Lihat semua berita
                        </a>
                    @endif
                </div>
            @endif

        </div>

    </main>
@endsection
