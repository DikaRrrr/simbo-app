@extends('petugas.v_layouts.app')

@section('title', 'Mengelola Berita')
@section('page_title', 'Mengelola Berita')

@section('header_action')
    <a href="{{ route('petugas.berita.create') }}"
        class="rounded-xl bg-primary px-5 py-3 text-sm font-bold text-white hover:bg-primary/90 shadow-sm transition-colors">
        Tambah Berita
    </a>
@endsection

@section('content')
    {{-- 1. BAGIAN STATISTIK (Dikembalikan isinya) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-tertiary shadow-sm flex flex-col justify-center">
            <p class="text-neutral/60 text-xs font-semibold uppercase tracking-wider">Total Berita Petugas</p>
            <h3 class="text-3xl font-bold font-montserrat mt-2 text-primary">{{ $totalBeritaPetugas ?? 0 }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-tertiary shadow-sm flex flex-col justify-center">
            <p class="text-neutral/60 text-xs font-semibold uppercase tracking-wider">Aktif</p>
            <h3 class="text-3xl font-bold font-montserrat mt-2 text-primary">{{ $totalAktif ?? 0 }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-tertiary shadow-sm flex flex-col justify-center">
            <p class="text-neutral/60 text-xs font-semibold uppercase tracking-wider">Diarsipkan</p>
            <h3 class="text-3xl font-bold font-montserrat mt-2 text-secondary">{{ $totalDiarsipkan ?? 0 }}</h3>
        </div>
    </div>

    {{-- 2. BAGIAN TABEL & FILTER --}}
    <div class="bg-white rounded-2xl border border-tertiary overflow-hidden shadow-sm">

        {{-- Header Tabel & Filter --}}
        <div class="p-5 border-b border-tertiary">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
                <div>
                    <h3 class="font-bold font-montserrat text-lg text-neutral">Daftar Berita</h3>
                    <p class="text-xs text-neutral/50 mt-0.5">Data berita milik petugas login.</p>
                </div>

                {{-- Container Filter & Export --}}
                <div class="flex items-center gap-2">
                    <form method="GET" action="{{ route('petugas.berita.index') }}" class="flex items-center gap-2">
                        {{-- Input Pencarian lebih ramping --}}
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..."
                            class="w-32 md:w-48 rounded-lg border border-tertiary bg-inputBg px-3 py-2 text-xs outline-none focus:border-primary focus:bg-white transition-colors">

                        {{-- Select lebih ramping --}}
                        <select name="status"
                            class="rounded-lg border border-tertiary bg-inputBg px-2 py-2 text-xs outline-none focus:border-primary focus:bg-white transition-colors">
                            <option value="">Status</option>
                            <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                            <option value="diarsipkan" @selected(request('status') === 'diarsipkan')>Arsip</option>
                        </select>

                        <button type="submit"
                            class="rounded-lg bg-primary px-4 py-2 text-xs font-bold text-white hover:bg-primary/90 transition-colors">
                            Filter
                        </button>
                    </form>

                    {{-- Tombol Export PDF Ramping --}}
                    <a href="{{ route('petugas.berita.export', request()->query()) }}" target="_blank"
                        class="flex items-center justify-center gap-1.5 rounded-lg bg-red-600 px-4 py-2 text-xs font-bold text-white hover:bg-red-700 transition-colors shadow-sm shrink-0">
                        <i class="ph ph-file-pdf text-sm"></i>
                        PDF
                    </a>
                </div>
            </div>
        </div>

        {{-- Isi Tabel (Dikembalikan isinya) --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left whitespace-nowrap">
                <thead class="bg-inputBg text-neutral/70 font-semibold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Gambar</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Judul</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tgl Publish</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-tertiary">
                    @forelse ($berita as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold">#{{ str_pad($item->id_berita, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->gambar_berita)
                                    <img src="{{ $item->gambar_url }}" alt="Gambar"
                                        class="h-12 w-16 rounded-lg object-cover border border-tertiary shadow-sm">
                                @else
                                    <div
                                        class="h-12 w-16 rounded-lg bg-gray-100 flex items-center justify-center border border-tertiary text-xs text-gray-400">
                                        Kosong
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-semibold text-primary">
                                {{ optional($item->kategori)->nama_kategori ?? 'Umum' }}
                            </td>
                            <td class="px-6 py-4 font-semibold">
                                {{ \Illuminate\Support\Str::limit($item->judul_berita, 40) }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="{{ $item->status_arsip === 'aktif' ? 'bg-green-100 text-green-800 border-green-200' : 'bg-gray-100 text-gray-700 border-gray-200' }} border text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wide">
                                    {{ $item->status_arsip }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-neutral/60">
                                {{ optional($item->tanggal_publish)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('petugas.berita.edit', $item->id_berita) }}"
                                    class="inline-flex items-center justify-center rounded-lg bg-neutral px-4 py-2 text-xs font-bold text-white hover:bg-neutral/80 transition-colors">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-neutral/50 bg-gray-50/50">
                                <i class="ph ph-newspaper text-4xl mb-2 text-gray-300"></i>
                                <p>Belum ada data berita yang sesuai kriteria.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 3. BAGIAN PAGINASI --}}
        <div class="p-6 border-t border-tertiary">
            {{ $berita->links() }}
        </div>
    </div>
@endsection
