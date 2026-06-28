@extends('admin.v_layouts.app')

@section('title', 'Arsip Laporan - Admin SIMBO')

<main class="ml-[250px] w-[calc(100%-250px)] bg-dash-secondary min-h-screen font-worksans p-8">

    <div class="mb-6">
        <h2 class="text-2xl font-bold font-montserrat text-neutral mb-1">Arsip Laporan</h2>
        <p class="text-sm text-gray-500">
            Daftar laporan warga yang telah selesai diproses atau ditutup.
        </p>
    </div>

    <div class="bg-white p-4 rounded-xl border border-gray-200 mb-6 shadow-sm">
        <form action="#" method="GET" class="flex flex-wrap items-end gap-4 w-full">

            <div class="flex-1 min-w-[200px]">
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Cari
                    Laporan</label>
                <div class="relative">
                    <input type="text" name="q" placeholder="ID atau Subjek..."
                        class="w-full h-10 pl-9 pr-3 bg-gray-50 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all" />
                </div>
            </div>

            <div class="flex-1 min-w-[150px]">
                <label
                    class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kategori</label>
                <select name="kategori"
                    class="w-full h-10 px-3 bg-gray-50 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <option value="infrastruktur">Infrastruktur</option>
                    <option value="lingkungan">Lingkungan</option>
                    <option value="keamanan">Keamanan</option>
                </select>
            </div>

            <div class="flex-1 min-w-[150px]">
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Tanggal</label>
                <input type="date" name="tanggal"
                    class="w-full h-10 px-3 bg-gray-50 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all" />
            </div>

            <div class="flex-1 min-w-[150px]">
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Status
                    Akhir</label>
                <select name="status"
                    class="w-full h-10 px-3 bg-gray-50 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="selesai">Selesai</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>

            <div class="flex items-center gap-2 mt-2 sm:mt-0">
                <a href="#" title="Reset Filter"
                    class="h-10 px-4 flex items-center justify-center border border-gray-300 bg-white text-gray-600 text-sm font-bold rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                    Reset
                </a>
                <button type="submit"
                    class="h-10 px-5 flex items-center justify-center bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 transition-all shadow-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                        </path>
                    </svg>
                    Filter
                </button>
            </div>

        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">ID Laporan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Subjek</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Selesai
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status Akhir</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="px-6 py-4 text-sm font-bold text-neutral">#INF-2023-001</td>
                        <td class="px-6 py-4 text-sm font-semibold text-neutral">Perbaikan Jalan Berlubang</td>
                        <td class="px-6 py-4 text-sm text-gray-500">Infrastruktur</td>
                        <td class="px-6 py-4 text-sm text-gray-500">15 Okt 2023</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
                                Selesai
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="#"
                                class="text-primary hover:text-primary/80 text-sm font-bold transition-colors">Lihat
                                Detail</a>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="px-6 py-4 text-sm font-bold text-neutral">#ENV-2023-005</td>
                        <td class="px-6 py-4 text-sm font-semibold text-neutral">Penumpukan Sampah Liar</td>
                        <td class="px-6 py-4 text-sm text-gray-500">Lingkungan</td>
                        <td class="px-6 py-4 text-sm text-gray-500">12 Okt 2023</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
                                Selesai
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="#"
                                class="text-primary hover:text-primary/80 text-sm font-bold transition-colors">Lihat
                                Detail</a>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="px-6 py-4 text-sm font-bold text-neutral">#SEC-2023-012</td>
                        <td class="px-6 py-4 text-sm font-semibold text-neutral">Gangguan Ketertiban</td>
                        <td class="px-6 py-4 text-sm text-gray-500">Keamanan</td>
                        <td class="px-6 py-4 text-sm text-gray-500">10 Okt 2023</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full bg-red-50 text-red-700 text-xs font-bold border border-red-100">
                                Ditolak
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="#"
                                class="text-primary hover:text-primary/80 text-sm font-bold transition-colors">Lihat
                                Detail</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50">
            <span class="text-xs font-semibold text-gray-500">Menampilkan 1 - 3 dari 124 laporan</span>

            <div class="flex items-center gap-1.5">
                <button
                    class="w-8 h-8 flex items-center justify-center border border-gray-300 bg-white text-gray-400 rounded-lg cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>
                <button
                    class="w-8 h-8 flex items-center justify-center bg-primary text-white text-xs font-bold rounded-lg shadow-sm">
                    1
                </button>
                <button
                    class="w-8 h-8 flex items-center justify-center border border-gray-300 bg-white text-gray-600 hover:bg-gray-100 text-xs font-bold rounded-lg transition-colors">
                    2
                </button>
                <button
                    class="w-8 h-8 flex items-center justify-center border border-gray-300 bg-white text-gray-600 hover:bg-gray-100 text-xs font-bold rounded-lg transition-colors">
                    3
                </button>
                <button
                    class="w-8 h-8 flex items-center justify-center border border-gray-300 bg-white text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

</main>
