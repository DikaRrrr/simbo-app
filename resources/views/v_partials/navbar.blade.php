<nav class="bg-secondary/90 backdrop-blur-md px-8 py-4 flex items-center justify-between sticky top-0 z-50 shadow-sm border-b border-white/10 transition-all duration-300">    
    <a href="{{ url('/') }}" class="flex items-center hover:opacity-90 transition-opacity">
        <img src="{{ asset('images/logo-white.png') }}" alt="Logo SIMBO" class="h-12 md:h-14 w-auto object-contain">
    </a>

    <div class="hidden md:flex items-center space-x-8 text-sm font-medium text-white/80">
        <a href="{{ url('/') }}" class="text-white font-bold relative after:content-[''] after:absolute after:-bottom-1.5 after:left-0 after:w-full after:h-[2px] after:bg-white after:rounded-full">
            Beranda
        </a>
        <a href="#" class="hover:text-white relative group transition-colors">
            Laporan
            <span class="absolute -bottom-1.5 left-0 w-0 h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="#" class="hover:text-white relative group transition-colors">
            Tentang Kami
            <span class="absolute -bottom-1.5 left-0 w-0 h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="#" class="hover:text-white relative group transition-colors">
            Berita
            <span class="absolute -bottom-1.5 left-0 w-0 h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="#" class="hover:text-white relative group transition-colors">
            Kontak
            <span class="absolute -bottom-1.5 left-0 w-0 h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-full"></span>
        </a>
    </div>

    <div class="flex items-center gap-4">
        
        @guest
            <a href="{{ url('/login') }}" class="hidden md:inline-block bg-neutral text-white font-bold text-sm px-8 py-2.5 rounded-full hover:scale-105 transition-all duration-300 shadow-md">
                Masuk
            </a>
        @endguest

        @auth
            <a href="#" class="hidden md:flex p-2 hover:bg-white/10 text-white rounded-full transition-all duration-300 relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-secondary rounded-full"></span>
            </a>

            <div class="relative group hidden md:block">
                <button class="flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold text-sm px-5 py-2 rounded-full transition-all duration-300 backdrop-blur-sm cursor-pointer">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                    <span class="truncate max-w-[120px]">{{ Auth::user()->nama_lengkap ?? 'Profil' }}</span>
                    <svg class="w-4 h-4 opacity-70 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right text-neutral">
                    <div class="p-2 space-y-1">
                        <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm font-semibold hover:bg-gray-100 rounded-xl transition-colors">
                            Profil Utama
                        </a>
                        
                        <div class="border-t border-gray-100 my-1"></div>

                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-50 rounded-xl transition-colors cursor-pointer">
                                Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endauth

        <button id="hamburger-btn" class="md:hidden text-white hover:text-white/80 transition-colors focus:outline-none p-1">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path id="hamburger-icon" class="block" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-secondary border-t border-white/10 shadow-xl flex-col px-8 py-6 space-y-4 md:hidden z-50 transition-all duration-300 animate-fadeIn">
        <a href="{{ url('/') }}" class="text-white font-bold text-base py-2 border-b border-white/5">Beranda</a>
        <a href="#" class="text-white/80 hover:text-white font-medium text-base py-2 border-b border-white/5">Laporan</a>
        <a href="#" class="text-white/80 hover:text-white font-medium text-base py-2 border-b border-white/5">Tentang Kami</a>
        <a href="#" class="text-white/80 hover:text-white font-medium text-base py-2 border-b border-white/5">Berita</a>
        <a href="#" class="text-white/80 hover:text-white font-medium text-base py-2 border-b border-white/5">Kontak</a>
        
        @guest
            <a href="{{ url('/login') }}" class="block w-full text-center bg-neutral text-white font-bold py-3 rounded-full shadow-md mt-4">
                Masuk
            </a>
        @endguest

        @auth
            <div class="border-t border-white/10 pt-4 mt-2">
                <div class="flex items-center gap-3 px-2 mb-4">
                    <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                    </div>
                    <div>
                        <p class="text-white font-bold text-sm">{{ Auth::user()->nama_lengkap ?? 'Pengguna' }}</p>
                        <a href="{{ url('/dashboard') }}" class="text-white/60 text-xs hover:text-white">Ke Profil Utama</a>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="block w-full text-center bg-red-500/20 text-red-100 border border-red-500/50 font-bold py-3 rounded-full shadow-md mt-2 hover:bg-red-500 hover:text-white transition-colors cursor-pointer">
                        Keluar Aplikasi
                    </button>
                </form>
            </div>
        @endauth
    </div>
</nav>