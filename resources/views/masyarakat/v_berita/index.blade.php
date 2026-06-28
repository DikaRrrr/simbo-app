@extends('masyarakat.v_layouts.app')

@section('title', 'SIMBO - Berita Masyarakat')
@section('page_title', 'Berita Masyarakat')

@section('content')
    <div class="p-8 max-w-7xl mx-auto w-full">

        <div class="mb-10">
            <h1 class="font-montserrat font-black text-4xl text-primary tracking-tighter mb-2">
                BUITENZORG <span class="font-normal italic text-on-surface-variant">NEWS</span>
            </h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant mb-8">Platform berita terkini terkait KOTA BOGOR</p>

            <form action="{{ route('berita.index') }}" method="GET" class="relative w-full max-w-4xl">
                {{-- Pertahankan filter kategori jika sedang aktif --}}
                @if (request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif

                <span
                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input name="q" value="{{ request('q') }}" type="text"
                    class="w-full pl-12 pr-6 py-4 bg-inputBg border-none rounded-full focus:ring-2 focus:ring-primary font-body-md text-body-md transition-all placeholder:text-on-surface-variant placeholder:opacity-50"
                    placeholder="Cari berita terbaru tentang KOTA BOGOR" />

                {{-- Tombol submit tersembunyi agar bisa di-enter --}}
                <button type="submit" class="hidden"></button>
            </form>
        </div>

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
            <h3 class="font-headline-sm text-headline-sm text-primary flex items-center gap-2">
                Berita Terbaru
            </h3>

            <div class="relative min-w-[200px] w-full md:w-auto">
                <select onchange="window.location.href=this.value"
                    class="w-full appearance-none px-4 py-2.5 bg-transparent border border-outline-variant rounded-lg text-label-md font-semibold text-on-surface-variant cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors">

                    {{-- Opsi "Semua Kategori" --}}
                    <option value="{{ route('berita.index', ['q' => request('q')]) }}"
                        {{ !request('kategori') ? 'selected' : '' }}>
                        Semua Kategori
                    </option>

                    {{-- Looping Opsi Kategori dari Database --}}
                    @foreach ($kategoris as $kat)
                        <option value="{{ route('berita.index', ['kategori' => $kat->id_kategori, 'q' => request('q')]) }}"
                            {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach

                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($beritas as $item)
                <article
                    class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col group">
                    <div class="h-52 relative overflow-hidden bg-gray-100">
                        @if ($item->gambar_berita)
                            <img src="{{ asset('uploads/berita/' . $item->gambar_berita) }}" alt="{{ $item->judul_berita }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out" />
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <span class="material-symbols-outlined text-5xl opacity-50">image</span>
                            </div>
                        @endif

                        {{-- Badge Terbaru --}}
                        @if (\Carbon\Carbon::parse($item->tanggal_publish)->diffInHours(now()) <= 24)
                            <div
                                class="absolute top-4 left-4 px-3 py-1 bg-primary text-white text-[10px] font-extrabold tracking-wider uppercase rounded">
                                Terbaru
                            </div>
                        @endif
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 text-xs font-medium text-gray-500 mb-3">
                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                            <span>{{ \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('d M Y, H:i') }}
                                WIB</span>
                        </div>

                        <h4
                            class="font-montserrat text-lg font-bold text-gray-900 mb-3 leading-snug group-hover:text-primary transition-colors line-clamp-2">
                            {{ $item->judul_berita }}
                        </h4>

                        <p class="text-sm text-gray-600 line-clamp-3 mb-5 leading-relaxed">
                            {{ Str::limit(strip_tags($item->isi_berita), 120) }}
                        </p>

                        <div class="mt-auto pt-4 flex items-center justify-between border-t border-gray-100">

                            {{-- Link Diaktifkan --}}
                            <a href="{{ route('berita.show', $item->id_berita) }}"
                                class="flex items-center gap-1 text-primary font-bold text-sm hover:underline group-hover:translate-x-1 transition-transform">
                                Baca Selengkapnya
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
            <article
                class="col-span-1 md:col-span-2 lg:col-span-3 bg-surface-container border border-outline-variant border-dashed rounded-xl overflow-hidden shadow-sm flex flex-col items-center justify-center p-12 opacity-80">
                <span class="material-symbols-outlined text-5xl text-on-surface-variant mb-4">article</span>
                <p class="font-label-md text-label-md text-on-surface-variant text-center mb-4">
                    @if (request('q') || request('kategori'))
                        Tidak ada berita yang sesuai dengan kriteria pencarian Anda.
                    @else
                        Belum ada berita yang dipublikasikan.
                    @endif
                </p>
                @if (request('q') || request('kategori'))
                    <a href="{{ route('berita.index') }}"
                        class="px-4 py-2 bg-primary text-white rounded-lg text-label-md font-bold hover:bg-primary/90 transition-colors">
                        Reset Filter
                    </a>
                @endif
            </article>
            @endforelse

        </div>

        <div class="mt-12">
            {{ $beritas->links() }}
        </div>

    </div>
@endsection
