@extends('admin.v_layouts.app')

@section('title', 'Identifikasi Laporan - Admin SIMBO')

<!-- Main Content -->
<main class="ml-[250px] w-[calc(100%-250px)] bg-dash-secondary min-h-screen font-worksans">

    <!-- Topbar -->
    <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 sticky top-0 z-40 shadow-sm">
        
        <!-- Search Bar -->
        <div class="w-[400px] h-11 rounded-full bg-inputBg flex items-center gap-3 px-5 border border-transparent focus-within:border-primary/30 focus-within:bg-white transition-all">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" placeholder="Cari data laporan..."
                class="w-full bg-transparent outline-none text-sm placeholder:text-gray-500 font-medium" />
        </div>

        <!-- Right Menu -->
        <div class="flex items-center gap-6">
            <!-- Notification -->
            <button class="relative p-2 text-gray-500 hover:text-primary transition-colors rounded-full hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
            </button>

            <!-- Profil -->
            <div class="flex items-center gap-3">
                <div class="text-right hidden md:block">
                    <h4 class="text-sm font-bold text-neutral">{{ Auth::guard('admin')->user()->nama_admin ?? 'Admin' }}</h4>
                    <p class="text-[11px] text-gray-500 font-medium">Super Administrator</p>
                </div>
                <div class="w-10 h-10 rounded-full border border-primary/20 bg-primary/10 flex items-center justify-center text-primary font-bold shadow-sm">
                    {{ substr(Auth::guard('admin')->user()->nama_admin ?? 'A', 0, 1) }}
                </div>
            </div>
        </div>
    </header>

    <!-- Page Area -->
    <section class="p-8">

        <!-- Page Title -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold font-montserrat text-neutral">
                Identifikasi Laporan
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Tinjau dan tugaskan laporan warga yang masuk kepada petugas lapangan.
            </p>
        </div>

        <!-- Filter Card -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 mb-6 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-4">
                
                <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                    <!-- Search Filter -->
                    <div class="w-full lg:w-[300px] h-10 border border-gray-300 bg-white rounded-lg flex items-center gap-2 px-3 focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-all">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" placeholder="Cari berdasarkan ID atau subjek..."
                            class="w-full bg-transparent outline-none text-xs placeholder:text-gray-400" />
                    </div>

                    <!-- Kategori Dropdown -->
                    <div class="relative">
                        <select class="h-10 appearance-none border border-gray-300 bg-white rounded-lg pl-4 pr-10 text-xs text-gray-600 outline-none focus:border-primary focus:ring-1 focus:ring-primary cursor-pointer">
                            <option>Semua Kategori</option>
                            <option>Infrastruktur</option>
                            <option>Lingkungan</option>
                            <option>Keamanan</option>
                        </select>
                        <svg class="w-4 h-4 text-gray-500 absolute right-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    <!-- Prioritas Dropdown -->
                    <div class="relative">
                        <select class="h-10 appearance-none border border-gray-300 bg-white rounded-lg pl-4 pr-10 text-xs text-gray-600 outline-none focus:border-primary focus:ring-1 focus:ring-primary cursor-pointer">
                            <option>Prioritas</option>
                            <option>Tinggi</option>
                            <option>Sedang</option>
                            <option>Rendah</option>
                        </select>
                        <svg class="w-4 h-4 text-gray-500 absolute right-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <button class="h-10 px-5 border border-gray-300 bg-gray-50 hover:bg-gray-100 rounded-lg text-xs font-bold text-gray-600 flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    Filter Lainnya
                </button>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="text-left py-4 px-6 text-xs font-bold uppercase tracking-wider text-gray-500">ID Laporan</th>
                            <th class="text-left py-4 px-6 text-xs font-bold uppercase tracking-wider text-gray-500">Subjek</th>
                            <th class="text-left py-4 px-6 text-xs font-bold uppercase tracking-wider text-gray-500">Kategori</th>
                            <th class="text-left py-4 px-6 text-xs font-bold uppercase tracking-wider text-gray-500">Tanggal Diterima</th>
                            <th class="text-left py-4 px-6 text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="text-right py-4 px-6 text-xs font-bold uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        
                        <!-- Row 1 -->
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="py-4 px-6">
                                <span class="text-sm font-bold text-neutral">#INF-2023-090</span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm font-semibold text-neutral">Pohon Tumbang</p>
                                <p class="text-xs text-gray-500 mt-0.5">Jl. Sudirman</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    Infrastruktur
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm font-semibold text-gray-600">12 Okt 2023</p>
                                <p class="text-xs text-gray-400">08:30 WIB</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold border border-orange-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-600"></span>
                                    Pending
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ url('/admin/identifikasi') }}" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-xs font-bold transition-all shadow-sm flex items-center gap-2 ml-auto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    Identifikasi
                                </a>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="py-4 px-6">
                                <span class="text-sm font-bold text-neutral">#ENV-2023-091</span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm font-semibold text-neutral">Tumpukan Sampah Liar</p>
                                <p class="text-xs text-gray-500 mt-0.5">Pasar Induk</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Lingkungan
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm font-semibold text-gray-600">12 Okt 2023</p>
                                <p class="text-xs text-gray-400">09:15 WIB</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold border border-orange-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-600"></span>
                                    Pending
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ url('/admin/identifikasi/1') }}" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-xs font-bold transition-all shadow-sm flex items-center gap-2 ml-auto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    Identifikasi
                                </a>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="py-4 px-6">
                                <span class="text-sm font-bold text-neutral">#SEC-2023-092</span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm font-semibold text-neutral">Lampu Jalan Mati</p>
                                <p class="text-xs text-gray-500 mt-0.5">Komplek A</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 text-xs font-bold border border-amber-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    Keamanan
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm font-semibold text-gray-600">11 Okt 2023</p>
                                <p class="text-xs text-gray-400">20:45 WIB</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold border border-orange-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-600"></span>
                                    Pending
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ url('admin/detail-identifikasi') }}" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-xs font-bold transition-all shadow-sm flex items-center gap-2 ml-auto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    Identifikasi
                                </a>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination -->
            <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-t border-gray-200">
                <p class="text-xs font-semibold text-gray-500">
                    Menampilkan 1 sampai 3 dari 24 laporan pending
                </p>
                <div class="flex items-center gap-1.5">
                    <button class="w-8 h-8 flex items-center justify-center border border-gray-300 bg-white text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center bg-primary text-white text-xs font-bold rounded-lg shadow-sm">
                        1
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center border border-gray-300 bg-white text-gray-600 hover:bg-gray-100 text-xs font-bold rounded-lg transition-colors">
                        2
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center border border-gray-300 bg-white text-gray-600 hover:bg-gray-100 text-xs font-bold rounded-lg transition-colors">
                        3
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center border border-gray-300 bg-white text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

    </section>
</main>
