@extends('petugas.v_layouts.app')

@section('title', 'Mengelola Berita')
@section('page_title', 'Mengelola Berita')

@section('header_action')
    <a href="{{ route('petugas.berita.create') }}" class="rounded-xl bg-primary px-5 py-3 text-sm font-bold text-white hover:bg-primary/90">
        Tambah Berita
    </a>
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-tertiary shadow-sm">
            <p class="text-neutral/60 text-xs font-semibold uppercase tracking-wider">Total Berita Petugas</p>
            <h3 class="text-3xl font-bold font-montserrat mt-2 text-primary">{{ $totalBeritaPetugas }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-tertiary shadow-sm">
            <p class="text-neutral/60 text-xs font-semibold uppercase tracking-wider">Aktif</p>
            <h3 class="text-3xl font-bold font-montserrat mt-2 text-primary">{{ $totalAktif }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-tertiary shadow-sm">
            <p class="text-neutral/60 text-xs font-semibold uppercase tracking-wider">Diarsipkan</p>
            <h3 class="text-3xl font-bold font-montserrat mt-2 text-secondary">{{ $totalDiarsipkan }}</h3>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-tertiary overflow-hidden">
        <div class="p-6 border-b border-tertiary">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h3 class="font-bold font-montserrat text-lg">Daftar Berita</h3>
                    <p class="text-sm text-neutral/50 mt-1">Data terhubung ke tabel berita dan hanya menampilkan berita milik petugas login.</p>
                </div>

                <form method="GET" action="{{ route('petugas.berita.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita..."
                        class="w-full sm:w-64 rounded-xl border border-tertiary bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:bg-white">
                    <select name="status" class="rounded-xl border border-tertiary bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:bg-white">
                        <option value="">Semua Status</option>
                        <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                        <option value="diarsipkan" @selected(request('status') === 'diarsipkan')>Diarsipkan</option>
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
                        <th class="px-6 py-4">Judul</th>
                        <th class="px-6 py-4">Isi Singkat</th>
                        <th class="px-6 py-4">Tanggal Publish</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-tertiary">
                    @forelse ($berita as $item)
                        <tr>
                            <td class="px-6 py-4 font-mono font-bold">#{{ str_pad($item->id_berita, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 font-semibold">{{ \Illuminate\Support\Str::limit($item->judul_berita, 45) }}</td>
                            <td class="px-6 py-4 text-neutral/70">{{ \Illuminate\Support\Str::limit(strip_tags($item->isi_berita), 70) }}</td>
                            <td class="px-6 py-4 text-neutral/60">{{ optional($item->tanggal_publish)->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <span class="{{ $item->status_arsip === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }} text-[10px] font-bold px-3 py-1 rounded-full uppercase">
                                    {{ $item->status_arsip }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('petugas.berita.edit', $item->id_berita) }}" class="text-primary font-bold hover:underline">Edit</a>
                                    <form action="{{ route('petugas.berita.destroy', $item->id_berita) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-700 font-bold hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-neutral/50">Belum ada berita.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-tertiary">
            {{ $berita->links() }}
        </div>
    </div>
@endsection