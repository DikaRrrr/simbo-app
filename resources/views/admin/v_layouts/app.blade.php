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
            class="fixed top-0 left-[250px] right-0 h-16 bg-white border-b border-gray-200 z-40 flex items-center justify-between px-8 shadow-sm"
            x-data="{ openNotif: false }">

            {{-- Kiri: Breadcrumb --}}
            <div class="flex items-center gap-2 text-sm">
                <span class="text-gray-400 font-medium">SIMBO</span>
                <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="font-bold text-neutral">@yield('pageTitle', 'Dashboard')</span>
            </div>

            {{-- Kanan: Notifikasi + Profil --}}
            <div class="flex items-center gap-3">

                {{-- ── Tombol Notifikasi ──────────────────────────────── --}}
                <div class="relative">

                    {{-- Trigger Button --}}
                    <button @click="openNotif = !openNotif"
                        class="relative w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-gray-50 hover:bg-gray-100 text-gray-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>

                        {{-- Badge count --}}
                        @if ($jumlahNotif > 0)
                            <span
                                class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 bg-red-500 text-white text-[10px] font-extrabold rounded-full flex items-center justify-center border-2 border-white leading-none">
                                {{ $jumlahNotif > 9 ? '9+' : $jumlahNotif }}
                            </span>
                        @endif
                    </button>

                    {{-- Dropdown Panel --}}
                    <div x-show="openNotif" x-cloak @click.outside="openNotif = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                        class="absolute right-0 top-11 w-80 bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden z-50 origin-top-right">

                        {{-- Header Dropdown --}}
                        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 bg-gray-50">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-bold text-neutral">Notifikasi</p>
                                @if ($jumlahNotif > 0)
                                    <span
                                        class="px-2 py-0.5 text-[10px] font-bold bg-red-100 text-red-600 rounded-full">
                                        {{ $jumlahNotif }} baru
                                    </span>
                                @endif
                            </div>
                            <a href="{{ url('/admin/identifikasi') }}"
                                class="text-[11px] font-bold text-primary hover:underline">
                                Lihat Semua
                            </a>
                        </div>

                        {{-- List Notifikasi --}}
                        <div class="divide-y divide-gray-50 max-h-72 overflow-y-auto">
                            @forelse ($notifikasi as $notif)
                                <a href="{{ $notif['url'] }}" @click="openNotif = false"
                                    class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">

                                    {{-- Ikon status --}}
                                    <div
                                        class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 mt-0.5
                                {{ $notif['status'] === 'Menunggu' ? 'bg-red-100 text-red-500' : 'bg-blue-100 text-blue-500' }}">
                                        @if ($notif['status'] === 'Menunggu')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                    </div>

                                    {{-- Konten --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between gap-2 mb-0.5">
                                            <span class="text-[10px] font-mono font-bold text-gray-400">
                                                {{ $notif['tiket'] }}
                                            </span>
                                            <span class="text-[10px] text-gray-400 shrink-0">
                                                {{ $notif['waktu'] }}
                                            </span>
                                        </div>
                                        <p class="text-xs font-semibold text-neutral truncate">
                                            {{ $notif['judul'] }}
                                        </p>
                                        <span
                                            class="inline-block mt-1 text-[10px] font-bold px-2 py-0.5 rounded-full
                                    {{ $notif['status'] === 'Menunggu' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }}">
                                            {{ $notif['status'] }}
                                        </span>
                                    </div>
                                </a>
                            @empty
                                <div class="px-4 py-8 text-center">
                                    <svg class="w-8 h-8 text-gray-200 mx-auto mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-xs font-semibold text-gray-400">Semua laporan sudah ditangani</p>
                                </div>
                            @endforelse
                        </div>

                        {{-- Footer --}}
                        @if ($jumlahNotif > 0)
                            <div class="px-4 py-3 bg-gray-50 border-t border-gray-100">
                                <a href="{{ url('/admin/identifikasi') }}"
                                    class="block w-full text-center text-xs font-bold text-white bg-primary hover:bg-primary/90 rounded-xl py-2 transition-colors">
                                    Proses {{ $jumlahNotif }} Laporan Menunggu
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
                {{-- ── End Notifikasi ─────────────────────────────────── --}}

                <div class="w-px h-6 bg-gray-200"></div>

                {{-- Profil Admin --}}
                <div class="flex items-center gap-3 pl-1">
                    <div
                        class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-xs font-extrabold shadow-sm uppercase">
                        {{ substr(Auth::guard('admin')->user()->nama_admin ?? 'AD', 0, 2) }}
                    </div>
                    <div class="hidden md:block">
                        <p class="text-xs font-bold text-neutral leading-tight">
                            {{ Auth::guard('admin')->user()->nama_admin ?? 'Administrator' }}
                        </p>
                        <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wide">Admin</p>
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

                    <a href="{{ route('admin.kategori.index') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-colors
                        {{ request()->is('admin/kategori*') ? 'bg-primary text-white shadow-md' : 'text-neutral hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/kategori*') ? 'text-white' : 'text-gray-500' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        Kelola Kategori
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

                    <a href="{{ route('admin.notifikasi.index') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-colors
    {{ request()->is('admin/notifikasi*') ? 'bg-primary text-white shadow-md' : 'text-neutral hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/notifikasi*') ? 'text-white' : 'text-gray-500' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        Kelola Notifikasi
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
