@extends('petugas.v_layouts.app')

@section('title', 'Daftar Laporan')
@section('page_title', 'Daftar Laporan')

@section('content')
    <div class="bg-white rounded-2xl border border-tertiary shadow-sm overflow-hidden">

        {{-- HEADER COMPACT (Ringkas agar hemat ruang vertikal) --}}
        <div class="p-5 border-b border-tertiary">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
                <div>
                    <h3 class="font-bold font-montserrat text-lg text-neutral">Data Laporan Masyarakat</h3>
                    <p class="text-xs text-neutral/50 mt-0.5">Laporan ditampilkan langsung dari tabel laporan.</p>
                </div>

                <div class="flex items-center gap-2">
                    <form method="GET" action="{{ route('petugas.laporan.index') }}" class="flex items-center gap-2">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..."
                            class="w-32 md:w-48 rounded-lg border border-tertiary bg-inputBg px-3 py-2 text-xs outline-none focus:border-primary focus:bg-white transition-colors">

                        <select name="status"
                            class="rounded-lg border border-tertiary bg-inputBg px-2 py-2 text-xs outline-none focus:border-primary focus:bg-white transition-colors">
                            <option value="">Status</option>
                            <option value="Menunggu" @selected(request('status') === 'Menunggu')>Menunggu</option>
                            <option value="Diproses" @selected(request('status') === 'Diproses')>Diproses</option>
                            <option value="Selesai" @selected(request('status') === 'Selesai')>Selesai</option>
                            <option value="Ditolak" @selected(request('status') === 'Ditolak')>Ditolak</option>
                        </select>

                        <button type="submit"
                            class="rounded-lg bg-primary px-4 py-2 text-xs font-bold text-white hover:bg-primary/90 transition-colors">
                            Filter
                        </button>
                    </form>

                    <a href="{{ route('petugas.laporan.export', request()->query()) }}" target="_blank"
                        class="flex items-center justify-center gap-1.5 rounded-lg bg-red-600 px-4 py-2 text-xs font-bold text-white hover:bg-red-700 transition-colors shadow-sm shrink-0">
                        <i class="ph ph-file-pdf text-sm"></i> PDF
                    </a>
                </div>
            </div>
        </div>

        {{-- TABEL COMPACT (Digabung menjadi 5 kolom utama) --}}
        <div class="w-full">
            <table class="w-full text-left border-collapse">
                <thead
                    class="bg-gray-50/50 text-neutral/50 text-[11px] font-bold uppercase tracking-wider border-b border-tertiary">
                    <tr>
                        <th class="px-5 py-4 w-[20%]">ID & Pelapor</th>
                        <th class="px-5 py-4 w-[30%]">Detail Laporan</th>
                        <th class="px-5 py-4 w-[25%]">Waktu & Lokasi</th>
                        <th class="px-5 py-4 w-[15%]">Status</th>
                        <th class="px-5 py-4 w-[10%] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-tertiary">
                    @forelse ($laporan as $item)
                        @php
                            $status = strtolower($item->status_laporan ?? 'menunggu');
                            $statusLabel = match ($status) {
                                'dikirim', 'menunggu' => 'Menunggu',
                                'diproses' => 'Diproses',
                                'selesai' => 'Selesai',
                                'ditolak' => 'Ditolak',
                                default => ucfirst($item->status_laporan ?? 'Menunggu'),
                            };
                            $statusClass = match ($status) {
                                'diproses' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'selesai' => 'bg-green-50 text-green-700 border-green-200',
                                'ditolak' => 'bg-red-50 text-red-700 border-red-200',
                                default => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                            };
                            $prioritas = $item->prioritas_laporan ?? 'Sedang';
                            $prioritasClass = match (strtolower($prioritas)) {
                                'tinggi' => 'bg-red-50 text-red-700',
                                'rendah' => 'bg-green-50 text-green-700',
                                default => 'bg-gray-50 text-gray-700',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors group">

                            {{-- 1. Kolom ID dan Pelapor --}}
                            <td class="px-5 py-3 align-top">
                                <div class="text-[11px] font-mono font-bold text-neutral/50 mb-0.5">
                                    #{{ str_pad($item->id_laporan, 3, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-sm font-bold text-neutral">
                                    {{ $item->masyarakat->nama_lengkap ?? 'Anonim' }}</div>
                            </td>

                            {{-- 2. Kolom Detail Laporan --}}
                            <td class="px-5 py-3 align-top max-w-[200px]">
                                <div class="text-[10px] font-bold text-primary mb-1 uppercase tracking-wider">
                                    {{ $item->kategori->nama_kategori ?? 'Umum' }}
                                </div>
                                <div class="text-sm text-neutral truncate" title="{{ $item->judul_laporan }}">
                                    {{ $item->judul_laporan }}
                                </div>
                            </td>

                            {{-- 3. Kolom Waktu dan Lokasi --}}
                            <td class="px-5 py-3 align-top max-w-[150px]">
                                <div class="text-xs font-semibold text-neutral/80 mb-0.5">
                                    {{ optional($item->tanggal_laporan)->format('d M Y') }}
                                </div>
                                <div class="text-[11px] text-neutral/50 truncate" title="{{ $item->lokasi }}">
                                    <i class="ph ph-map-pin mr-1"></i>{{ $item->lokasi }}
                                </div>
                            </td>

                            {{-- 4. Kolom Status dan Prioritas --}}
                            <td class="px-5 py-3 align-top">
                                <div class="flex flex-col items-start gap-1.5">
                                    <span
                                        class="border {{ $statusClass }} text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wide">
                                        {{ $statusLabel }}
                                    </span>
                                    <span
                                        class="{{ $prioritasClass }} text-[9px] font-bold px-2 py-0.5 rounded-full uppercase">
                                        Prioritas: {{ $prioritas }}
                                    </span>
                                </div>
                            </td>

                            {{-- 5. Kolom Aksi --}}
                            <td class="px-5 py-3 align-middle text-center">
                                <a href="{{ route('petugas.laporan.edit', $item->id_laporan) }}"
                                    class="inline-flex items-center justify-center rounded-lg bg-neutral px-4 py-2 text-xs font-bold text-white hover:bg-neutral/80 transition-colors shadow-sm">
                                    Edit
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-neutral/50">
                                <i class="ph ph-folder-open text-3xl mb-2 text-gray-300"></i>
                                <p>Data laporan belum tersedia.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-5 border-t border-tertiary">
            {{ $laporan->links() }}
        </div>
    </div>
@endsection
