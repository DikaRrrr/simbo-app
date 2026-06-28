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
        <form action="{{ route('petugas.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="judul_berita" class="block text-sm font-bold text-neutral mb-2">Judul Berita</label>
                <input type="text" id="judul_berita" name="judul_berita" value="{{ old('judul_berita') }}" required maxlength="150"
                    placeholder="Contoh: Perbaikan Jalan di Wilayah Bogor Dimulai"
                    class="w-full rounded-xl border border-tertiary bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:bg-white">
            </div>

            {{-- Input Kategori Baru (Mengambil dari Kategori Laporan) --}}
            <div>
                <label for="id_kategori" class="block text-sm font-bold text-neutral mb-2">Kategori Berita</label>
                <div class="relative">
                    <select id="id_kategori" name="id_kategori" required
                        class="w-full rounded-xl border border-tertiary bg-inputBg px-4 py-3 text-sm outline-none focus:border-primary focus:bg-white appearance-none cursor-pointer">
                        <option value="" disabled selected>Pilih Kategori Berita...</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id_kategori }}" @selected(old('id_kategori') == $kategori->id_kategori)>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <i class="ph ph-caret-down"></i>
                    </div>
                </div>
            </div>

            {{-- Input Isi Berita Menggunakan CKEditor --}}
            <div>
                <label for="isi_berita" class="block text-sm font-bold text-neutral mb-2">Isi Berita</label>
                <div class="prose max-w-none">
                    <textarea id="isi_berita" name="isi_berita" rows="10" placeholder="Tulis isi berita atau pengumuman untuk masyarakat...">{{ old('isi_berita') }}</textarea>
                </div>
            </div>

            <div>
                <label for="gambar_berita" class="block text-sm font-bold text-neutral mb-2">Gambar Berita</label>
                <div class="rounded-xl border border-dashed border-tertiary bg-inputBg px-4 py-5">
                    <input type="file" id="gambar_berita" name="gambar_berita" accept="image/png,image/jpeg,image/jpg,image/webp"
                        class="block w-full text-sm text-neutral/70 file:mr-4 file:rounded-lg file:border-0 file:bg-primary file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:file:bg-primary/90">
                    <p class="text-xs text-neutral/50 mt-2">Format gambar: JPG, JPEG, PNG, atau WEBP. Ukuran maksimal 8 MB.</p>
                </div>
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

@push('scripts')
{{-- Load CDN CKEditor 5 Versi Klasik --}}
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@41.1.0/build/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        ClassicEditor
            .create(document.querySelector('#isi_berita'), {
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo' ],
                placeholder: 'Tulis isi berita atau pengumuman secara mendetail di sini...'
            })
            .then(editor => {
                // Mengatur tinggi minimal tampilan editor agar proporsional dengan form pembungkus
                editor.ui.view.editable.element.style.minHeight = "260px";
            })
            .catch(error => {
                console.error('Ada kendala saat memuat CKEditor:', error);
            });
    });
</script>

{{-- Kustomisasi CSS opsional agar CKEditor menyatu dengan tema Tailwind Tailwind --}}
<style>
    .ck-editor__editable_inline {
        border-radius: 0 0 12px 12px !important;
        background-color: #ffffff !important;
        font-size: 0.875rem;
    }
    .ck-toolbar {
        border-radius: 12px 12px 0 0 !important;
        background-color: #f9fafb !important;
        border-color: #e5e7eb !important;
    }
</style>
@endpush