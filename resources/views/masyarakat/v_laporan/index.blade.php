@extends('masyarakat.v_layouts.app')

@section('title', 'SIMBO - Ajukan Laporan')
@section('page_title', 'Ajukan Laporan')

{{-- Push Leaflet CSS ke Layout Utama --}}
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        [x-cloak] {
            display: none !important;
        }

        #map {
            min-height: 280px;
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

        <div class="mb-10 w-full max-w-2xl mx-auto">
            <div class="flex items-center justify-between relative">
                <div class="absolute top-1/2 left-0 w-full h-0.5 bg-gray-300 -z-10 -translate-y-1/2 rounded">
                    <div class="h-full bg-primary transition-all duration-300" :style="'width: ' + ((step - 1) * 50) + '%'">
                    </div>
                </div>

                <div class="flex flex-col items-center bg-white px-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg mb-2 transition-colors duration-300"
                        :class="step >= 1 ? 'bg-neutral text-white shadow-md' : 'bg-gray-300 text-gray-600'">1</div>
                    <span class="text-xs font-bold" :class="step >= 1 ? 'text-neutral' : 'text-gray-500'">Detail
                        Laporan</span>
                </div>

                <div class="flex flex-col items-center bg-white px-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg mb-2 transition-colors duration-300"
                        :class="step >= 2 ? 'bg-neutral text-white shadow-md' : 'bg-gray-300 text-gray-600'">2</div>
                    <span class="text-xs font-medium" :class="step >= 2 ? 'text-neutral font-bold' : 'text-gray-500'">Atur
                        Lokasi</span>
                </div>

                <div class="flex flex-col items-center bg-white px-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg mb-2 transition-colors duration-300"
                        :class="step >= 3 ? 'bg-neutral text-white shadow-md' : 'bg-gray-300 text-gray-600'">3</div>
                    <span class="text-xs font-medium" :class="step >= 3 ? 'text-neutral font-bold' : 'text-gray-500'">Tinjau
                        Laporan</span>
                </div>
            </div>
        </div>
        <div x-show="step === 1" x-transition.opacity.duration.300ms class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <section class="lg:col-span-3 bg-tertiary/30 rounded-2xl p-6 border border-gray-200 backdrop-blur-sm h-fit">
                <h2 class="text-xl font-bold mb-6 text-neutral">Deskripsi Masalah</h2>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="judul">Judul Laporan</label>
                        <input
                            class="w-full bg-white border rounded-lg px-4 py-3 text-sm focus:ring-2 transition-all placeholder:text-gray-400"
                            :class="errors.judul ? 'border-red-500 focus:ring-red-200 focus:border-red-500' :
                                'border-gray-300 focus:ring-primary/20 focus:border-primary'"
                            id="judul" placeholder="Contoh : Jalan rusak di depan Taman Heulang" type="text"
                            name="judul" x-model="judul">
                        <span x-show="errors.judul" class="text-xs text-red-600 font-medium mt-1 block"
                            x-text="errors.judul"></span>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="kategori">Kategori
                            Laporan</label>
                        <div class="relative">
                            <select
                                class="w-full bg-white border rounded-lg px-4 py-3 text-sm appearance-none focus:ring-2 transition-all text-gray-700 cursor-pointer"
                                :class="errors.kategori ? 'border-red-500 focus:ring-red-200 focus:border-red-500' :
                                    'border-gray-300 focus:ring-primary/20 focus:border-primary'"
                                id="kategori" name="kategori" x-model="kategori">
                                <option value="">Pilih Kategori...</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
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
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="detail">Detail Laporan</label>
                        <textarea
                            class="w-full bg-white border rounded-lg px-4 py-3 text-sm focus:ring-2 transition-all placeholder:text-gray-400 resize-none"
                            :class="errors.detail ? 'border-red-500 focus:ring-red-200 focus:border-red-500' :
                                'border-gray-300 focus:ring-primary/20 focus:border-primary'"
                            id="detail" name="detail" placeholder="Mohon berikan detail spesifik tentang masalah tersebut..." rows="6"
                            x-model="detail"></textarea>
                        <span x-show="errors.detail" class="text-xs text-red-600 font-medium mt-1 block"
                            x-text="errors.detail"></span>
                    </div>
                </div>
            </section>

            <div class="lg:col-span-2 flex flex-col gap-6">
                <section class="bg-tertiary/30 rounded-2xl p-6 border border-gray-200 backdrop-blur-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-bold text-neutral">Bukti Laporan</h3>
                        <i class="ph ph-camera text-gray-500"></i>
                    </div>
                    <label for="foto_bukti"
                        class="border-2 border-dashed border-gray-400 bg-white rounded-xl p-8 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-gray-50 transition-colors group relative overflow-hidden">

                        <div x-show="!imagePreview" class="flex flex-col items-center">
                            <i
                                class="ph ph-cloud-arrow-up text-4xl text-gray-400 group-hover:text-primary transition-colors mb-3"></i>
                            <p class="text-sm font-medium text-gray-700 mb-1">Klik atau tarik foto ke sini</p>
                            <p class="text-xs text-gray-500">Mendukung JPG, PNG (Maks 5MB)</p>
                        </div>

                        <div x-show="imagePreview" x-cloak class="flex flex-col items-center w-full">
                            <img :src="imagePreview"
                                class="h-32 object-contain mb-3 rounded-lg shadow-sm border border-gray-200">
                            <p class="text-sm font-bold text-primary truncate max-w-full px-4" x-text="fileName"></p>
                            <p class="text-xs text-gray-500 mt-1"><i class="ph ph-arrows-clockwise inline"></i> Klik untuk
                                mengganti foto</p>
                        </div>

                        <input type="file" id="foto_bukti" name="foto_bukti" class="hidden"
                            accept="image/png, image/jpeg" @change="handleFileChange($event)">
                    </label>
                </section>

                <section class="bg-tertiary/30 rounded-2xl p-6 border border-gray-200 backdrop-blur-sm">
                    <div class="space-y-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-5 h-5 rounded-full bg-neutral text-white flex items-center justify-center">
                                    <i class="ph ph-check text-xs"></i>
                                </div>
                                <h4 class="text-sm font-bold text-neutral">Laporan Rahasia</h4>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed pl-7">Informasi pribadi Anda akan dijaga
                                kerahasiaannya. Laporanmu tidak terlihat oleh siapapun kecuali petugas.</p>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-5 h-5 rounded-full bg-neutral text-white flex items-center justify-center">
                                    <i class="ph ph-check text-xs"></i>
                                </div>
                                <h4 class="text-sm font-bold text-neutral">Tindak Lanjut Laporan</h4>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed pl-7">Hanya laporan terkait permasalahan di
                                <strong class="text-neutral">KOTA BOGOR</strong> saja yang akan di tindak lanjuti.
                            </p>
                        </div>
                        <div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 mb-1">
                                    <i class="ph ph-map-pin text-lg text-neutral"></i>
                                    <h4 class="text-sm font-bold text-neutral">Lokasi Laporan</h4>
                                </div>
                                <i class="ph ph-dots-three text-gray-400"></i>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed pl-7">Atur lokasi laporan berdasarkan lokasi
                                pengambilan foto.</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div x-show="step === 2" x-cloak x-transition.opacity.duration.300ms
            class="bg-tertiary/30 rounded-2xl p-6 border border-gray-200 backdrop-blur-sm">
            <h2 class="text-xl font-bold mb-6 text-neutral">Detail Lokasi Kejadian</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                        <textarea name="alamat" rows="4"
                            class="w-full bg-white border rounded-lg px-4 py-3 text-sm focus:ring-2 transition-all resize-none placeholder:text-gray-400"
                            :class="errors.alamat ? 'border-red-500 focus:ring-red-200 focus:border-red-500' :
                                'border-gray-300 focus:ring-primary/20 focus:border-primary'"
                            placeholder="Masukkan nama jalan, RT/RW, desa/kelurahan..." x-model="alamat"></textarea>
                        <span x-show="errors.alamat" class="text-xs text-red-600 font-medium mt-1 block"
                            x-text="errors.alamat"></span>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Patokan (Opsional)</label>
                        <input type="text" name="patokan"
                            class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-gray-400"
                            placeholder="Contoh: Depan warung sate, samping gapura..." x-model="patokan">
                    </div>
                    <div class="p-3 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-600 space-y-1">
                        <p class="font-bold text-gray-700">Koordinat Peta:</p>
                        <p>Latitude: <span class="font-mono" x-text="lat"></span></p>
                        <p>Longitude: <span class="font-mono" x-text="lng"></span></p>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="block text-sm font-semibold text-gray-700">Geser pin pada peta untuk akurasi
                        posisi:</label>
                    <div id="map" class="w-full bg-gray-100 rounded-xl border border-gray-300 shadow-inner"></div>
                </div>
            </div>
        </div>

        <div x-show="step === 3" x-cloak x-transition.opacity.duration.300ms
            class="bg-white rounded-2xl p-10 border border-gray-200 text-center shadow-sm">
            <div class="w-20 h-20 rounded-full bg-green-100 text-green-600 flex items-center justify-center mx-auto mb-4">
                <i class="ph ph-check-circle text-4xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-neutral mb-2">Konfirmasi Pengiriman</h2>
            <p class="text-gray-500 text-sm max-w-md mx-auto mb-6">Pastikan semua data yang Anda isi sudah benar. Laporan
                tidak dapat diubah setelah dikirim ke sistem.</p>
        </div>

        <div class="mt-8 flex justify-between items-center">
            <button x-show="step > 1" @click="step--" type="button"
                class="bg-white border border-gray-300 text-gray-700 px-6 py-2.5 rounded-lg font-semibold text-sm flex items-center gap-2 hover:bg-gray-50 transition-colors shadow-sm">
                <i class="ph ph-arrow-left"></i> Kembali
            </button>

            <div x-show="step === 1"></div>

            <button x-show="step === 1" @click="nextStep(1)" type="button"
                class="bg-neutral text-white px-8 py-2.5 rounded-lg font-semibold text-sm flex items-center gap-2 hover:bg-gray-800 transition-colors shadow-md">
                Lanjutkan <i class="ph ph-arrow-right"></i>
            </button>

            <button x-show="step === 2" @click="nextStep(2)" type="button"
                class="bg-neutral text-white px-8 py-2.5 rounded-lg font-semibold text-sm flex items-center gap-2 hover:bg-gray-800 transition-colors shadow-md">
                Lanjutkan <i class="ph ph-arrow-right"></i>
            </button>

            <button x-show="step === 3" type="submit"
                class="bg-primary text-white px-8 py-2.5 rounded-lg font-semibold text-sm flex items-center gap-2 hover:bg-primary/90 transition-colors shadow-md">
                Kirim Laporan <i class="ph ph-paper-plane-tilt"></i>
            </button>
        </div>
    </form>
