@extends('admin.v_layouts.app')

@section('title', 'Kelola Kategori - Admin SIMBO')

<main class="ml-[250px] w-[calc(100%-250px)] bg-dash-secondary min-h-screen font-worksans p-8 pt-24">
    
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold font-montserrat text-neutral mb-1">Kelola Kategori</h1>
            <p class="text-sm text-gray-500">Manajemen daftar kategori untuk laporan dan berita.</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}" class="px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-lg shadow-sm hover:bg-primary/90 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Tambah Kategori
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-medium text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Sederhana --}}
    <div class="bg-white p-4 rounded-xl border border-gray-200 mb-6 shadow-sm">
        <form action="{{ route('admin.kategori.index') }}" method="GET" class="flex items-center gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kategori..."
                class="w-full md:w-96 h-10 px-4 bg-gray-50 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-primary focus:bg-white transition-all" />
            <button type="submit" class="h-10 px-5 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 transition-all">Cari</button>
            @if(request('q'))
                <a href="{{ route('admin.kategori.index') }}" class="h-10 px-5 flex items-center bg-gray-100 text-gray-600 text-sm font-bold rounded-lg hover:bg-gray-200 transition-all">Reset</a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-20">ID</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kategoris as $item)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4 font-mono text-sm font-bold text-gray-400">#{{ $item->id_kategori }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $item->nama_kategori }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.kategori.edit', $item->id_kategori) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-all">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.kategori.destroy', $item->id_kategori) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this.form)" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-all">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada kategori yang ditambahkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($kategoris->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $kategoris->links() }}
            </div>
        @endif
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(form) {
        Swal.fire({
            title: 'Hapus Kategori?',
            text: "Jika dihapus, pastikan tidak ada laporan/berita yang menggunakan kategori ini.",
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
