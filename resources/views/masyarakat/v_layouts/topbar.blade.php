<header class="h-20 bg-primary px-8 flex items-center justify-between border-b border-black/10 shadow-sm z-50">
    <h1 class="text-2xl font-bold text-white">
        @yield('page_title', 'Dashboard')
    </h1>

    <div class="relative" x-data="{ open: false }">

        <button @click="open = !open" @click.away="open = false"
            class="flex items-center gap-4 cursor-pointer hover:bg-gray-200/50 p-2 rounded-xl transition-all outline-none">

            <div class="text-right text-sm">
                <p class="font-semibold text-white">
                    Hai, {{ auth()->user()->nama_lengkap ?? 'Pengguna' }}
                </p>
                <p class="text-gray-300 text-xs">
                    {{ auth()->user()->email }}
                </p>
            </div>

            {{-- Container Foto Profil --}}
            <div
                class="w-10 h-10 rounded-full bg-white border-2 border-gray-300 flex items-center justify-center text-gray-500 shadow-sm overflow-hidden">
                @if (auth()->user()->foto_profile)
                    {{-- Jika ada foto di database --}}
                    <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}" alt="Foto Profil"
                        class="w-full h-full object-cover">
                @else
                    {{-- Jika foto belum ada, tampilkan ikon --}}
                    <i class="ph ph-user text-xl"></i>
                @endif
            </div>
        </button>

        <div x-show="open" x-cloak
            class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-200 rounded-xl shadow-2xl z-[9999] py-1">

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center gap-3 w-full px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 transition-colors">
                    <i class="ph ph-sign-out text-lg"></i>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</header>
