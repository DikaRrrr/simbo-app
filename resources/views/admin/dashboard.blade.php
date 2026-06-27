@extends('admin.v_layouts.app')

@section('title', 'Dashboard - Admin SIMBO')

        <main class="ml-[250px] w-[calc(100%-250px)]">

            <section class="p-7 font-worksans">

                <div class="mb-8 flex items-end justify-between">
                    <div>
                        <h2 class="text-2xl font-bold font-montserrat text-neutral">Ikhtisar Sistem</h2>
                        <p class="text-sm text-gray-500 mt-1">Memantau laporan masyarakat dan progres identifikasi hari
                            ini.</p>
                    </div>
                    <div
                        class="text-sm font-semibold text-gray-500 bg-white px-4 py-2 rounded-lg border border-gray-200">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

                    <div
                        class="bg-white border border-gray-200 border-l-4 border-l-primary rounded-xl p-5 min-h-[130px] shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-[11px] text-green-600 font-bold bg-green-50 px-2 py-1 rounded-full">+12%
                                minggu lalu</p>
                        </div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Total Laporan</p>
                        <h3 class="text-3xl font-extrabold font-montserrat text-neutral">1.284</h3>
                    </div>

                    <div
                        class="bg-white border border-gray-200 border-l-4 border-l-secondary rounded-xl p-5 min-h-[130px] shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-10 h-10 bg-secondary/10 rounded-lg flex items-center justify-center text-secondary">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-[11px] text-red-600 font-bold bg-red-50 px-2 py-1 rounded-full">Prioritas
                                Tinggi</p>
                        </div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Laporan Menunggu
                        </p>
                        <h3 class="text-3xl font-extrabold font-montserrat text-neutral">42</h3>
                    </div>

                    <div
                        class="bg-white border border-gray-200 border-l-4 border-l-blue-600 rounded-xl p-5 min-h-[130px] shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-[11px] text-blue-600 font-bold bg-blue-50 px-2 py-1 rounded-full">Sedang
                                Diproses</p>
                        </div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Laporan Ditugaskan
                        </p>
                        <h3 class="text-3xl font-extrabold font-montserrat text-neutral">156</h3>
                    </div>

                    <div
                        class="bg-white border border-gray-200 border-l-4 border-l-green-600 rounded-xl p-5 min-h-[130px] shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-[11px] text-green-600 font-bold bg-green-50 px-2 py-1 rounded-full">98%
                                Terselesaikan</p>
                        </div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Laporan Selesai
                        </p>
                        <h3 class="text-3xl font-extrabold font-montserrat text-neutral">1.086</h3>
                    </div>

                </div>

                <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6 mb-6">

                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-lg font-bold font-montserrat">Analisis Tren Mingguan</h3>
                            <button
                                class="bg-inputBg hover:bg-gray-200 transition-colors px-4 py-2 text-xs font-bold text-gray-600 rounded-lg flex items-center gap-2">
                                7 Hari Terakhir
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>

                        <div
                            class="relative h-[280px] border-b border-gray-200 flex items-end justify-between px-8 pb-9">
                            <div class="absolute left-5 right-5 bottom-[90px] h-px bg-gray-200 dashed"></div>

                            <span class="relative z-10 text-xs font-semibold text-gray-400">Sen</span>
                            <span class="relative z-10 text-xs font-semibold text-gray-400">Sel</span>
                            <span class="relative z-10 text-xs font-semibold text-gray-400">Rab</span>
                            <span class="relative z-10 text-xs font-semibold text-gray-400">Kam</span>
                            <span class="relative z-10 text-xs font-semibold text-gray-400">Jum</span>
                            <span class="relative z-10 text-xs font-semibold text-gray-400">Sab</span>
                            <span class="relative z-10 text-xs font-semibold text-gray-400">Min</span>

                            <div
                                class="absolute right-0 bottom-7 flex items-center gap-2 text-xs font-medium text-gray-500">
                                <span class="w-3 h-3 rounded-full bg-primary"></span>
                                Volume Laporan
                            </div>
                        </div>

                        <div class="grid grid-cols-3 text-center mt-6 pt-2">
                            <div class="border-r border-gray-200">
                                <p class="text-xs font-semibold text-gray-500 mb-1">Rata-rata Respon</p>
                                <strong class="text-sm text-neutral">2,4 jam</strong>
                            </div>
                            <div class="border-r border-gray-200">
                                <p class="text-xs font-semibold text-gray-500 mb-1">Akurasi Identifikasi</p>
                                <strong class="text-sm text-neutral">94,2%</strong>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 mb-1">Tingkat Pertumbuhan</p>
                                <strong class="text-sm text-green-600">+8,5%</strong>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold font-montserrat">Aktivitas Terbaru</h3>
                            <a href="#" class="text-xs font-bold text-primary hover:underline">Lihat Semua</a>
                        </div>

                        <div class="space-y-6">

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-9 h-9 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="w-full">
                                    <div class="flex justify-between items-start gap-3">
                                        <div>
                                            <h4 class="text-sm font-bold text-neutral">Infrastruktur Rusak</h4>
                                            <p class="text-xs text-gray-500 mt-0.5">Jl. Sudirman, Jakarta</p>
                                        </div>
                                        <span class="text-[10px] font-semibold text-gray-400 whitespace-nowrap">2 jam
                                            lalu</span>
                                    </div>
                                    <span
                                        class="inline-block mt-2 px-2.5 py-1 bg-red-50 text-red-600 text-[10px] font-bold uppercase tracking-wider rounded-md border border-red-100">Menunggu</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="w-full">
                                    <div class="flex justify-between items-start gap-3">
                                        <div>
                                            <h4 class="text-sm font-bold text-neutral">Kebersihan Taman</h4>
                                            <p class="text-xs text-gray-500 mt-0.5">Taman Menteng</p>
                                        </div>
                                        <span class="text-[10px] font-semibold text-gray-400 whitespace-nowrap">10 mnt
                                            lalu</span>
                                    </div>
                                    <span
                                        class="inline-block mt-2 px-2.5 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider rounded-md border border-blue-100">Ditugaskan</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-9 h-9 rounded-full bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="w-full">
                                    <div class="flex justify-between items-start gap-3">
                                        <div>
                                            <h4 class="text-sm font-bold text-neutral">Drainase Tersumbat</h4>
                                            <p class="text-xs text-gray-500 mt-0.5">Jl. Rasuna Said</p>
                                        </div>
                                        <span class="text-[10px] font-semibold text-gray-400 whitespace-nowrap">4 jam
                                            lalu</span>
                                    </div>
                                    <span
                                        class="inline-block mt-2 px-2.5 py-1 bg-green-50 text-green-600 text-[10px] font-bold uppercase tracking-wider rounded-md border border-green-100">Selesai</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm mb-10">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold font-montserrat">Antrean Identifikasi Menunggu</h3>
                        <div class="flex items-center gap-2 text-xs font-semibold text-gray-500">
                            <span>Terakhir diperbarui: Baru saja</span>
                            <button class="hover:text-primary transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-50/50">
                                    <th
                                        class="text-left text-xs font-bold uppercase tracking-wider text-gray-500 py-4 px-4 rounded-tl-lg">
                                        ID Laporan</th>
                                    <th
                                        class="text-left text-xs font-bold uppercase tracking-wider text-gray-500 py-4 px-4">
                                        Subjek Masalah</th>
                                    <th
                                        class="text-left text-xs font-bold uppercase tracking-wider text-gray-500 py-4 px-4">
                                        Kategori</th>
                                    <th
                                        class="text-left text-xs font-bold uppercase tracking-wider text-gray-500 py-4 px-4">
                                        Bukti</th>
                                    <th
                                        class="text-center text-xs font-bold uppercase tracking-wider text-gray-500 py-4 px-4 rounded-tr-lg">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-4 text-sm font-bold text-neutral">RPT-001</td>
                                    <td class="py-4 px-4 text-sm font-medium text-gray-600">Jalan berlubang di area
                                        permukiman</td>
                                    <td class="py-4 px-4">
                                        <span
                                            class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full">Infrastruktur</span>
                                    </td>
                                    <td class="py-4 px-4 text-sm text-gray-500 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        2 Foto
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <a href="#"
                                            class="inline-block bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-opacity-90 transition-all shadow-sm">
                                            Identifikasi
                                        </a>
                                    </td>
                                </tr>

                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-4 text-sm font-bold text-neutral">RPT-002</td>
                                    <td class="py-4 px-4 text-sm font-medium text-gray-600">Sampah menumpuk di pasar
                                    </td>
                                    <td class="py-4 px-4">
                                        <span
                                            class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full">Kebersihan</span>
                                    </td>
                                    <td class="py-4 px-4 text-sm text-gray-500 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        1 Foto
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <a href="#"
                                            class="inline-block bg-white border border-gray-300 text-neutral px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-50 transition-all shadow-sm">
                                            Tinjau
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
        </main>

    </div>

</body>

</html>
