@extends('petugas.v_layouts.app')

@section('title', 'Tambah Berita')
@section('page_title', 'Tambah Berita')

@section('header_action')
    <a href="{{ route('petugas.berita.index') }}" class="rounded-xl border border-tertiary bg-white px-5 py-3 text-sm font-bold text-primary hover:bg-inputBg">
        Kembali
    </a>
@endsection

@section('content')
    <div class="max-w-4xl bg-white rounded-2xl border border-tertiary p-8 shadow-sm">
        <form action="{{ route('petugas.berita.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="judul_berita" class="block text-sm font-bold text-neutral mb-2">Judul Berita</label>
                <input type="text" id="judul_berita" name="judul_berita" value="{{ old('judul_berita') }}" required maxlength="150"
                    placeholder="Contoh: Perbaikan Jalan di Wilayah Bogor Dimulai"
                    class="w-full rounded-xl border border-tertiary bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:bg-white">
            </div>

            <div>
                <label for="isi_berita" class="block text-sm font-bold text-neutral mb-2">Isi Berita</label>
                <textarea id="isi_berita" name="isi_berita" rows="10" required
                    placeholder="Tulis isi berita atau pengumuman untuk masyarakat..."
                    class="w-full rounded-xl border border-tertiary bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:bg-white resize-none">{{ old('isi_berita') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="tanggal_publish" class="block text-sm font-bold text-neutral mb-2">Tanggal Publish</label>
                    <input type="datetime-local" id="tanggal_publish" name="tanggal_publish" value="{{ old('tanggal_publish') }}"
                        class="w-full rounded-xl border border-tertiary bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:bg-white">
                    <p class="text-xs text-neutral/50 mt-2">Kosongkan bila ingin memakai waktu sekarang.</p>
                </div>

                <div>
                    <label for="status_arsip" class="block text-sm font-bold text-neutral mb-2">Status Berita</label>
                    <select id="status_arsip" name="status_arsip" required
                        class="w-full rounded-xl border border-tertiary bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:bg-white">
                        <option value="aktif" @selected(old('status_arsip', 'aktif') === 'aktif')>Aktif</option>
                        <option value="diarsipkan" @selected(old('status_arsip') === 'diarsipkan')>Diarsipkan</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-tertiary">
                <a href="{{ route('petugas.berita.index') }}" class="rounded-xl border border-tertiary bg-white px-6 py-3 text-sm font-bold text-neutral/70 hover:bg-inputBg">Batal</a>
                <button type="submit" class="rounded-xl bg-primary px-6 py-3 text-sm font-bold text-white hover:bg-primary/90">Simpan Berita</button>
            </div>
        </form>
    </div>
@endsection