@extends('admin.v_layouts.app')

@section('title', 'Kirim Notifikasi - Admin SIMBO')

<main class="ml-[250px] w-[calc(100%-250px)] bg-dash-secondary min-h-screen font-worksans p-8 pt-24">
    
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold font-montserrat text-neutral mb-1">Kirim Notifikasi Baru</h1>
            <p class="text-sm text-gray-500">Buat pesan siaran atau kirim langsung ke spesifik pengguna.</p>
        </div>
        <a href="{{ route('admin.notifikasi.index') }}" class="px-5 py-2.5 border border-gray-300 bg-white text-gray-700 text-sm font-bold rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm max-w-3xl">
        <form action="{{ route('admin.notifikasi.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-neutral mb-2">Target Penerima</label>
                <select name="target_user" required class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm outline-none focus:border-primary focus:ring-1 focus:bg-white transition-all">
                    <option value="semua">📢 Broadcast ke SEMUA Pengguna</option>
                    <optgroup label="Pengguna Spesifik">
                        @foreach($masyarakat as $user)
                            <option value="{{ $user->id_masyarakat }}">👤 {{ $user->nama_lengkap }} ({{ $user->email }})</option>
                        @endforeach
                    </optgroup>
                </select>
                <p class="text-[11px] text-gray-400 mt-1">Pilih dengan hati-hati. Opsi Broadcast akan mengirimkan notifikasi ke ribuan akun sekaligus.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-neutral mb-2">Tipe Notifikasi</label>
                    <select name="tipe_notifikasi" required class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm outline-none focus:border-primary focus:ring-1 focus:bg-white transition-all">
                        <option value="pengumuman">Pengumuman (Info Umum/Berita)</option>
                        <option value="sistem">Sistem (Peringatan/Akun)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-neutral mb-2">Tautan Target (Opsional)</label>
                    <input type="url" name="link_target" value="{{ old('link_target') }}" placeholder="https://..."
                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm outline-none focus:border-primary focus:ring-1 focus:bg-white transition-all">
                    <p class="text-[11px] text-gray-400 mt-1">URL yang dituju saat pengguna mengklik notifikasi.</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral mb-2">Judul Notifikasi</label>
                <input type="text" name="judul_notifikasi" value="{{ old('judul_notifikasi') }}" required maxlength="100" placeholder="Cth: Perbaikan Layanan Jaringan..."
                    class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm outline-none focus:border-primary focus:ring-1 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral mb-2">Isi Pesan Notifikasi</label>
                <textarea name="isi_notifikasi" required rows="4" placeholder="Tulis pesan lengkap di sini..."
                    class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm outline-none focus:border-primary focus:ring-1 focus:bg-white transition-all">{{ old('isi_notifikasi') }}</textarea>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-200">
                <button type="submit" class="px-8 py-3 rounded-xl bg-primary text-white text-sm font-bold hover:bg-primary/90 shadow-sm transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Kirim Sekarang
                </button>
            </div>
        </form>
    </div>
</main>
