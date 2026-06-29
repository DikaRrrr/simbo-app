@extends('masyarakat.v_layouts.app')

@section('title', 'SIMBO - Ajukan Laporan')
@section('page_title', 'Ajukan Laporan')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <style>
        [x-cloak] {
            display: none !important;
        }

        #map {
            min-height: 280px;
            z-index: 1;
        }

        #map-review {
            min-height: 160px;
            z-index: 1;
        }
    </style>
@endpush

@section('content')
    <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" x-data="laporanForm()"
        class="max-w-5xl mx-auto">
        @csrf

        <input type="hidden" name="latitude" x-model="lat">
        <input type="hidden" name="longitude" x-model="lng">
        <input type="hidden" name="jenis_laporan" x-model="jenis">

        {{-- ════════════════════════════════════
         STEPPER
    ════════════════════════════════════ --}}
        <div class="mb-10 w-full max-w-2xl mx-auto">
            <div class="flex items-center justify-between relative">

                <div class="absolute top-5 left-0 w-full h-0.5 bg-gray-200 -z-10">
                    <div class="h-full bg-neutral transition-all duration-500" :style="'width: ' + ((step - 1) * 50) + '%'">
                    </div>
                </div>

                @foreach ([['Detail Laporan', 1], ['Atur Lokasi', 2], ['Tinjau Laporan', 3]] as [$label, $num])
                    <div class="flex flex-col items-center bg-white px-2">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm mb-2 transition-all duration-300 border-2"
                            :class="{{ $num }} < step ?
                                'bg-neutral border-neutral text-white' :
                                step === {{ $num }} ?
                                'bg-neutral border-neutral text-white shadow-md' :
                                'bg-white border-gray-300 text-gray-400'">
                            <template x-if="{{ $num }} < step"><i class="ph ph-check text-base"></i></template>
                            <template x-if="{{ $num }} >= step"><span>{{ $num }}</span></template>
                        </div>
                        <span class="text-xs transition-colors"
                            :class="step >= {{ $num }} ? 'font-bold text-neutral' : 'font-medium text-gray-400'">
                            {{ $label }}
                        </span>
                    </div>
                @endforeach

            </div>
        </div>


        {{-- ════════════════════════════════════
         STEP 1 — Detail Laporan
    ════════════════════════════════════ --}}
        <div x-show="step === 1" x-transition.opacity.duration.300ms class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            <section class="lg:col-span-3 bg-tertiary/30 rounded-2xl p-6 border border-gray-200 backdrop-blur-sm h-fit">
                <h2 class="text-xl font-bold mb-6 text-neutral">Deskripsi Masalah</h2>
                <div class="space-y-5">

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Laporan</label>
                        <input type="text" name="judul" x-model="judul"
                            placeholder="Contoh : Jalan rusak di depan Taman Heulang"
                            class="w-full bg-white border rounded-lg px-4 py-3 text-sm focus:ring-2 transition-all placeholder:text-gray-400"
                            :class="errors.judul ? 'border-red-400 focus:ring-red-100' :
                                'border-gray-300 focus:ring-primary/20 focus:border-primary'">
                        <span x-show="errors.judul" class="text-xs text-red-600 font-medium mt-1 block"
                            x-text="errors.judul"></span>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori Laporan</label>
                        <div class="relative">
                            <select name="kategori" x-model="kategori"
                                class="w-full bg-white border rounded-lg px-4 py-3 text-sm appearance-none focus:ring-2 transition-all text-gray-700 cursor-pointer"
                                :class="errors.kategori ? 'border-red-400 focus:ring-red-100' :
                                    'border-gray-300 focus:ring-primary/20 focus:border-primary'">
                                <option value="">Pilih Kategori...</option>
                                @foreach ($kategoris as $kat)
                                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <i class="ph ph-caret-down"></i>
                            </div>
                        </div>
                        <span x-show="errors.kategori" class="text-xs text-red-600 font-medium mt-1 block"
                            x-text="errors.kategori"></span>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Detail Laporan</label>
                        <textarea name="detail" x-model="detail" rows="6"
                            placeholder="Mohon berikan detail spesifik tentang masalah tersebut agar petugas dapat merespons secara efektif..."
                            class="w-full bg-white border rounded-lg px-4 py-3 text-sm focus:ring-2 transition-all placeholder:text-gray-400 resize-none"
                            :class="errors.detail ? 'border-red-400 focus:ring-red-100' :
                                'border-gray-300 focus:ring-primary/20 focus:border-primary'"></textarea>
                        <span x-show="errors.detail" class="text-xs text-red-600 font-medium mt-1 block"
                            x-text="errors.detail"></span>
                    </div>

                </div>
            </section>

            <div class="lg:col-span-2 flex flex-col gap-6">

                {{-- Upload Foto --}}
                <section class="bg-tertiary/30 rounded-2xl p-6 border border-gray-200 backdrop-blur-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-neutral">Bukti Laporan</h3>
                        <i class="ph ph-camera text-gray-500"></i>
                    </div>

                    <label for="foto_bukti"
                        class="border-2 border-dashed rounded-xl flex flex-col items-center justify-center text-center cursor-pointer transition-all group relative overflow-hidden p-6"
                        :class="errors.foto ?
                            'border-red-400 bg-red-50' :
                            imagePreview ?
                            'border-primary bg-primary/5' :
                            'border-gray-300 bg-white hover:bg-gray-50 hover:border-primary/50'">

                        <div x-show="!imagePreview" class="flex flex-col items-center py-4">
                            <i
                                class="ph ph-cloud-arrow-up text-4xl text-gray-400 group-hover:text-primary transition-colors mb-3"></i>
                            <p class="text-sm font-medium text-gray-700 mb-1">Klik atau tarik foto ke sini</p>
                            <p class="text-xs text-gray-400">JPG, PNG · Maks 5MB</p>
                        </div>

                        <div x-show="imagePreview" x-cloak class="flex flex-col items-center w-full">
                            <img :src="imagePreview"
                                class="h-28 w-full object-cover rounded-lg shadow-sm border border-gray-200 mb-3">
                            <p class="text-xs font-bold text-primary truncate max-w-full px-2" x-text="fileName"></p>
                            <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1">
                                <i class="ph ph-arrows-clockwise"></i> Klik untuk mengganti
                            </p>
                        </div>

                        <input type="file" id="foto_bukti" name="foto_bukti" class="hidden"
                            accept="image/png, image/jpeg, image/jpg" @change="handleFileChange($event)">
                    </label>

                    {{-- Error foto --}}
                    <div x-show="errors.foto" x-cloak
                        class="mt-2 flex items-center gap-1.5 text-xs text-red-600 font-semibold bg-red-50 border border-red-200 rounded-lg px-3 py-2">
                        <i class="ph ph-warning-circle shrink-0"></i>
                        <span x-text="errors.foto"></span>
                    </div>

                    <p class="mt-3 text-xs text-gray-400 flex items-start gap-1.5">
                        <i class="ph ph-info shrink-0 mt-0.5"></i>
                        Foto yang jelas membantu petugas menangani laporan lebih cepat.
                    </p>
                </section>

                {{-- Info --}}
                <section class="bg-tertiary/30 rounded-2xl p-6 border border-gray-200 backdrop-blur-sm">
                    <div class="space-y-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <div
                                    class="w-5 h-5 rounded-full bg-neutral text-white flex items-center justify-center shrink-0">
                                    <i class="ph ph-check text-xs"></i>
                                </div>
                                <h4 class="text-sm font-bold text-neutral">Laporan Rahasia</h4>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed pl-7">Informasi pribadi Anda dijaga
                                kerahasiaannya.</p>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <div
                                    class="w-5 h-5 rounded-full bg-neutral text-white flex items-center justify-center shrink-0">
                                    <i class="ph ph-check text-xs"></i>
                                </div>
                                <h4 class="text-sm font-bold text-neutral">Tindak Lanjut Laporan</h4>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed pl-7">Hanya laporan permasalahan di <strong
                                    class="text-neutral">KOTA BOGOR</strong> yang ditindak lanjuti.</p>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <i class="ph ph-map-pin text-lg text-neutral"></i>
                                <h4 class="text-sm font-bold text-neutral">Lokasi Laporan</h4>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed pl-7">Atur lokasi laporan berdasarkan tempat
                                kejadian di langkah berikutnya.</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>


        {{-- ════════════════════════════════════
         STEP 2 — Atur Lokasi
    ════════════════════════════════════ --}}
        <div x-show="step === 2" x-cloak x-transition.opacity.duration.300ms
            class="bg-tertiary/30 rounded-2xl p-6 border border-gray-200 backdrop-blur-sm">
            <h2 class="text-xl font-bold mb-6 text-neutral">Detail Lokasi Kejadian</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                        <textarea name="alamat" rows="4" x-model="alamat" placeholder="Masukkan nama jalan, RT/RW, desa/kelurahan..."
                            class="w-full bg-white border rounded-lg px-4 py-3 text-sm focus:ring-2 transition-all resize-none placeholder:text-gray-400"
                            :class="errors.alamat ? 'border-red-400 focus:ring-red-100' :
                                'border-gray-300 focus:ring-primary/20 focus:border-primary'"></textarea>
                        <span x-show="errors.alamat" class="text-xs text-red-600 font-medium mt-1 block"
                            x-text="errors.alamat"></span>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Patokan (Opsional)</label>
                        <input type="text" name="patokan" x-model="patokan"
                            placeholder="Contoh: Depan warung sate, samping gapura..."
                            class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-gray-400">
                    </div>
                    <div class="p-3 bg-white border border-gray-200 rounded-xl text-xs text-gray-600 space-y-1">
                        <p class="font-bold text-gray-700 flex items-center gap-1.5">
                            <i class="ph ph-crosshair text-primary"></i> Koordinat Peta:
                        </p>
                        <p>Latitude: <span class="font-mono font-bold text-neutral" x-text="lat"></span></p>
                        <p>Longitude: <span class="font-mono font-bold text-neutral" x-text="lng"></span></p>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="block text-sm font-semibold text-gray-700">Geser pin pada peta untuk akurasi
                        posisi:</label>
                    <div id="map" class="w-full bg-gray-100 rounded-xl border border-gray-300 shadow-inner flex-1">
                    </div>
                </div>
            </div>
        </div>


        {{-- ════════════════════════════════════
         STEP 3 — Tinjau Laporan
    ════════════════════════════════════ --}}
        <div x-show="step === 3" x-cloak x-transition.opacity.duration.300ms
            class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-5">

            {{-- ── Kiri: Review data ──────────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-xl font-extrabold text-neutral">Tinjau Laporan</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Periksa kembali semua data sebelum dikirim.</p>
                </div>

                <div class="p-6 space-y-5">

                    {{-- Judul & Kategori --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Judul Laporan</p>
                            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-neutral min-h-[44px]"
                                x-text="judul || '—'"></div>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kategori Laporan</p>
                            <div
                                class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-neutral flex items-center justify-between min-h-[44px]">
                                <span x-text="getNamaKategori()"></span>
                                <i class="ph ph-caret-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Detail --}}
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Detail Laporan</p>
                        <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 leading-relaxed min-h-[100px]"
                            x-text="detail || '—'"></div>
                    </div>

                    {{-- Foto --}}
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Dokumentasi Laporan</p>
                        <div class="bg-gray-50 border border-gray-200 rounded-xl overflow-hidden">
                            <template x-if="imagePreview">
                                <img :src="imagePreview" class="w-full h-52 object-cover">
                            </template>
                            <template x-if="!imagePreview">
                                <div class="h-36 flex flex-col items-center justify-center text-gray-300">
                                    <i class="ph ph-image text-4xl mb-2"></i>
                                    <p class="text-xs font-medium">Tidak ada foto dilampirkan</p>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Visibilitas Laporan --}}
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Visibilitas Laporan</p>
                        <div class="grid grid-cols-2 gap-3">

                            <label class="cursor-pointer">
                                <input type="radio" x-model="jenis" value="Private" class="sr-only peer">
                                <div
                                    class="flex items-start gap-3 p-4 rounded-xl border-2 transition-all cursor-pointer
                                peer-checked:border-neutral peer-checked:bg-neutral/5
                                border-gray-200 bg-white hover:border-gray-300">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 transition-colors"
                                        :class="jenis === 'Private' ? 'bg-neutral' : 'bg-gray-100'">
                                        <i class="ph ph-lock text-sm"
                                            :class="jenis === 'Private' ? 'text-white' : 'text-gray-500'"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-neutral">Private</p>
                                        <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">Hanya terlihat oleh Anda
                                            dan petugas.</p>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" x-model="jenis" value="Publik" class="sr-only peer">
                                <div
                                    class="flex items-start gap-3 p-4 rounded-xl border-2 transition-all cursor-pointer
                                peer-checked:border-primary peer-checked:bg-primary/5
                                border-gray-200 bg-white hover:border-gray-300">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 transition-colors"
                                        :class="jenis === 'Publik' ? 'bg-primary' : 'bg-gray-100'">
                                        <i class="ph ph-globe text-sm"
                                            :class="jenis === 'Publik' ? 'text-white' : 'text-gray-500'"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-neutral">Publik</p>
                                        <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">Terlihat oleh semua
                                            pengguna SIMBO.</p>
                                    </div>
                                </div>
                            </label>

                        </div>
                    </div>

                    {{-- Checkbox Pernyataan --}}
                    <div class="border-t border-gray-100 pt-5">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="setuju"
                                class="mt-0.5 w-4 h-4 rounded border-gray-300 text-neutral focus:ring-neutral cursor-pointer shrink-0">
                            <span
                                class="text-xs text-gray-600 leading-relaxed group-hover:text-gray-800 transition-colors">
                                Saya menyatakan bahwa semua informasi yang saya berikan adalah benar dan dapat
                                dipertanggungjawabkan sesuai dengan ketentuan hukum yang berlaku di wilayah Kota Bogor.
                            </span>
                        </label>
                        <div x-show="errors.setuju" x-cloak
                            class="mt-2 flex items-center gap-1.5 text-xs text-red-600 font-semibold">
                            <i class="ph ph-warning-circle"></i>
                            <span x-text="errors.setuju"></span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ── Kanan: Sidebar ──────────────────────── --}}
            <div class="space-y-4">

                {{-- Lokasi Kejadian --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="flex items-center gap-2 px-4 py-3 border-b border-gray-100">
                        <i class="ph ph-map-pin-area text-primary text-lg"></i>
                        <p class="text-sm font-bold text-neutral">Lokasi Kejadian</p>
                    </div>
                    <div id="map-review" class="w-full bg-gray-100"></div>
                    <div class="px-4 py-3 bg-gray-50">
                        <p class="text-xs text-gray-600 leading-relaxed" x-text="alamat || 'Lokasi belum diisi'"></p>
                        <p x-show="patokan" class="text-xs text-gray-400 mt-1 italic" x-text="'Patokan: ' + patokan"></p>
                    </div>
                </div>

                {{-- Terverifikasi --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm px-4 py-3 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center shrink-0">
                        <i class="ph ph-seal-check text-green-600 text-lg"></i>
                    </div>
                    <p class="text-sm font-bold text-neutral">Laporan Terverifikasi</p>
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

                {{-- Branding + Kirim --}}
                <div class="bg-neutral rounded-2xl p-4 flex items-center justify-between gap-3">
                    <span class="text-white font-extrabold text-lg tracking-widest shrink-0">SIMBO</span>
                    <button type="submit" @click="submitForm($event)"
                        class="flex-1 flex items-center justify-center gap-2 bg-white text-neutral font-bold text-sm px-4 py-2.5 rounded-xl hover:bg-gray-100 transition-all shadow-sm">
                        Kirim Laporan
                        <i class="ph ph-arrow-right"></i>
                    </button>
                </div>

            </div>
        </div>


        {{-- ════════════════════════════════════
         NAVIGASI BAWAH
    ════════════════════════════════════ --}}
        <div class="mt-8 flex items-center justify-between">
            <button x-show="step > 1" @click="step--" type="button"
                class="bg-white border border-gray-300 text-gray-700 px-6 py-2.5 rounded-xl font-semibold text-sm flex items-center gap-2 hover:bg-gray-50 transition-colors shadow-sm">
                <i class="ph ph-arrow-left"></i> Kembali
            </button>
            <div x-show="step === 1"></div>

            <button x-show="step === 1" @click="nextStep(1)" type="button"
                class="bg-neutral text-white px-8 py-2.5 rounded-xl font-semibold text-sm flex items-center gap-2 hover:bg-gray-800 transition-colors shadow-md">
                Lanjutkan <i class="ph ph-arrow-right"></i>
            </button>

            <button x-show="step === 2" @click="nextStep(2)" type="button"
                class="bg-neutral text-white px-8 py-2.5 rounded-xl font-semibold text-sm flex items-center gap-2 hover:bg-gray-800 transition-colors shadow-md">
                Lanjutkan <i class="ph ph-arrow-right"></i>
            </button>
        </div>

    </form>
@endsection


@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
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
                lat: -6.5971,
                lng: 106.7986,
                map: null,
                marker: null,
                mapReview: null,
                imagePreview: null,
                fileName: '',
                errors: {},

                // Semua kategori untuk label di step 3
                kategoris: @json($kategoris),

                getNamaKategori() {
                    const found = this.kategoris.find(k => k.id_kategori == this.kategori);
                    return found ? found.nama_kategori : '—';
                },

                // ── Validasi foto ──────────────────────────────────────────
                handleFileChange(event) {
                    const file = event.target.files[0];
                    this.errors.foto = null;
                    this.imagePreview = null;
                    this.fileName = '';

                    if (!file) return;

                    // Cek tipe file
                    if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
                        this.errors.foto = 'Format tidak didukung. Gunakan JPG atau PNG.';
                        event.target.value = '';
                        return;
                    }

                    // Cek ukuran (5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        this.errors.foto = 'Ukuran foto melebihi batas maksimal 5MB.';
                        event.target.value = '';
                        return;
                    }

                    this.fileName = file.name;
                    this.imagePreview = URL.createObjectURL(file);
                },

                // ── Navigasi step ──────────────────────────────────────────
                nextStep(current) {
                    this.errors = {};

                    if (current === 1) {
                        if (!this.judul.trim()) this.errors.judul = 'Judul laporan tidak boleh kosong.';
                        if (!this.kategori) this.errors.kategori = 'Kategori laporan harus dipilih.';
                        if (!this.detail.trim()) this.errors.detail = 'Detail deskripsi masalah wajib diisi.';

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

                // ── Validasi checkbox sebelum submit ───────────────────────
                submitForm(event) {
                    this.errors = {};
                    if (!this.setuju) {
                        event.preventDefault();
                        this.errors.setuju = 'Anda harus menyetujui pernyataan ini untuk mengirim laporan.';
                    }
                },

                // ── Peta Leaflet Step 2 (interaktif) ──────────────────────
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

                // ── Peta Review Step 3 (read-only) ────────────────────────
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
                    }).setView([this.lat, this.lng], 14);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap'
                    }).addTo(this.mapReview);

                    L.marker([this.lat, this.lng]).addTo(this.mapReview);
                },
            }
        }
    </script>
@endpush
