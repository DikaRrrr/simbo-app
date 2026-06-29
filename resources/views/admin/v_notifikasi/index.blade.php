@extends('admin.v_layouts.app')

@section('title', 'Kelola Notifikasi - Admin SIMBO')

    <main class="ml-[250px] w-[calc(100%-250px)] bg-dash-secondary min-h-screen font-worksans p-8 pt-24">

        <div class="mb-6 flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-bold font-montserrat text-neutral mb-1">Kelola Notifikasi</h1>
                <p class="text-sm text-gray-500">Riwayat pengiriman notifikasi ke pengguna masyarakat.</p>
            </div>
            <a href="{{ route('admin.notifikasi.create') }}"
                class="px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-lg shadow-sm hover:bg-primary/90 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Notifikasi Baru
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-medium text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filter Sederhana --}}
        <div class="bg-white p-4 rounded-xl border border-gray-200 mb-6 shadow-sm">
            <form action="{{ route('admin.notifikasi.index') }}" method="GET" class="flex items-center gap-3">
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Cari judul atau isi notifikasi..."
                    class="w-full md:w-96 h-10 px-4 bg-gray-50 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-primary focus:bg-white transition-all" />
                <button type="submit"
                    class="h-10 px-5 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 transition-all">Cari</button>
                @if (request('q'))
                    <a href="{{ route('admin.notifikasi.index') }}"
                        class="h-10 px-5 flex items-center bg-gray-100 text-gray-600 text-sm font-bold rounded-lg hover:bg-gray-200 transition-all">Reset</a>
                @endif
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Penerima</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Isi Notifikasi
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status & Waktu
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($notifikasi as $item)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    {{ $item->masyarakat->nama_lengkap ?? 'Pengguna Dihapus' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-[10px] font-bold uppercase border
                                    {{ $item->tipe_notifikasi == 'pengumuman'
                                        ? 'bg-yellow-50 text-yellow-700 border-yellow-200'
                                        : ($item->tipe_notifikasi == 'laporan'
                                            ? 'bg-blue-50 text-blue-700 border-blue-200'
                                            : 'bg-gray-100 text-gray-700 border-gray-200') }}">
                                        {{ $item->tipe_notifikasi }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 max-w-xs">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ $item->judul_notifikasi }}</p>
                                    <p class="text-xs text-gray-500 truncate mt-0.5">{{ $item->isi_notifikasi }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div
                                        class="text-sm font-medium {{ $item->status_baca ? 'text-green-600' : 'text-gray-400' }}">
                                        {{ $item->status_baca ? 'Dibaca' : 'Terkirim' }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('admin.notifikasi.destroy', $item->id_notifikasi) }}"
                                        method="POST" class="m-0 inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this.form)"
                                            class="text-red-500 hover:text-red-700 text-sm font-bold transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400 text-sm">Tidak ada riwayat
                                    notifikasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($notifikasi->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $notifikasi->links() }}
                </div>
            @endif
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(form) {
            Swal.fire({
                title: 'Hapus Notifikasi?',
                text: "Data akan dihapus permanen dari sistem.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        }
    </script>
