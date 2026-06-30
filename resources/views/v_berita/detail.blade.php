@extends('v_layouts.app')

@section('title', $berita->judul_berita . ' - SIMBO')

@section('content')
    <main class="w-full bg-white">

        {{-- ════════════════════════════════════════════════════════
         HERO / GAMBAR UTAMA
    ════════════════════════════════════════════════════════ --}}
        <div class="relative w-full h-[320px] md:h-[420px] bg-neutral overflow-hidden">

            @if ($berita->gambar_berita)
                <img src="{{ asset( $berita->gambar_berita) }}" alt="{{ $berita->judul_berita }}"
                    class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary to-neutral">
                    <svg class="w-20 h-20 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8" />
                    </svg>
                </div>
            @endif

            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

            {{-- Breadcrumb di atas gambar --}}
            <div class="absolute top-6 left-0 right-0">
                <div class="max-w-4xl mx-auto px-6 lg:px-0">
                    <nav class="flex items-center gap-2 text-xs font-semibold text-white/80">
                        <a href="{{ url('/') }}" class="hover:text-white transition-colors">Beranda</a>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="{{ route('berita.index') }}" class="hover:text-white transition-colors">Berita</a>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-white truncate max-w-[180px] md:max-w-xs">{{ $berita->judul_berita }}</span>
                    </nav>
                </div>
            </div>

            {{-- Judul di atas gambar --}}
            <div class="absolute bottom-0 left-0 right-0 pb-8">
                <div class="max-w-4xl mx-auto px-6 lg:px-0">
                    <span
                        class="inline-flex items-center gap-1.5 bg-primary text-white text-xs font-bold px-4 py-1.5 rounded-full mb-4 shadow-md">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        {{ optional($berita->kategori)->nama_kategori ?? 'Umum' }}
                    </span>
                    <h1
                        class="font-montserrat text-2xl md:text-4xl font-extrabold text-white leading-snug drop-shadow-md max-w-3xl">
                        {{ $berita->judul_berita }}
                    </h1>
                </div>
            </div>
        </div>


        {{-- ════════════════════════════════════════════════════════
         KONTEN ARTIKEL
    ════════════════════════════════════════════════════════ --}}
        <article class="max-w-4xl mx-auto px-6 lg:px-0 py-10 md:py-14">

            {{-- Meta info --}}
            <div class="flex flex-wrap items-center gap-4 pb-6 mb-8 border-b border-tertiary/60 text-sm text-neutral/60">
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-neutral">Redaksi SIMBO</p>
                        <p class="text-[11px] text-neutral/50">
                            {{ \Carbon\Carbon::parse($berita->tanggal_publish)->translatedFormat('d F Y, H:i') }} WIB
                        </p>
                    </div>
                </div>

                {{-- Tombol Bagikan --}}
                <div class="ml-auto flex items-center gap-2">
                    <span class="text-xs font-semibold text-neutral/40 hidden sm:inline">Bagikan:</span>
                    <a href="https://wa.me/?text={{ urlencode($berita->judul_berita . ' - ' . url()->current()) }}"
                        target="_blank" rel="noopener"
                        class="w-8 h-8 rounded-full bg-tertiary/40 hover:bg-primary hover:text-white flex items-center justify-center text-neutral/60 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 15.68a6.34 6.34 0 006.33 6.33 6.33 6.33 0 006.33-6.33V9.56a8.28 8.28 0 004.34 1.23V7.33a4.84 4.84 0 01-2.41-.64z" />
                        </svg>
                    </a>
                    <button
                        onclick="navigator.clipboard.writeText(window.location.href); this.querySelector('span').textContent='Tersalin!'"
                        class="w-8 h-8 rounded-full bg-tertiary/40 hover:bg-primary hover:text-white flex items-center justify-center text-neutral/60 transition-colors relative group">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                        <span
                            class="absolute -top-8 left-1/2 -translate-x-1/2 text-[10px] font-bold bg-neutral text-white px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none"></span>
                    </button>
                </div>
            </div>

            {{-- Isi Berita --}}
            <div
                class="prose prose-neutral max-w-none font-worksans text-[15px] leading-relaxed text-neutral/80
                    prose-headings:font-montserrat prose-headings:text-neutral prose-headings:font-bold
                    prose-a:text-primary prose-strong:text-neutral prose-img:rounded-2xl">
                {!! $berita->isi_berita !!}
            </div>

            {{-- Tag kategori bawah --}}
            <div class="mt-10 pt-6 border-t border-tertiary/60 flex items-center gap-3 flex-wrap">
                <span class="text-xs font-bold text-neutral/40 uppercase tracking-wider">Kategori:</span>
                <span class="px-3 py-1.5 bg-primary/10 text-primary text-xs font-bold rounded-full">
                    {{ optional($berita->kategori)->nama_kategori ?? 'Umum' }}
                </span>
            </div>

        </article>


        {{-- ════════════════════════════════════════════════════════
         CTA — Ajak Lapor
    ════════════════════════════════════════════════════════ --}}
        <section class="bg-primary py-14">
            <div class="max-w-4xl mx-auto px-6 lg:px-0 text-center text-white">
                <h3 class="font-montserrat text-xl md:text-2xl font-extrabold mb-3">
                    Temukan masalah serupa di sekitarmu?
                </h3>
                <p class="text-sm text-white/80 max-w-xl mx-auto mb-6 leading-relaxed">
                    Laporkan langsung ke SIMBO agar dapat ditindaklanjuti oleh petugas terkait.
                </p>
                <a href="{{ url('/login') }}"
                    class="inline-block bg-white text-primary font-bold text-sm px-8 py-3 rounded-full hover:scale-105 transition-all duration-300 shadow-lg">
                    Mulai Lapor Sekarang
                </a>
            </div>
        </section>


        {{-- ════════════════════════════════════════════════════════
         BERITA LAINNYA
    ════════════════════════════════════════════════════════ --}}
        @if ($beritaLainnya->isNotEmpty())
            <section class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
                <h3 class="font-montserrat text-xl md:text-2xl font-extrabold text-neutral mb-8">
                    Berita Lainnya
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($beritaLainnya as $item)
                        <a href="{{ route('berita.show', $item->id_berita) }}" class="group cursor-pointer">
                            <div
                                class="bg-tertiary aspect-[4/3] rounded-[1.5rem] overflow-hidden transform group-hover:-translate-y-2 transition-all duration-300 shadow-md mb-4 relative">
                                @if ($item->gambar_berita)
                                    <img src="{{ asset('storage/' . $item->gambar_berita) }}"
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
                            </div>
                            <h4
                                class="font-montserrat font-bold text-sm md:text-base leading-snug text-neutral group-hover:text-primary transition-colors line-clamp-2">
                                {{ $item->judul_berita }}
                            </h4>
                            <p class="font-worksans text-xs text-neutral/50 mt-2">
                                {{ \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('d M Y') }}
                                · {{ optional($item->kategori)->nama_kategori ?? 'Umum' }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

    </main>
@endsection
