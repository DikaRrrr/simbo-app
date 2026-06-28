@extends('petugas.v_layouts.app')

@section('title', 'Edit Berita')
@section('page_title', 'Edit Berita')

@section('header_action')
    <a href="{{ route('petugas.berita.index') }}" class="rounded-xl border border-tertiary bg-white px-5 py-3 text-sm font-bold text-primary hover:bg-inputBg">
        Kembali
    </a>
@endsection

@section('content')
    <div class="max-w-4xl bg-white rounded-2xl border border-tertiary p-8 shadow-sm">
        <form action="{{ route('petugas.berita.update', $berita->id_berita) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="judul_berita" class="block text-sm font-bold text-neutral mb-2">Judul Berita</label>
                <input type="text" id="judul_berita" name="judul_berita" value="{{ old('judul_berita', $berita->judul_berita) }}" required maxlength="150"
                    class="w-full rounded-xl border border-tertiary bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:bg-white">
            </div>

            <div>
                <label for="isi_berita" class="block text-sm font-bold text-neutral mb-2">Isi Berita</label>
                <textarea id="isi_berita" name="isi_berita" rows="10" required
                    class="w-full rounded-xl border border-tertiary bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:bg-white resize-none">{{ old('isi_berita', $berita->isi_berita) }}</textarea>
            </div>

            <div>
                <label for="gambar_berita" class="block text-sm font-bold text-neutral mb-2">Gambar Berita</label>
                <div class="rounded-xl border border-dashed border-tertiary bg-inputBg px-4 py-5">
                    @if ($berita->gambar_berita)
                        <div class="mb-4 flex items-center gap-4">
                            <img src="{{ $berita->gambar_url }}" alt="Gambar {{ $berita->judul_berita }}"
                                class="h-24 w-36 rounded-xl object-cover border border-tertiary bg-white">
                            <p class="text-xs text-neutral/60">Gambar saat ini. Pilih file baru bila ingin menggantinya.</p>
                        </div>
                    @else
                        <p class="text-xs text-neutral/50 mb-3">Belum ada gambar untuk berita ini.</p>
                    @endif
                    <input type="file" id="gambar_berita" name="gambar_berita" accept="image/png,image/jpeg,image/jpg,image/webp"
                        class="block w-full text-sm text-neutral/70 file:mr-4 file:rounded-lg file:border-0 file:bg-primary file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:file:bg-primary/90">
                    <p class="text-xs text-neutral/50 mt-2">Format gambar: JPG, JPEG, PNG, atau WEBP. Ukuran maksimal 8 MB.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="tanggal_publish" class="block text-sm font-bold text-neutral mb-2">Tanggal Publish</label>
                    <input type="datetime-local" id="tanggal_publish" name="tanggal_publish"
                        value="{{ old('tanggal_publish', optional($berita->tanggal_publish)->format('Y-m-d\TH:i')) }}"
                        class="w-full rounded-xl border border-tertiary bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:bg-white">
                </div>

                <div>
                    <label for="status_arsip" class="block text-sm font-bold text-neutral mb-2">Status Berita</label>
                    <select id="status_arsip" name="status_arsip" required
                        class="w-full rounded-xl border border-tertiary bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:bg-white">
                        <option value="aktif" @selected(old('status_arsip', $berita->status_arsip) === 'aktif')>Aktif</option>
                        <option value="diarsipkan" @selected(old('status_arsip', $berita->status_arsip) === 'diarsipkan')>Diarsipkan</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-tertiary">
                <a href="{{ route('petugas.berita.index') }}" class="rounded-xl border border-tertiary bg-white px-6 py-3 text-sm font-bold text-neutral/70 hover:bg-inputBg">Batal</a>
                <button type="submit" class="rounded-xl bg-primary px-6 py-3 text-sm font-bold text-white hover:bg-primary/90">Update Berita</button>
            </div>
        </form>
    </div>
@endsection