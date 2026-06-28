<aside
    class="transition-width duration-300 bg-primary flex flex-col py-3 shadow-xl z-20 flex-shrink-0 sidebar-expanded w-64 items-start h-full"
    id="sidebar">

    {{-- Logo --}}
    <div
        class="w-full px-3 mb-3 flex items-center justify-start sidebar-header transition-all overflow-hidden h-16 flex-shrink-0">
        <div class="w-full h-full flex items-center justify-center p-2">
            <img src="{{ asset('images/logo-white.png') }}" alt="SIMBO Logo"
                class="h-full w-auto object-contain transition-all duration-300">
        </div>
    </div>

    {{-- Toggle --}}
    <div class="w-full px-3 mb-2 flex-shrink-0">
        <div class="flex items-center justify-start w-full cursor-pointer hover:bg-white/10 p-2 rounded-xl transition-colors"
            id="sidebarToggle">
            <div class="w-10 h-10 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-white text-2xl" id="toggleIcon">menu_open</span>
            </div>
            <span class="sidebar-text text-tertiary font-bold text-lg">Menu Utama</span>
        </div>
    </div>

    {{-- Nav Links --}}
    <nav class="flex-1 w-full flex flex-col gap-1 px-3 overflow-hidden">

        @php
            // Definisi kelas untuk mempermudah maintenance
            $activeClass = 'text-white bg-white/20 shadow-inner';
            $inactiveClass = 'text-tertiary hover:text-white hover:bg-white/10';
        @endphp

        {{-- Beranda --}}
        <a class="w-full flex items-center justify-start p-2 rounded-xl sidebar-link transition-colors {{ request()->routeIs('masyarakat.beranda') ? $activeClass : $inactiveClass }}"
            href="{{ route('masyarakat.beranda') }}">
            <div
                class="w-10 h-10 rounded-full {{ request()->routeIs('masyarakat.beranda') ? 'bg-neutral/50' : '' }} flex items-center justify-center flex-shrink-0">
                <i class="ph-fill ph-house text-2xl"></i>
            </div>
            <span class="sidebar-text text-sm font-medium">Beranda</span>
        </a>

        {{-- Laporan (Menggunakan wildcard .* agar sub-halaman tetap aktif) --}}
        <a class="w-full flex items-center justify-start p-2 rounded-xl sidebar-link transition-colors {{ request()->routeIs('laporan.*') ? $activeClass : $inactiveClass }}"
            href="{{ route('laporan.index') }}">
            <div class="w-10 h-10 flex items-center justify-center flex-shrink-0">
                <i class="ph ph-file-text text-2xl"></i>
            </div>
            <span class="sidebar-text text-sm font-medium">Laporan</span>
        </a>

        {{-- Aktivitas --}}
        <a class="w-full flex items-center justify-start p-2 rounded-xl sidebar-link transition-colors {{ request()->routeIs('aktivitas.*') ? $activeClass : $inactiveClass }}"
            href="{{ route('aktivitas.index') }}">
            <div class="w-10 h-10 flex items-center justify-center flex-shrink-0">
                <i class="ph ph-squares-four text-2xl"></i>
            </div>
            <span class="sidebar-text text-sm font-medium">Aktivitas</span>
        </a>

        {{-- Berita --}}
        <a class="w-full flex items-center justify-start p-2 rounded-xl sidebar-link transition-colors {{ request()->routeIs('berita.*') ? $activeClass : $inactiveClass }}"
            href="{{ route('berita.index') }}">
            <div class="w-10 h-10 flex items-center justify-center flex-shrink-0">
                <i class="ph ph-archive text-2xl"></i>
            </div>
            <span class="sidebar-text text-sm font-medium">Berita</span>
        </a>

        <div class="w-full h-px bg-white/10 my-2 sidebar-divider flex-shrink-0"></div>

        {{-- Notifikasi --}}
        <a class="w-full flex items-center justify-start p-2 rounded-xl sidebar-link transition-colors {{ request()->routeIs('notifikasi.*') ? $activeClass : $inactiveClass }}"
            href="{{ route('notifikasi.index') }}">
            <div class="w-10 h-10 flex items-center justify-center flex-shrink-0">
                <i class="ph ph-bell text-2xl"></i>
            </div>
            <span class="sidebar-text text-sm font-medium">Notifikasi</span>
        </a>

    </nav>

    {{-- User Profile --}}
    <div class="mt-auto w-full px-3 pt-3 pb-1 border-t border-white/10 flex-shrink-0 overflow-hidden">
        <a href="{{ route('profile.index') }}"
            class="w-full flex items-center justify-start p-2 rounded-xl sidebar-link transition-colors hover:bg-white/10 {{ request()->routeIs('profile.index') ? 'bg-white/10' : '' }}">
            <div class="w-10 h-10 flex items-center justify-center flex-shrink-0">
                <i class="ph ph-user-circle text-4xl text-white"></i>
            </div>
            <div class="sidebar-text flex flex-col justify-center">
                <span class="text-sm font-bold text-white truncate max-w-[140px]">
                    {{ auth()->user()->nama_lengkap ?? 'Nama Pengguna' }}
                </span>
                <span class="text-[10px] text-tertiary truncate max-w-[140px]">
                    {{ auth()->user()->email ?? 'pengguna@email.com' }}
                </span>
            </div>
        </a>
    </div>

</aside>
