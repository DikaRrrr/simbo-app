@extends('admin.v_layouts.app')

@section('title', 'Tambah Berita - Admin SIMBO')

    <main class="ml-[250px] w-[calc(100%-250px)] bg-dash-secondary min-h-screen font-worksans p-8 pt-24">

        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold font-montserrat text-neutral mb-1">Tambah Berita</h1>
                <p class="text-sm text-gray-500">Tulis dan publikasikan informasi terbaru untuk masyarakat.</p>
            </div>
            <a href="{{ route('admin.berita.index') }}"
                class="px-5 py-2.5 border border-gray-300 bg-white text-gray-700 text-sm font-bold rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
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

        <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm max-w-4xl">
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-neutral mb-2">Judul Berita</label>
                    <input type="text" name="judul_berita" value="{{ old('judul_berita') }}" required maxlength="150"
                        placeholder="Masukkan judul berita..."
                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm outline-none focus:border-primary focus:ring-1 focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral mb-2">Kategori Berita</label>
                    <select name="id_kategori" required
                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm outline-none focus:border-primary focus:ring-1 focus:bg-white transition-all">
                        <option value="" disabled selected>Pilih Kategori...</option>
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat->id_kategori }}" @selected(old('id_kategori') == $kat->id_kategori)>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral mb-2">Isi Berita</label>
                    <div class="prose max-w-none">
                        <textarea id="isi_berita" name="isi_berita">{{ old('isi_berita') }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-neutral mb-2">Gambar Berita</label>
                        <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-4 text-center">
                            <input type="file" name="gambar_berita" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-gray-200 file:px-4 file:py-2 file:text-sm file:font-bold hover:file:bg-gray-300 transition-colors">
                            <p class="text-[11px] text-gray-400 mt-2">Format: JPG, JPEG, PNG. Maksimal 8MB.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-neutral mb-2">Tanggal Publish</label>
                            <input type="datetime-local" name="tanggal_publish" value="{{ old('tanggal_publish') }}"
                                class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm outline-none focus:border-primary focus:ring-1 focus:bg-white transition-all">
                            <p class="text-[11px] text-gray-400 mt-1">Kosongkan jika ingin menggunakan waktu saat ini.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-neutral mb-2">Status Arsip</label>
                            <select name="status_arsip" required
                                class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm outline-none focus:border-primary focus:ring-1 focus:bg-white transition-all">
                                <option value="aktif" @selected(old('status_arsip') === 'aktif')>Aktif (Tampil Publik)</option>
                                <option value="diarsipkan" @selected(old('status_arsip') === 'diarsipkan')>Diarsipkan (Sembunyikan)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <button type="submit"
                        class="px-6 py-3 rounded-xl bg-primary text-white text-sm font-bold hover:bg-primary/90 shadow-sm transition-all">
                        Terbitkan Berita
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@41.1.0/build/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            ClassicEditor
                .create(document.querySelector('#isi_berita'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                        'blockQuote', '|', 'undo', 'redo'
                    ],
                    placeholder: 'Tuliskan detail berita di sini...'
                })
                .then(editor => {
                    editor.ui.view.editable.element.style.minHeight = "260px";
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
    <style>
        .ck-editor__editable_inline {
            background-color: #f9fafb !important;
            border-radius: 0 0 12px 12px !important;
        }

        .ck-toolbar {
            background-color: #f3f4f6 !important;
            border-radius: 12px 12px 0 0 !important;
            border-color: #e5e7eb !important;
        }
    </style>
