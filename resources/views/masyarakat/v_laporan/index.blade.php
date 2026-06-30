@extends('masyarakat.v_layouts.app')

@section('title', 'SIMBO - Ajukan Laporan')
@section('page_title', 'Ajukan Laporan')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        [x-cloak] {
            display: none !important;
        }

        #map {
            min-height: 350px;
            z-index: 1;
        }

        #map-review {
            min-height: 180px;
            z-index: 1;
        }
    </style>
@endpush

@section('content')
    <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" x-data="laporanForm()"
        class="max-w-5xl mx-auto pb-10">
        @csrf

        <input type="hidden" name="latitude" x-model="lat">
        <input type="hidden" name="longitude" x-model="lng">
        <input type="hidden" name="jenis_laporan" x-model="jenis">

        {{-- Jika ada session success setelah submit --}}
        @if (session('success'))
            <div id="flash-success" data-message="{{ session('success') }}"></div>
        @endif

        {{-- ════════════════════════════════════
         STEPPER (Lebih Berwarna)
    ════════════════════════════════════ --}}
        <div class="mb-10 w-full max-w-2xl mx-auto mt-6">
            <div class="flex items-center justify-between relative">
                <div class="absolute top-5 left-0 w-full h-1 bg-gray-200 -z-10 rounded-full">
                    <div class="h-full bg-blue-500 transition-all duration-500 rounded-full"
                        :style="'width: ' + ((step - 1) * 50) + '%'"></div>
                </div>

                @foreach ([['Detail Masalah', 1], ['Atur Lokasi', 2], ['Tinjau & Kirim', 3]] as [$label, $num])
                    <div class="flex flex-col items-center bg-transparent px-2">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm mb-2 transition-all duration-300 border-2"
                            :class="{{ $num }} < step ?
                                'bg-emerald-500 border-emerald-500 text-white shadow-lg shadow-emerald-200' :
                                step === {{ $num }} ?
                                'bg-blue-600 border-blue-600 text-white shadow-lg shadow-blue-200 scale-110' :
                                'bg-white border-gray-300 text-gray-400'">
                            <template x-if="{{ $num }} < step"><i class="ph ph-check text-lg"></i></template>
                            <template x-if="{{ $num }} >= step"><span>{{ $num }}</span></template>
                        </div>
                        <span class="text-xs transition-colors"
                            :class="step === {{ $num }} ? 'font-bold text-blue-600' : (step > {{ $num }} ?
                                'font-bold text-emerald-600' : 'font-medium text-gray-400')">
                            {{ $label }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ════════════════════════════════════
         STEP 1 — Detail Laporan
    ════════════════════════════════════ --}}
        <div x-show="step === 1" x-transition.opacity.duration.300ms class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            <section class="lg:col-span-3 bg-white rounded-3xl p-7 border border-blue-100 shadow-sm shadow-blue-50 h-fit">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center"><i
                            class="ph ph-note-pencil text-xl"></i></div>
                    <h2 class="text-xl font-extrabold text-gray-800">Deskripsi Masalah</h2>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Judul Laporan</label>
                        <input type="text" name="judul" x-model="judul"
                            placeholder="Contoh : Jalan rusak di depan Taman Heulang"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 transition-all placeholder:text-gray-400 outline-none"
                            :class="errors.judul ? 'border-red-400 focus:ring-red-100' :
                                'focus:ring-blue-100 focus:border-blue-500'">
                        <span x-show="errors.judul" class="text-xs text-red-500 font-bold mt-1.5 block"
                            x-text="errors.judul"></span>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kategori Laporan</label>
                        <div class="relative">
                            <select name="kategori" x-model="kategori"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm appearance-none focus:bg-white focus:ring-2 transition-all text-gray-700 cursor-pointer outline-none"
                                :class="errors.kategori ? 'border-red-400 focus:ring-red-100' :
                                    'focus:ring-blue-100 focus:border-blue-500'">
                                <option value="">Pilih Kategori...</option>
                                @foreach ($kategoris as $kat)
                                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span x-show="errors.kategori" class="text-xs text-red-500 font-bold mt-1.5 block"
                            x-text="errors.kategori"></span>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Detail Laporan</label>
                        <textarea name="detail" x-model="detail" rows="5"
                            placeholder="Berikan detail spesifik tentang masalah tersebut..."
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 transition-all placeholder:text-gray-400 resize-none outline-none"
                            :class="errors.detail ? 'border-red-400 focus:ring-red-100' :
                                'focus:ring-blue-100 focus:border-blue-500'"></textarea>
                        <span x-show="errors.detail" class="text-xs text-red-500 font-bold mt-1.5 block"
                            x-text="errors.detail"></span>
                    </div>
                </div>
            </section>

            <div class="lg:col-span-2 flex flex-col gap-6">
                {{-- Upload Foto --}}
                <section class="bg-white rounded-3xl p-7 border border-indigo-100 shadow-sm shadow-indigo-50">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center"><i
                                    class="ph ph-camera text-lg"></i></div>
                            <h3 class="text-sm font-bold text-gray-800">Bukti Laporan <span class="text-red-500">*</span>
                            </h3>
                        </div>
                    </div>

                    <label for="foto_bukti"
                        class="border-2 border-dashed rounded-2xl flex flex-col items-center justify-center text-center cursor-pointer transition-all group relative overflow-hidden p-6"
                        :class="errors.foto ? 'border-red-400 bg-red-50' : imagePreview ? 'border-indigo-400 bg-indigo-50/50' :
                            'border-gray-300 bg-gray-50 hover:bg-indigo-50 hover:border-indigo-300'">

                        <div x-show="!imagePreview" class="flex flex-col items-center py-4">
                            <i
                                class="ph ph-image text-4xl text-gray-400 group-hover:text-indigo-500 transition-colors mb-3"></i>
                            <p class="text-sm font-bold text-gray-700 mb-1">Upload foto bukti</p>
                            <p class="text-[11px] font-medium text-gray-400">Wajib diisi · JPG, PNG · Maks 5MB</p>
                        </div>

                        <div x-show="imagePreview" x-cloak class="flex flex-col items-center w-full">
                            <img :src="imagePreview"
                                class="h-32 w-full object-cover rounded-xl shadow-sm border border-gray-200 mb-3">
                            <p class="text-xs font-bold text-indigo-600 truncate max-w-full px-2" x-text="fileName"></p>
                            <p
                                class="text-[11px] font-bold text-gray-400 mt-1.5 flex items-center gap-1 bg-white px-2 py-1 rounded-md shadow-sm border border-gray-100">
                                <i class="ph ph-arrows-clockwise"></i> Ganti foto
                            </p>
                        </div>

                        <input type="file" id="foto_bukti" name="foto_bukti" class="hidden"
                            accept="image/png, image/jpeg, image/jpg" @change="handleFileChange($event)">
                    </label>

                    <div x-show="errors.foto" x-cloak
                        class="mt-3 flex items-center gap-2 text-xs text-red-600 font-bold bg-red-50 border border-red-100 rounded-xl px-3 py-2.5">
                        <i class="ph ph-warning-circle text-lg shrink-0"></i> <span x-text="errors.foto"></span>
                    </div>
                </section>
            </div>
        </div>

        {{-- ════════════════════════════════════
         STEP 2 — Atur Lokasi (Dengan Search)
    ════════════════════════════════════ --}}
        <div x-show="step === 2" x-cloak x-transition.opacity.duration.300ms
            class="bg-white rounded-3xl p-7 border border-emerald-100 shadow-sm shadow-emerald-50">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center"><i
                        class="ph ph-map-pin-line text-xl"></i></div>
                <h2 class="text-xl font-extrabold text-gray-800">Detail Lokasi Kejadian</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-[350px_1fr] gap-8">
                <div class="space-y-5">
                    <div
                        class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-xs text-emerald-900 space-y-1.5 shadow-sm">
                        <p class="font-bold flex items-center gap-1.5 mb-2 border-b border-emerald-200/50 pb-2"><i
                                class="ph ph-crosshair text-emerald-600 text-base"></i> Titik Koordinat:</p>
                        <p class="flex justify-between"><span>Latitude:</span> <span class="font-mono font-bold"
                                x-text="lat"></span></p>
                        <p class="flex justify-between"><span>Longitude:</span> <span class="font-mono font-bold"
                                x-text="lng"></span></p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Patokan Tempat (Opsional)</label>
                        <input type="text" name="patokan" x-model="patokan"
                            placeholder="Contoh: Depan warung sate..."
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-emerald-100 focus:border-emerald-500 transition-all placeholder:text-gray-400">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                        <textarea name="alamat" rows="4" x-model="alamat" placeholder="Masukkan nama jalan, RT/RW, desa/kelurahan..."
                            class="w-full bg-gray-50 border rounded-xl px-4 py-3 text-sm focus:bg-white outline-none focus:ring-2 transition-all resize-none placeholder:text-gray-400"
                            :class="errors.alamat ? 'border-red-400 focus:ring-red-100' :
                                'border-gray-200 focus:ring-emerald-100 focus:border-emerald-500'"></textarea>
                        <span x-show="errors.alamat" class="text-xs text-red-500 font-bold mt-1.5 block"
                            x-text="errors.alamat"></span>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    {{-- Search Bar Peta --}}
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="ph ph-magnifying-glass text-gray-400"></i>
                            </div>
                            <input type="text" x-model="searchQuery" @keydown.enter.prevent="searchLocation()"
                                placeholder="Cari nama tempat / jalan di peta..."
                                class="w-full bg-white border border-gray-300 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        </div>
                        <button type="button" @click="searchLocation()" :disabled="isSearching"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 shadow-sm disabled:opacity-50">
                            <span x-show="!isSearching">Cari</span>
                            <i x-show="isSearching" class="ph ph-spinner animate-spin"></i>
                        </button>
                    </div>

                    <div id="map"
                        class="w-full bg-gray-100 rounded-2xl border-2 border-gray-200 shadow-inner flex-1 overflow-hidden">
                    </div>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════
         STEP 3 — Tinjau Laporan
    ════════════════════════════════════ --}}
        <div x-show="step === 3" x-cloak x-transition.opacity.duration.300ms
            class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-6">
            {{-- Kiri: Review data --}}
            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden h-fit">
                <div class="px-7 py-5 bg-gray-50/50 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center"><i
                            class="ph ph-clipboard-text"></i></div>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-800">Tinjau Laporan</h2>
                        <p class="text-[11px] font-medium text-gray-500">Periksa kembali sebelum mengirim.</p>
                    </div>
                </div>

                <div class="p-7 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Judul Laporan
                            </p>
                            <p class="text-sm font-bold text-gray-800 bg-gray-50 p-3 rounded-xl border border-gray-100"
                                x-text="judul"></p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Kategori</p>
                            <p class="text-sm font-bold text-blue-600 bg-blue-50 p-3 rounded-xl border border-blue-100 inline-block"
                                x-text="getNamaKategori()"></p>
                        </div>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Detail Masalah</p>
                        <p class="text-sm font-medium text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-100 leading-relaxed whitespace-pre-wrap"
                            x-text="detail"></p>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Dokumentasi Foto</p>
                        <img :src="imagePreview"
                            class="w-full md:w-2/3 h-56 object-cover rounded-2xl border-4 border-gray-50 shadow-sm">
                    </div>

                    <div class="border-t border-gray-100 pt-6">
                        <label
                            class="flex items-start gap-3 cursor-pointer group bg-amber-50/50 border border-amber-100 p-4 rounded-2xl">
                            <input type="checkbox" x-model="setuju"
                                class="mt-1 w-5 h-5 rounded border-gray-300 text-amber-500 focus:ring-amber-500 cursor-pointer shrink-0">
                            <span class="text-xs font-medium text-amber-900 leading-relaxed">
                                Saya menyatakan bahwa semua informasi beserta foto bukti yang saya lampirkan adalah benar
                                dan dapat dipertanggungjawabkan keasliannya.
                            </span>
                        </label>
                        <div x-show="errors.setuju" x-cloak
                            class="mt-2 text-xs text-red-500 font-bold px-2 flex items-center gap-1.5">
                            <i class="ph ph-warning-circle text-base"></i> <span x-text="errors.setuju"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kanan: Sidebar --}}
            <div class="space-y-5">
                <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="flex items-center gap-2 px-5 py-3 border-b border-gray-100 bg-gray-50/50">
                        <i class="ph ph-map-pin-area text-red-500 text-lg"></i>
                        <p class="text-sm font-bold text-gray-800">Lokasi Dilaporkan</p>
                    </div>
                    <div id="map-review" class="w-full"></div>
                    <div class="p-4 bg-white">
                        <p class="text-xs font-medium text-gray-700 leading-relaxed" x-text="alamat"></p>
                        <p x-show="patokan"
                            class="text-[11px] font-bold text-gray-400 mt-2 bg-gray-50 px-2 py-1 rounded-md inline-block"
                            x-text="'Patokan: ' + patokan"></p>
                    </div>
                </div>

                {{-- Informasi Penting --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
                            <i class="ph ph-star text-amber-600 text-lg"></i>
                        </div>
                        <p class="text-sm font-bold text-neutral">Informasi Penting</p>
                    </div>
                    <ul class="space-y-2.5">
                        <li class="flex items-start gap-2 text-xs text-gray-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0 mt-1.5"></span>
                            Laporan akan diproses dalam 1–3 hari kerja.
                        </li>
                        <li class="flex items-start gap-2 text-xs text-gray-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0 mt-1.5"></span>
                            Pastikan foto yang diunggah jelas dan asli.
                        </li>
                        <li class="flex items-start gap-2 text-xs text-gray-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0 mt-1.5"></span>
                            Update status akan dikirimkan via notifikasi.
                        </li>
                    </ul>
                </div>

                <button type="submit" @click="submitForm($event)"
                    class="w-full flex items-center justify-center gap-2 bg-blue-600 text-white font-bold text-sm px-6 py-4 rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 hover:-translate-y-0.5">
                    Kirim Laporan Sekarang
                    <i class="ph ph-paper-plane-right text-lg"></i>
                </button>
            </div>
        </div>

        {{-- ════════════════════════════════════
         NAVIGASI BAWAH
    ════════════════════════════════════ --}}
        <div class="mt-8 flex items-center justify-between border-t border-gray-200 pt-6">
            <button x-show="step > 1" @click="step--" type="button"
                class="bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-xl font-bold text-sm flex items-center gap-2 hover:bg-gray-50 transition-colors shadow-sm">
                <i class="ph ph-arrow-left"></i> Kembali
            </button>
            <div x-show="step === 1"></div>

            <button x-show="step === 1" @click="nextStep(1)" type="button"
                class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold text-sm flex items-center gap-2 hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200">
                Lanjutkan <i class="ph ph-arrow-right"></i>
            </button>

            <button x-show="step === 2" @click="nextStep(2)" type="button"
                class="bg-emerald-500 text-white px-8 py-3 rounded-xl font-bold text-sm flex items-center gap-2 hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-200">
                Tinjau Laporan <i class="ph ph-arrow-right"></i>
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Cek notifikasi sukses setelah halaman dimuat (dari Laravel Session)
        document.addEventListener('DOMContentLoaded', function() {
            const flash = document.getElementById('flash-success');
            if (flash) {
                Swal.fire({
                    title: 'Berhasil Terkirim!',
                    text: flash.dataset.message,
                    icon: 'success',
                    confirmButtonColor: '#2563eb', // blue-600
                    customClass: {
                        popup: 'rounded-3xl',
                        confirmButton: 'rounded-xl px-6 py-2.5 text-sm font-bold'
                    }
                });
            }
        });

        function laporanForm() {
            return {
                step: 1,
                judul: '',
                kategori: '',
                detail: '',
                alamat: '',
                patokan: '',
                jenis: 'Private',
                setuju: false,
                lat: -6.5971, // Default Kota Bogor
                lng: 106.7986,
                map: null,
                marker: null,
                mapReview: null,
                imagePreview: null,
                fileName: '',
                errors: {},

                searchQuery: '',
                isSearching: false,

                kategoris: @json($kategoris),

                getNamaKategori() {
                    const found = this.kategoris.find(k => k.id_kategori == this.kategori);
                    return found ? found.nama_kategori : '—';
                },

                handleFileChange(event) {
                    const file = event.target.files[0];
                    this.errors.foto = null;

                    if (!file) {
                        this.imagePreview = null;
                        this.fileName = '';
                        return;
                    }

                    if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
                        this.errors.foto = 'Format tidak didukung. Gunakan JPG atau PNG.';
                        event.target.value = '';
                        return;
                    }

                    if (file.size > 5 * 1024 * 1024) {
                        this.errors.foto = 'Ukuran foto melebihi batas (Maks 5MB).';
                        event.target.value = '';
                        return;
                    }

                    this.fileName = file.name;
                    this.imagePreview = URL.createObjectURL(file);
                },

                nextStep(current) {
                    this.errors = {};

                    if (current === 1) {
                        if (!this.judul.trim()) this.errors.judul = 'Judul laporan tidak boleh kosong.';
                        if (!this.kategori) this.errors.kategori = 'Kategori laporan harus dipilih.';
                        if (!this.detail.trim()) this.errors.detail = 'Detail deskripsi masalah wajib diisi.';
                        // Validasi Foto (WAJIB)
                        if (!this.imagePreview) this.errors.foto = 'Foto bukti laporan wajib dilampirkan.';

                        if (Object.keys(this.errors).length === 0) {
                            this.step = 2;
                            this.$nextTick(() => this.initLeafletMap());
                        }
                    } else if (current === 2) {
                        if (!this.alamat.trim()) this.errors.alamat = 'Alamat kejadian wajib diisi lengkap.';

                        if (Object.keys(this.errors).length === 0) {
                            this.step = 3;
                            this.$nextTick(() => this.initReviewMap());
                        }
                    }
                },

                // Fitur Search Lokasi dengan Geocoding (Nominatim API)
                async searchLocation() {
                    if (!this.searchQuery.trim()) return;

                    this.isSearching = true;
                    // Tambahkan "Bogor" agar pencarian lebih akurat ke wilayah yang dituju
                    const query = this.searchQuery + ", Bogor";

                    try {
                        const response = await fetch(
                            `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
                        const data = await response.json();

                        if (data && data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);

                            this.lat = lat.toFixed(6);
                            this.lng = lon.toFixed(6);

                            this.map.setView([lat, lon], 17);
                            this.marker.setLatLng([lat, lon]);

                            // Opsional: Otomatis mengisi alamat dari hasil pencarian
                            // this.alamat = data[0].display_name;
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lokasi tidak ditemukan',
                                text: 'Coba gunakan kata kunci yang lebih umum.',
                                confirmButtonColor: '#10b981' // emerald-500
                            });
                        }
                    } catch (e) {
                        console.error(e);
                    }
                    this.isSearching = false;
                },

                submitForm(event) {
                    event.preventDefault();
                    this.errors = {};

                    if (!this.setuju) {
                        this.errors.setuju = 'Anda harus menyetujui pernyataan untuk mengirim laporan.';
                        return;
                    }

                    // Sweet Alert Konfirmasi
                    Swal.fire({
                        title: 'Kirim Laporan?',
                        text: "Pastikan data dan lokasi yang Anda masukkan sudah benar dan sesuai fakta.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#2563eb', // blue-600
                        cancelButtonColor: '#9ca3af', // gray-400
                        confirmButtonText: 'Ya, Kirim Sekarang!',
                        cancelButtonText: 'Batal Periksa Lagi',
                        customClass: {
                            popup: 'rounded-3xl',
                            confirmButton: 'rounded-xl px-5 py-2.5 text-sm font-bold',
                            cancelButton: 'rounded-xl px-5 py-2.5 text-sm font-bold'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            event.target.closest('form').submit();
                        }
                    });
                },

                initLeafletMap() {
                    if (this.map) {
                        this.map.invalidateSize();
                        return;
                    }

                    this.map = L.map('map').setView([this.lat, this.lng], 14);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap'
                    }).addTo(this.map);

                    this.marker = L.marker([this.lat, this.lng], {
                        draggable: true
                    }).addTo(this.map);

                    this.marker.on('dragend', () => {
                        const pos = this.marker.getLatLng();
                        this.lat = pos.lat.toFixed(6);
                        this.lng = pos.lng.toFixed(6);
                    });

                    this.map.on('click', (e) => {
                        this.marker.setLatLng(e.latlng);
                        this.lat = e.latlng.lat.toFixed(6);
                        this.lng = e.latlng.lng.toFixed(6);
                    });
                },

                initReviewMap() {
                    if (this.mapReview) {
                        this.mapReview.invalidateSize();
                        return;
                    }

                    this.mapReview = L.map('map-review', {
                        zoomControl: false,
                        dragging: false,
                        scrollWheelZoom: false,
                        doubleClickZoom: false,
                        touchZoom: false,
                    }).setView([this.lat, this.lng], 15);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                    }).addTo(this.mapReview);

                    L.marker([this.lat, this.lng]).addTo(this.mapReview);
                }
            }
        }
    </script>
@endpush
