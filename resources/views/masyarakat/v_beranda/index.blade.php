@extends('masyarakat.v_layouts.app')

@section('title', 'Beranda - SIMBO')
@section('page_title', 'Beranda')

@section('content')
<div class="space-y-8 w-full">

    {{-- 1. Hero Section --}}
    <section class="bg-gray-900 rounded-2xl p-8 border border-gray-200 shadow-sm relative overflow-hidden bg-cover bg-center" 
             style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('images/hero-bogor.jpg') }}');">
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">Halo, {{ auth()->user()->nama_lengkap ?? 'Warga Bogor' }}!</h2>
                <h3 class="text-xl font-semibold text-gray-200 mb-4">Selamat Datang di SIMBO</h3>
                <p class="text-sm text-gray-300 max-w-2xl leading-relaxed">
                    Sampaikan aspirasi dan pengaduan Anda dengan mudah. Bersama, kita wujudkan pelayanan publik yang cepat, transparan, dan responsif untuk Kota Bogor.
                </p>
            </div>
        </div>
    </section>

    {{-- 2. Statistics Grid --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col items-center justify-center text-center border-t-4 border-t-neutral">
            <p class="text-4xl font-extrabold text-neutral">{{ $totalLaporan ?? '1,284' }}</p>
            <p class="text-xs font-bold text-gray-500 mt-2 uppercase tracking-wider">Total Laporan</p>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col items-center justify-center text-center border-t-4 border-t-yellow-500">
            <p class="text-4xl font-extrabold text-neutral">{{ $diprosesLaporan ?? '42' }}</p>
            <p class="text-xs font-bold text-gray-500 mt-2 uppercase tracking-wider">Sedang Diproses</p>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col items-center justify-center text-center border-t-4 border-t-green-500">
            <p class="text-4xl font-extrabold text-neutral">{{ $selesaiLaporan ?? '1,242' }}</p>
            <p class="text-xs font-bold text-gray-500 mt-2 uppercase tracking-wider">Selesai</p>
        </div>
    </section>

    {{-- 3. Action Buttons --}}
    <section class="flex flex-wrap gap-4 justify-center">
        <a href="{{ route('laporan.index') }}" class="bg-primary text-white flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-md hover:shadow-lg">
            <i class="ph ph-plus-circle text-xl"></i>
            Membuat Laporan
        </a>
        <a href="#" class="bg-white border border-gray-300 text-gray-700 flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm hover:bg-gray-50 transition-all shadow-sm">
            <i class="ph ph-info text-xl"></i>
            Pelajari Lebih Lanjut
        </a>
    </section>

    {{-- 4. Recent Activity --}}
    <section>
        <h3 class="text-lg font-bold text-neutral mb-4 flex items-center gap-2">
            <i class="ph ph-clock-counter-clockwise text-primary text-xl"></i> Aktivitas Terbaru
        </h3>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
            
            <div class="flex items-start gap-4 p-4 hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-0 cursor-pointer">
                <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                    <i class="ph ph-warning text-xl"></i>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-neutral">Laporan Infrastruktur: Jalan Rusak</h4>
                    <p class="text-sm text-gray-500 mt-1">Laporan baru dibuat mengenai jalan berlubang di Jl. Pajajaran.</p>
                    <p class="text-xs text-gray-400 mt-2">10 Menit yang lalu</p>
                </div>
                <div class="shrink-0">
                    <span class="px-2.5 py-1 rounded-md bg-orange-50 text-orange-600 text-xs font-bold border border-orange-100">Baru</span>
                </div>
            </div>

            <div class="flex items-start gap-4 p-4 hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-0 cursor-pointer">
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                    <i class="ph ph-arrows-clockwise text-xl"></i>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-neutral">Laporan #8293 telah diperbarui</h4>
                    <p class="text-sm text-gray-500 mt-1">Status laporan mengenai lampu jalan mati telah diubah menjadi "Sedang Diproses".</p>
                    <p class="text-xs text-gray-400 mt-2">2 Jam yang lalu</p>
                </div>
                <div class="shrink-0">
                    <span class="px-2.5 py-1 rounded-md bg-blue-50 text-blue-600 text-xs font-bold border border-blue-100">Proses</span>
                </div>
            </div>

        </div>
    </section>

    {{-- 5. Latest News Section --}}
    <section>
        <h3 class="text-lg font-bold text-neutral mb-4 flex items-center gap-2">
            <i class="ph ph-newspaper text-primary text-xl"></i> Berita Terbaru
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <article class="bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm flex flex-col group cursor-pointer hover:shadow-md transition-all">
                <div class="h-40 bg-gray-200 relative overflow-hidden">
                    <img class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1570125909232-eb263c188f7e?q=80&w=600&auto=format&fit=crop" alt="Berita Infrastruktur">
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <span class="text-xs font-bold text-primary mb-2 uppercase tracking-wider">Infrastruktur</span>
                    <h4 class="text-sm font-bold text-neutral mb-2 line-clamp-2 group-hover:text-primary transition-colors">Program revitalisasi transportasi publik diluncurkan di pusat kota</h4>
                    <div class="mt-auto pt-4 flex items-center justify-between text-gray-400 border-t border-gray-50">
                        <span class="text-xs font-medium">Hari ini</span>
                        <i class="ph ph-arrow-right text-lg group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </article>

            <article class="bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm flex flex-col group cursor-pointer hover:shadow-md transition-all">
                <div class="h-40 bg-gray-200 relative overflow-hidden">
                    <img class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=600&auto=format&fit=crop" alt="Berita Pelayanan">
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <span class="text-xs font-bold text-primary mb-2 uppercase tracking-wider">Pelayanan</span>
                    <h4 class="text-sm font-bold text-neutral mb-2 line-clamp-2 group-hover:text-primary transition-colors">Peningkatan metrik kecepatan respons layanan kota mencapai rekor baru</h4>
                    <div class="mt-auto pt-4 flex items-center justify-between text-gray-400 border-t border-gray-50">
                        <span class="text-xs font-medium">Kemarin</span>
                        <i class="ph ph-arrow-right text-lg group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </article>

            <article class="bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm flex flex-col group cursor-pointer hover:shadow-md transition-all">
                <div class="h-40 bg-gray-200 relative overflow-hidden">
                    <img class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=600&auto=format&fit=crop" alt="Berita Lingkungan">
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <span class="text-xs font-bold text-primary mb-2 uppercase tracking-wider">Lingkungan</span>
                    <h4 class="text-sm font-bold text-neutral mb-2 line-clamp-2 group-hover:text-primary transition-colors">Ekspansi program taman kota hadirkan ruang terbuka hijau di setiap daerah</h4>
                    <div class="mt-auto pt-4 flex items-center justify-between text-gray-400 border-t border-gray-50">
                        <span class="text-xs font-medium">3 Hari yang lalu</span>
                        <i class="ph ph-arrow-right text-lg group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </article>

        </div>
    </section>

</div>
@endsection