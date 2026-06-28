@extends('v_layouts.app')

@section('title', 'Beranda - SIMBO')

@section('content')

    {{-- ================================================ --}}
    {{-- SECTION: HERO                                     --}}
    {{-- ================================================ --}}
    <main id="beranda" class="relative w-full flex-grow flex items-center overflow-hidden">

        {{-- Latar Belakang Peta --}}
        <div class="absolute inset-y-0 right-0 w-full lg:w-2/3 bg-no-repeat bg-right bg-[length:160%_160%] lg:bg-center bg-contain opacity-20 pointer-events-none max-w-0 lg:max-w-full"
            style="background-image: url('{{ asset('images/peta.png') }}');">
        </div>

        <div
            class="relative z-10 max-w-7xl mx-auto px-20 py-12 lg:py-20 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center w-full">

            {{-- Teks Kiri --}}
            <div class="lg:col-span-7 space-y-10 lg:space-y-12">
                <h1 class="font-montserrat text-4xl md:text-6xl lg:text-[3.5rem] font-extrabold leading-snug tracking-tight">
                    Platform Terpadu Pengaduan Masyarakat untuk Pelayanan Publik yang Lebih Cepat dan Transparan
                </h1>
                <p class="font-worksans text-base md:text-lg text-white/90 leading-relaxed max-w-lg">
                    Mulai dari menyampaikan pengaduan hingga memantau tindak lanjut laporan dalam satu platform.
                    SIMBO #LaporJadiMudah untuk pelayanan publik yang lebih baik.
                </p>
            </div>

            {{-- Logo & Tombol Kanan --}}
            <div class="lg:col-span-5 flex flex-col items-center lg:items-end space-y-6 mt-8 lg:mt-0">
                <div class="w-full aspect-square flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Simbo Kota Bogor"
                        class="w-full h-full object-contain p-4" />
                </div>

                <div class="flex items-center gap-4 w-full max-w-[420px] justify-center lg:justify-end pr-20">

                    <a href="{{ url('/register') }}"
                        class="border-2 border-neutral text-white font-semibold px-8 py-3 rounded-full hover:bg-neutral hover:text-white transition-all duration-300">
                        Daftar
                    </a>
                    <a href="{{ url('/login') }}"
                        class="bg-neutral text-white font-extrabold px-8 py-3 rounded-full hover:scale-105 transition-all duration-300 shadow-lg">
                        Masuk
                    </a>

                </div>
            </div>

        </div>
    </main>


    {{-- ================================================ --}}
    {{-- SECTION: TENTANG KAMI                            --}}
    {{-- ================================================ --}}
    <section id="tentang" class="bg-gradient-to-b from-white to-primary/5 py-16 lg:py-24 text-neutral w-full">
        <div class="max-w-7xl mx-auto px-8">

            <div class="flex justify-center mb-12">
                <span
                    class="bg-primary text-white font-montserrat font-bold px-8 py-3 rounded-full text-sm md:text-base tracking-wide shadow-md">
                    Tentang Kami
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                <div
                    class="bg-tertiary aspect-square rounded-[2rem] overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 shadow-lg group relative">
                    <img src="logo.png" alt="Dokumentasi 1"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                </div>
                <div
                    class="bg-tertiary aspect-square rounded-[2rem] overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 shadow-lg group relative">
                    <img src="logo.png" alt="Dokumentasi 2"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                </div>
                <div
                    class="bg-tertiary aspect-square rounded-[2rem] overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 shadow-lg group relative">
                    <img src="logo.png" alt="Dokumentasi 3"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                </div>
            </div>

        </div>
    </section>


    {{-- ================================================ --}}
    {{-- SECTION: KENAPA SIMBO (FITUR)                    --}}
    {{-- ================================================ --}}
    <section id="fitur" class="bg-primary py-16 lg:py-24 text-white w-full">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            <div>
                <h2 class="font-montserrat text-3xl md:text-4xl font-extrabold mb-10 leading-tight">
                    Kenapa Memilih Sistem SIMBO?
                </h2>

                <div class="space-y-6">

                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-montserrat font-bold text-base md:text-lg">Tindak lanjut Laporan</h4>
                            <p class="font-worksans text-sm md:text-base mt-1 leading-relaxed text-white/80">
                                Hanya laporan terkait <span class="font-bold text-white">permasalahan di BOGOR</span> saja
                                yang akan ditindak lanjuti
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-montserrat font-bold text-base md:text-lg">Lokasi Laporan</h4>
                            <p class="font-worksans text-sm md:text-base mt-1 leading-relaxed text-white/80">
                                Lokasi laporan kamu <span class="font-bold text-white">diambil secara otomatis</span>
                                berdasarkan lokasi yang tersimpan saat pengambilan foto.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-montserrat font-bold text-base md:text-lg">Laporan Private/Rahasia</h4>
                            <p class="font-worksans text-sm md:text-base mt-1 leading-relaxed text-white/80">
                                Jenis laporanmu akan otomatis terpilih private/rahasia. Tetap pakai jenis laporan ini jika
                                kamu ingin laporanmu tidak terlihat oleh siapapun kecuali dirimu sendiri dan petugas.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-montserrat font-bold text-base md:text-lg">Laporan Publik</h4>
                            <p class="font-worksans text-sm md:text-base mt-1 leading-relaxed text-white/80">
                                Ubah jenis laporan menjadi Publik pada laman Tinjau laporan jika kamu ingin laporanmu
                                terlihat oleh pengguna SIMBO lainnya.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-montserrat font-bold text-base md:text-lg">Tracking Laporan</h4>
                            <p class="font-worksans text-sm md:text-base mt-1 leading-relaxed text-white/80">
                                Pengguna dapat memantau status laporan terkait pengaduan yang diajukan secara <span
                                    class="font-bold text-white">transparan</span>.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 lg:gap-6 mt-8 lg:mt-0">

                {{-- Card 1: Transparan --}}
                <div
                    class="bg-blue-100 aspect-[4/3] rounded-3xl shadow-xl flex flex-col items-center justify-center text-center p-6">
                    <span class="text-4xl md:text-5xl font-extrabold font-montserrat text-blue-600">100%</span>
                    <span class="font-semibold mt-2 text-blue-900 text-sm">Transparan</span>
                </div>

                {{-- Card 2: Online --}}
                <div
                    class="bg-green-100 aspect-[4/3] rounded-3xl shadow-xl flex flex-col items-center justify-center text-center p-6">
                    <span class="text-4xl md:text-5xl font-extrabold font-montserrat text-green-600">24/7</span>
                    <span class="font-semibold mt-2 text-green-900 text-sm">Online</span>
                </div>

                {{-- Card 3: Waktu Respons --}}
                <div
                    class="bg-amber-100 aspect-[4/3] rounded-3xl shadow-xl flex flex-col items-center justify-center text-center p-6">
                    <span class="text-4xl md:text-5xl font-extrabold font-montserrat text-amber-600">&lt;3</span>
                    <span class="text-sm font-extrabold font-montserrat text-amber-600">Hari</span>
                    <span class="font-semibold mt-2 text-amber-900 text-sm">Waktu Respons</span>
                </div>

                {{-- Card 4: Gratis --}}
                <div
                    class="bg-violet-100 aspect-[4/3] rounded-3xl shadow-xl flex flex-col items-center justify-center text-center p-6">
                    <span class="text-4xl md:text-5xl font-extrabold font-montserrat text-violet-600">100%</span>
                    <span class="font-semibold mt-2 text-violet-900 text-sm">Gratis</span>
                </div>

            </div>

        </div>
    </section>


    {{-- ================================================ --}}
    {{-- SECTION: ALUR PENGADUAN                          --}}
    {{-- ================================================ --}}
    <section id="alur" class="bg-white py-16 lg:py-24 text-neutral w-full">
        <div class="max-w-7xl mx-auto px-8">

            <div class="flex justify-center mb-6">
                <span
                    class="bg-white border border-tertiary text-primary font-montserrat font-bold px-8 py-3 rounded-full text-sm md:text-base tracking-wide shadow-sm">
                    Alur Pengaduan
                </span>
            </div>

            <h2 class="text-center font-montserrat text-3xl md:text-4xl font-extrabold mb-16 leading-tight">
                Proses Laporan yang Mudah & Transparan
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-6 text-center">

                <div class="flex flex-col items-center group">
                    <div
                        class="w-20 h-20 bg-white border-2 border-tertiary rounded-full mb-6 flex items-center justify-center text-primary shadow-sm transform group-hover:-translate-y-2 group-hover:bg-primary group-hover:border-primary group-hover:text-white transition-all duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h4
                        class="font-montserrat font-bold text-lg mb-2 group-hover:text-primary transition-colors duration-300">
                        Daftar & Login</h4>
                    <p class="font-worksans text-sm text-neutral/70 px-2 leading-relaxed">Buat akun gratis dan login ke
                        platform SIMBO</p>
                </div>

                <div class="flex flex-col items-center group">
                    <div
                        class="w-20 h-20 bg-white border-2 border-tertiary rounded-full mb-6 flex items-center justify-center text-primary shadow-sm transform group-hover:-translate-y-2 group-hover:bg-primary group-hover:border-primary group-hover:text-white transition-all duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </div>
                    <h4
                        class="font-montserrat font-bold text-lg mb-2 group-hover:text-primary transition-colors duration-300">
                        Detail Laporan</h4>
                    <p class="font-worksans text-sm text-neutral/70 px-2 leading-relaxed">Tulis deskripsi laporan terkait
                        masalah yang terjadi</p>
                </div>

                <div class="flex flex-col items-center group">
                    <div
                        class="w-20 h-20 bg-white border-2 border-tertiary rounded-full mb-6 flex items-center justify-center text-primary shadow-sm transform group-hover:-translate-y-2 group-hover:bg-primary group-hover:border-primary group-hover:text-white transition-all duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h4
                        class="font-montserrat font-bold text-lg mb-2 group-hover:text-primary transition-colors duration-300">
                        Upload Foto</h4>
                    <p class="font-worksans text-sm text-neutral/70 px-2 leading-relaxed">Upload foto masalah yang ingin
                        dilaporkan</p>
                </div>

                <div class="flex flex-col items-center group">
                    <div
                        class="w-20 h-20 bg-white border-2 border-tertiary rounded-full mb-6 flex items-center justify-center text-primary shadow-sm transform group-hover:-translate-y-2 group-hover:bg-primary group-hover:border-primary group-hover:text-white transition-all duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h4
                        class="font-montserrat font-bold text-lg mb-2 group-hover:text-primary transition-colors duration-300">
                        Atur Lokasi</h4>
                    <p class="font-worksans text-sm text-neutral/70 px-2 leading-relaxed">Atur lokasi laporan sesuai tempat
                        kejadian</p>
                </div>

                <div class="flex flex-col items-center group">
                    <div
                        class="w-20 h-20 bg-white border-2 border-tertiary rounded-full mb-6 flex items-center justify-center text-primary shadow-sm transform group-hover:-translate-y-2 group-hover:bg-primary group-hover:border-primary group-hover:text-white transition-all duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </div>
                    <h4
                        class="font-montserrat font-bold text-lg mb-2 group-hover:text-primary transition-colors duration-300">
                        Tinjauan Laporan</h4>
                    <p class="font-worksans text-sm text-neutral/70 px-2 leading-relaxed">Pantau status laporan dan
                        notifikasi laporan</p>
                </div>

            </div>
        </div>
    </section>


    {{-- ================================================ --}}
    {{-- SECTION: CTA                                     --}}
    {{-- ================================================ --}}
    <section id="cta" class="bg-primary py-20 lg:py-28 w-full text-center shadow-inner">
        <div class="max-w-3xl mx-auto px-8 text-white">
            <h2 class="font-montserrat text-4xl md:text-5xl font-extrabold mb-6 leading-tight">
                Siap Membuat Laporan?
            </h2>
            <p class="font-worksans text-base md:text-lg text-white/90 mb-10 leading-relaxed max-w-2xl mx-auto">
                Mulai dari menyampaikan pengaduan hingga memantau tindak lanjut laporan dalam satu platform,
                untuk pelayanan publik yang lebih baik.
            </p>
            <a href="{{ url('login') }}"
                class="inline-block bg-white text-primary font-worksans font-bold text-base md:text-lg px-10 py-4 rounded-full hover:scale-105 hover:shadow-2xl transition-all duration-300 shadow-lg">
                Mulai Lapor Sekarang
            </a>
        </div>
    </section>


    {{-- ================================================ --}}
    {{-- SECTION: BERITA TERKINI                          --}}
    {{-- ================================================ --}}
    <section id="berita" class="bg-white py-16 lg:py-24 text-neutral w-full">
        <div class="max-w-7xl mx-auto px-8">

            <div class="flex justify-center mb-12">
                <span
                    class="bg-primary text-white font-montserrat font-bold px-8 py-3 rounded-full text-sm md:text-base tracking-wide shadow-md">
                    Berita Terkini
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">

                <div class="group cursor-pointer">
                    <div
                        class="bg-tertiary aspect-[4/3] rounded-[2rem] overflow-hidden transform group-hover:-translate-y-2 transition-all duration-300 shadow-md mb-6 relative">
                        <img src="berita-1.jpg" alt="Ilustrasi Berita 1"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>
                    <h4
                        class="font-montserrat font-bold text-base md:text-lg leading-snug group-hover:text-primary transition-colors">
                        PLN Lakukan Pemadaman Listrik di Bogor, Ini Daftar Wilayah yang Terdampak
                    </h4>
                    <p class="font-worksans text-sm text-neutral/60 mt-3">24 Juni 2026 • Fasilitas Umum</p>
                </div>

                <div class="group cursor-pointer">
                    <div
                        class="bg-tertiary aspect-[4/3] rounded-[2rem] overflow-hidden transform group-hover:-translate-y-2 transition-all duration-300 shadow-md mb-6 relative">
                        <img src="berita-2.jpg" alt="Ilustrasi Berita 2"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>
                    <h4
                        class="font-montserrat font-bold text-base md:text-lg leading-snug group-hover:text-primary transition-colors">
                        Perbaikan Jalan Raya Tajur Rampung Lebih Cepat dari Target Pemerintah
                    </h4>
                    <p class="font-worksans text-sm text-neutral/60 mt-3">23 Juni 2026 • Infrastruktur</p>
                </div>

                <div class="group cursor-pointer">
                    <div
                        class="bg-tertiary aspect-[4/3] rounded-[2rem] overflow-hidden transform group-hover:-translate-y-2 transition-all duration-300 shadow-md mb-6 relative">
                        <img src="berita-3.jpg" alt="Ilustrasi Berita 3"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>
                    <h4
                        class="font-montserrat font-bold text-base md:text-lg leading-snug group-hover:text-primary transition-colors">
                        Puskesmas Tanah Sareal Tambah Jam Operasional untuk Layanan Darurat
                    </h4>
                    <p class="font-worksans text-sm text-neutral/60 mt-3">21 Juni 2026 • Kesehatan</p>
                </div>

            </div>

            <div class="flex justify-center mt-12">
                <a href="#"
                    class="inline-flex items-center gap-2 font-worksans font-semibold text-primary hover:text-primary/80 transition-colors">
                    Lihat Semua Berita
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

        </div>
    </section>

    {{-- Tombol Back to Top --}}
    <button id="btn-back-to-top"
        class="fixed bottom-8 right-8 z-50 w-12 h-12 bg-primary text-white rounded-full shadow-lg flex items-center justify-center hover:bg-primary/90 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 opacity-0 pointer-events-none">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path>
        </svg>
    </button>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ── Smooth Scroll untuk semua anchor link ──────────────────────
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const target = document.querySelector(this.getAttribute('href'));
                    if (!target) return;
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });

            // ── Active Nav berdasarkan Section yang Terlihat ────────────────
            const sections = document.querySelectorAll('section[id], main[id]');
            const navLinks = document.querySelectorAll('.nav-link[data-section]');

            const setActiveLink = (activeId) => {
                navLinks.forEach(link => {
                    const underline = link.querySelector('.nav-underline');
                    const isActive = link.getAttribute('data-section') === activeId;

                    link.classList.toggle('text-white', isActive);
                    link.classList.toggle('font-bold', isActive);
                    link.classList.toggle('text-white/80', !isActive);

                    if (underline) {
                        underline.classList.toggle('w-full', isActive);
                        underline.classList.toggle('w-0', !isActive);
                    }
                });
            };

            // Set default aktif: Beranda
            setActiveLink('beranda');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        setActiveLink(entry.target.getAttribute('id'));
                    }
                });
            }, {
                threshold: 0.35,
                rootMargin: '-80px 0px -20% 0px',
            });

            sections.forEach(section => observer.observe(section));

            // ── Tombol Back to Top ──────────────────────────────────────────
            const btnTop = document.getElementById('btn-back-to-top');

            window.addEventListener('scroll', () => {
                const show = window.scrollY > 400;
                btnTop.classList.toggle('opacity-100', show);
                btnTop.classList.toggle('pointer-events-auto', show);
                btnTop.classList.toggle('opacity-0', !show);
                btnTop.classList.toggle('pointer-events-none', !show);
            }, {
                passive: true
            });

            btnTop.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

        });
    </script>
@endpush