@endsection

{{-- Push Leaflet JS & Form Logic ke Layout Utama --}}
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
                lat: -6.5971, // Pusat Default Kota Bogor
                lng: 106.7986,
                errors: {},
                map: null,
                marker: null,
                imagePreview: null,
                fileName: '',

                handleFileChange(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.fileName = file.name;
                        this.imagePreview = URL.createObjectURL(file); // Membuat URL sementara untuk preview gambar
                    }
                },

                // Fungsi validasi sebelum melangkah maju
                nextStep(currentStep) {
                    this.errors = {}; // Reset error

                    if (currentStep === 1) {
                        if (!this.judul.trim()) this.errors.judul = 'Judul laporan tidak boleh kosong.';
                        if (!this.kategori) this.errors.kategori = 'Kategori laporan harus dipilih.';
                        if (!this.detail.trim()) this.errors.detail = 'Detail deskripsi masalah wajib diisi.';

                        // Jika bebas error, lanjut ke step 2 & nyalakan map
                        if (Object.keys(this.errors).length === 0) {
                            this.step = 2;
                            this.$nextTick(() => {
                                this.initLeafletMap();
                            });
                        }
                    } else if (currentStep === 2) {
                        if (!this.alamat.trim()) this.errors.alamat = 'Alamat kejadian wajib diisi lengkap.';

                        if (Object.keys(this.errors).length === 0) {
                            this.step = 3;
                        }
                    }
                },

                // Inisialisasi Peta Leaflet JS
                initLeafletMap() {
                    if (this.map) {
                        // Karena Leaflet dimuat di container tersembunyi (x-show), ukuran render harus di-refresh
                        this.map.invalidateSize();
                        return;
                    }

                    // Setup peta dasar berpusat di Bogor
                    this.map = L.map('map').setView([this.lat, this.lng], 14);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap'
                    }).addTo(this.map);

                    // Buat Marker yang bisa digeser (draggable)
                    this.marker = L.marker([this.lat, this.lng], {
                        draggable: true
                    }).addTo(this.map);

                    // Deteksi ketika koordinat pin digeser oleh user
                    this.marker.on('dragend', () => {
                        const position = this.marker.getLatLng();
                        this.lat = position.lat.toFixed(6);
                        this.lng = position.lng.toFixed(6);
                    });

                    // Deteksi klik bebas di peta untuk memindahkan pin posisi
                    this.map.on('click', (e) => {
                        this.marker.setLatLng(e.latlng);
                        this.lat = e.latlng.lat.toFixed(6);
                        this.lng = e.latlng.lng.toFixed(6);
                    });
                }
            }
        }
    </script>
@endpush
