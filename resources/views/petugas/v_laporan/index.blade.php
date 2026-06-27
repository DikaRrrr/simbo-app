@extends('petugas.v_layouts.app')

@section('title', 'Daftar Laporan')
@section('page_title', 'Daftar Laporan')

@section('content')
    <div class="bg-white rounded-2xl border border-tertiary overflow-hidden">
        <div class="p-6 border-b border-tertiary">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h3 class="font-bold font-montserrat text-lg">Data Laporan Masyarakat</h3>
                    <p class="text-sm text-neutral/50 mt-1">Laporan ditampilkan langsung dari tabel laporan.</p>
                </div>

                <form method="GET" action="{{ route('petugas.laporan.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari laporan..."
                        class="w-full sm:w-64 rounded-xl border border-tertiary bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:bg-white">
                    <select name="status" class="rounded-xl border border-tertiary bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:bg-white">
                        <option value="">Semua Status</option>
                        <option value="Menunggu" @selected(request('status') === 'Menunggu')>Menunggu</option>
                        <option value="Diproses" @selected(request('status') === 'Diproses')>Diproses</option>
                        <option value="Selesai" @selected(request('status') === 'Selesai')>Selesai</option>
                        <option value="Ditolak" @selected(request('status') === 'Ditolak')>Ditolak</option>
                    </select>
                    <button class="rounded-xl bg-primary px-5 py-3 text-sm font-bold text-white hover:bg-primary/90">Filter</button>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-inputBg text-neutral/70 font-semibold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Masyarakat</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Laporan</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4">Prioritas</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tanggal</th>
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
                            <td class="px-6 py-4">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                            <td class="px-6 py-4 text-neutral/70">{{ \Illuminate\Support\Str::limit($item->judul_laporan, 45) }}</td>
                            <td class="px-6 py-4 text-neutral/70">{{ \Illuminate\Support\Str::limit($item->lokasi, 35) }}</td>
                            <td class="px-6 py-4"><span class="{{ $prioritasClass }} text-[10px] font-bold px-3 py-1 rounded-full uppercase">{{ $prioritas }}</span></td>
                            <td class="px-6 py-4"><span class="{{ $statusClass }} text-[10px] font-bold px-3 py-1 rounded-full uppercase">{{ $statusLabel }}</span></td>
                            <td class="px-6 py-4 text-neutral/60">{{ optional($item->tanggal_laporan)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-neutral/50">Data laporan belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-tertiary">
            {{ $laporan->links() }}
        </div>
    </div>
@endsection