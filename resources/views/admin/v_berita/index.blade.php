@extends('admin.v_layouts.app')

@section('title', 'Arsip Berita - Admin SIMBO')

<main class="ml-[250px] w-[calc(100%-250px)] bg-dash-secondary min-h-screen font-worksans p-8 pt-24">

    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold font-montserrat text-neutral mb-1">Arsip Berita</h1>
            <p class="text-sm text-gray-500">Daftar berita dan informasi yang telah dipublikasikan ke publik.</p>
        </div>
        {{-- Tombol Tambah Berita Diaktifkan --}}
        <a href="{{ route('admin.berita.create') }}"
            class="px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-lg shadow-sm hover:bg-primary/90 transition-all flex items-center gap-2">
            <i class="ph ph-plus font-bold"></i> Tambah Berita
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-medium text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM FILTER --}}
    <div class="bg-white p-5 rounded-xl border border-gray-200 mb-6 shadow-sm">
        <form action="{{ route('admin.berita.index') }}" method="GET" class="flex flex-wrap items-end gap-4 w-full">

            {{-- 1. Search Bar --}}
            <div class="flex-1 min-w-[200px]">
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                    Cari Judul Berita
                </label>
                <div class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Masukkan judul..."
                        class="w-full h-10 px-4 bg-gray-50 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:border-primary focus:ring-1 focus:bg-white transition-all" />
                </div>
            </div>

            {{-- 2. Kategori --}}
            <div class="flex-1 min-w-[160px]">
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                    Kategori
                </label>
                <select name="kategori"
                    class="w-full h-10 px-3 bg-gray-50 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:border-primary focus:ring-1 focus:bg-white transition-all cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriList as $kat)
                        <option value="{{ $kat->id_kategori }}" @selected(request('kategori') == $kat->id_kategori)>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 3. Rentang Waktu (Membutuhkan ruang lebih lebar) --}}
            <div class="flex-[1.5] min-w-[280px]">
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                    Rentang Waktu
                </label>
                <div class="flex items-center gap-2">
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="w-full h-10 px-3 bg-gray-50 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:border-primary focus:ring-1 focus:bg-white transition-all" />
                    <span class="text-gray-400 font-bold">-</span>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="w-full h-10 px-3 bg-gray-50 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:border-primary focus:ring-1 focus:bg-white transition-all" />
                </div>
            </div>

            {{-- 4. Tombol Aksi --}}
            <div class="flex-shrink-0 w-full md:w-auto flex items-center justify-end gap-2 mt-2 md:mt-0">
                <a href="{{ route('admin.berita.index') }}" title="Reset Filter"
                    class="h-10 px-4 flex items-center justify-center border border-gray-300 bg-white text-gray-600 text-sm font-bold rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                    Reset
                </a>
                <button type="submit"
                    class="h-10 px-5 flex items-center justify-center bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 transition-all shadow-sm gap-2">
                    Filter
                </button>
            </div>

        </form>
    </div>

    {{-- TABEL BERITA --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Judul Berita</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Publikasi
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($berita as $item)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($item->gambar_berita)
                                        <img src="{{ asset('uploads/berita/' . $item->gambar_berita) }}"
                                            class="w-12 h-10 rounded object-cover border border-gray-200">
                                    @else
                                        <div
                                            class="w-12 h-10 rounded bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400">
                                            <i class="ph ph-image"></i>
                                        </div>
                                    @endif
                                    <span
                                        class="text-sm font-bold text-neutral line-clamp-2">{{ $item->judul_berita }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ optional($item->kategori)->nama_kategori ?? 'Umum' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ optional($item->tanggal_publish)->translatedFormat('d M Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->status_arsip == 'aktif')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] uppercase font-bold border border-emerald-100">Aktif</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-[10px] uppercase font-bold border border-gray-200">Diarsipkan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.berita.edit', $item->id_berita) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-all">
                                        <i class="ph ph-pencil-simple text-sm"></i>
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.berita.destroy', $item->id_berita) }}" method="POST"
                                        class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this.form)"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-all">
                                            <i class="ph ph-trash text-sm"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400 text-sm">Tidak ada berita yang
                                ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Menampilkan Pagination Default Tailwind dari Laravel --}}
        @if ($berita->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $berita->links() }}
            </div>
        @endif
    </div>

    <script>
        function confirmDelete(form) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Warna merah (Tailwind red-500)
                cancelButtonColor: '#6b7280', // Warna abu-abu (Tailwind gray-500)
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Jika klik "Ya", jalankan fungsi submit form
                }
            });
        }
    </script>

</main>
