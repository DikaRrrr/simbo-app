@extends('admin.v_layouts.app')

@section('title', 'Tambah Kategori - Admin SIMBO')

<main class="ml-[250px] w-[calc(100%-250px)] bg-dash-secondary min-h-screen font-worksans p-8 pt-24">
    
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold font-montserrat text-neutral mb-1">Tambah Kategori Baru</h1>
            <p class="text-sm text-gray-500">Tambahkan kategori untuk memudahkan klasifikasi laporan dan berita.</p>
        </div>
        <a href="{{ route('admin.kategori.index') }}" class="px-5 py-2.5 border border-gray-300 bg-white text-gray-700 text-sm font-bold rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm max-w-2xl">
        <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-neutral mb-2">Nama Kategori</label>
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" required maxlength="100" placeholder="Cth: Infrastruktur, Pelayanan Publik..."
                    class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm outline-none focus:border-primary focus:ring-1 focus:bg-white transition-all">
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-200">
                <button type="submit" class="px-8 py-3 rounded-xl bg-primary text-white text-sm font-bold hover:bg-primary/90 shadow-sm transition-all">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</main>
