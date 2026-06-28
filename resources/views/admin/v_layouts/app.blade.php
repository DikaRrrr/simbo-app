<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIMBO</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-green.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-montserrat bg-dash-secondary text-neutral">

    <div class="flex min-h-screen">

        {{-- TOP NAVBAR --}}
        <header
            class="fixed top-0 left-[250px] right-0 h-16 bg-white border-b border-gray-200 z-40 flex items-center justify-between px-8 shadow-sm">

            {{-- Kiri: Breadcrumb / Judul Halaman --}}
            <div class="flex items-center gap-2 text-sm">
                <span class="text-gray-400 font-medium">SIMBO</span>
                <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="font-bold text-neutral">
                    {{ $pageTitle ?? 'Dashboard' }}
                </span>
            </div>

            {{-- Kanan: Notifikasi + Profil Admin --}}
            <div class="flex items-center gap-3">

                {{-- Tombol Notifikasi --}}
                <button
                    class="relative w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-gray-50 hover:bg-gray-100 text-gray-500 transition-colors">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                    {{-- Badge notifikasi --}}
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                </button>

                {{-- Divider --}}
                <div class="w-px h-6 bg-gray-200"></div>

                {{-- Profil Admin --}}
                <div class="flex items-center gap-3 pl-1 cursor-pointer group">
                    {{-- Avatar --}}
                    <div
                        class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-xs font-extrabold shadow-sm">
                        {{ substr(Auth::guard('admin')->user()->nama_admin ?? 'AD', 0, 2) }}
                    </div>
                    {{-- Nama & Role --}}
                    <div class="hidden md:block">
                        <p class="text-xs font-bold text-neutral leading-tight">
                            {{ Auth::guard('admin')->user()->nama_admin ?? 'Administrator' }}
                        </p>
                        <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wide">
                            Admin
                        </p>
                    </div>
                    {{-- Chevron --}}
                    <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-primary transition-colors hidden md:block"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </div>

            </div>
        </header>

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
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-colors
        {{ request()->is('admin/dashboard') ? 'bg-primary text-white shadow-md' : 'text-neutral hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/dashboard') ? 'text-white' : 'text-gray-500' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ url('/admin/identifikasi') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-colors
        {{ request()->is('admin/identifikasi*') ? 'bg-primary text-white shadow-md' : 'text-neutral hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/identifikasi*') ? 'text-white' : 'text-gray-500' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                        Identifikasi Laporan
                    </a>

                    <a href="{{ url('/admin/pengguna') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-colors
        {{ request()->is('admin/pengguna*') ? 'bg-primary text-white shadow-md' : 'text-neutral hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/pengguna*') ? 'text-white' : 'text-gray-500' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Manajemen Pengguna
                    </a>

                    <a href="{{ url('/admin/arsip-laporan') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-colors
        {{ request()->is('admin/arsip-laporan*') ? 'bg-primary text-white shadow-md' : 'text-neutral hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/arsip-laporan*') ? 'text-white' : 'text-gray-500' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                            </path>
                        </svg>
                        Arsip Laporan
                    </a>

                    <a href="{{ route('admin.berita.index') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-colors
        {{ request()->is('admin/berita*') ? 'bg-primary text-white shadow-md' : 'text-neutral hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/berita*') ? 'text-white' : 'text-gray-500' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8">
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

        <script>
            // Flash message dari session Laravel
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#142C14',
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#EF4444',
                });
            @endif
        </script>
