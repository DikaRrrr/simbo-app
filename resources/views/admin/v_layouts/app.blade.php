<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIMBO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-montserrat bg-dash-secondary text-neutral">

    <div class="flex min-h-screen">

        <aside
            class="fixed left-0 top-0 bottom-0 w-[250px] bg-white border-r border-gray-200 flex flex-col justify-between z-50">

            <div>
                <div class="flex items-center gap-3 px-6 py-5">
                    <div
                        class="w-8 h-8 bg-primary text-white flex items-center justify-center font-extrabold rounded-md shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-[28px] leading-6 font-extrabold tracking-[2px] text-primary">
                            SIMBO
                        </h1>
                        <p class="text-[10px] tracking-wide text-gray-500 font-semibold uppercase mt-0.5">
                            Admin Portal
                        </p>
                    </div>
                </div>

                <nav class="px-3 mt-4 space-y-2">

                    <a href="{{ url('/admin/dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold bg-primary text-white shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ url('/admin/identifikasi') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold text-neutral hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                        Identifikasi Laporan
                    </a>

                    <a href="{{ url('/admin/pengguna') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold text-neutral hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Manajemen Pengguna
                    </a>

                    <a href="{{ url('/admin/arsip-laporan') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold text-neutral hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                            </path>
                        </svg>
                        Arsip Laporan
                    </a>

                    <a href="{{ url('/admin/arsip-berita') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold text-neutral hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8">
                            </path>
                        </svg>
                        Arsip Berita
                    </a>
                </nav>
            </div>

            <div class="border-t border-gray-200 p-4">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 px-4 py-3 rounded-xl text-sm font-bold transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>