@extends('petugas.v_layouts.app')

@section('title', 'Dashboard Petugas')
@section('page_title', 'Halo, ' . (Auth::guard('petugas')->user()->nama_petugas ?? 'Petugas'))

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-tertiary shadow-sm">
            <p class="text-neutral/60 text-xs font-semibold uppercase tracking-wider">Total Laporan Masuk</p>
            <h3 class="text-3xl font-bold font-montserrat mt-2 text-primary">{{ $totalLaporan }}</h3>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-tertiary shadow-sm">
            <p class="text-neutral/60 text-xs font-semibold uppercase tracking-wider">Diproses</p>
            <h3 class="text-3xl font-bold font-montserrat mt-2 text-secondary">{{ $totalDiproses }}</h3>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-tertiary shadow-sm">
            <p class="text-neutral/60 text-xs font-semibold uppercase tracking-wider">Selesai</p>
            <h3 class="text-3xl font-bold font-montserrat mt-2 text-primary">{{ $totalSelesai }}</h3>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-tertiary shadow-sm">
            <p class="text-neutral/60 text-xs font-semibold uppercase tracking-wider">Total Berita Petugas</p>
            <h3 class="text-3xl font-bold font-montserrat mt-2 text-secondary">{{ $totalBeritaPetugas }}</h3>
            <p class="text-xs text-neutral/50 mt-1">Total berita sistem: {{ $totalBerita }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-2xl border border-tertiary overflow-hidden">
            <div class="p-6 border-b border-tertiary flex justify-between items-center">
                <h3 class="font-bold font-montserrat">Laporan Terbaru</h3>
                <a href="{{ route('petugas.laporan.index') }}" class="text-sm font-semibold text-primary hover:underline">Lihat Semua</a>
            </div>

            <table class="w-full text-sm text-left">
                <thead class="bg-inputBg text-neutral/70 font-semibold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Masyarakat</th>
                        <th class="px-6 py-4">Laporan</th>
                        <th class="px-6 py-4">Prioritas</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-tertiary">
                    @forelse ($laporanTerbaru as $item)
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
                                'diproses' => 'bg-blue-100 text-blue-800',
                                'selesai' => 'bg-green-100 text-green-800',
                                'ditolak' => 'bg-red-100 text-red-800',
                                default => 'bg-yellow-100 text-yellow-800',
                            };
                            $prioritas = $item->prioritas_laporan ?? 'Sedang';
                            $prioritasClass = match (strtolower($prioritas)) {
                                'tinggi' => 'bg-red-100 text-red-800',
                                'rendah' => 'bg-green-100 text-green-800',
                                default => 'bg-yellow-100 text-yellow-800',
                            };
                        @endphp
                        <tr>
                            <td class="px-6 py-4 font-mono font-bold">#{{ str_pad($item->id_laporan, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 font-semibold">{{ $item->masyarakat->nama_lengkap ?? '-' }}</td>
                            <td class="px-6 py-4 text-neutral/70">{{ \Illuminate\Support\Str::limit($item->judul_laporan, 35) }}</td>
                            <td class="px-6 py-4">
                                <span class="{{ $prioritasClass }} text-[10px] font-bold px-3 py-1 rounded-full uppercase">{{ $prioritas }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="{{ $statusClass }} text-[10px] font-bold px-3 py-1 rounded-full uppercase">{{ $statusLabel }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-neutral/50">Belum ada data laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-2xl border border-tertiary overflow-hidden">
            <div class="p-6 border-b border-tertiary flex justify-between items-center">
                <h3 class="font-bold font-montserrat">Berita Terbaru</h3>
                <a href="{{ route('petugas.berita.index') }}" class="text-sm font-semibold text-primary hover:underline">Kelola</a>
            </div>

            <div class="divide-y divide-tertiary">
                @forelse ($beritaTerbaru as $item)
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3">
                            <h4 class="font-bold text-sm leading-5">{{ \Illuminate\Support\Str::limit($item->judul_berita, 55) }}</h4>
                            <span class="{{ $item->status_arsip === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }} text-[10px] font-bold px-2 py-1 rounded-full uppercase shrink-0">
                                {{ $item->status_arsip }}
                            </span>
                        </div>
                        <p class="text-xs text-neutral/50 mt-2">{{ optional($item->tanggal_publish)->format('d M Y H:i') }}</p>
                    </div>
                @empty
                    <div class="p-8 text-center text-neutral/50 text-sm">Belum ada berita yang dibuat petugas.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection