<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Petugas') - SIMBO</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-inputBg min-h-screen flex font-worksans text-neutral">

    <aside class="w-64 bg-primary text-white flex flex-col justify-between hidden md:flex shadow-xl shrink-0">
        <div>
            <div class="h-20 flex items-center px-8 border-b border-white/10">
                <span class="font-montserrat text-2xl font-extrabold tracking-wide">SIMBO</span>
            </div>

            <nav class="p-4 space-y-2 mt-4">
                <a href="{{ route('petugas.dashboard') }}"
                    class="flex items-center gap-3 font-medium px-4 py-3 rounded-xl transition-all {{ request()->routeIs('petugas.dashboard') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('petugas.laporan.index') }}"
                    class="flex items-center gap-3 font-medium px-4 py-3 rounded-xl transition-all {{ request()->routeIs('petugas.laporan.*') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Daftar Laporan
                </a>

                <a href="{{ route('petugas.berita.index') }}"
                    class="flex items-center gap-3 font-medium px-4 py-3 rounded-xl transition-all {{ request()->routeIs('petugas.berita.*') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 4v6h6M8 13h8M8 17h5"></path>
                    </svg>
                    Mengelola Berita
                </a>
            </nav>
        </div>

        <div class="p-6 border-t border-white/10">
            <form action="{{ route('petugas.logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-white/60 hover:text-white font-bold text-sm">Keluar Petugas</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-20 bg-white border-b border-tertiary flex items-center justify-between px-8 shrink-0">
            <h1 class="text-xl font-bold font-montserrat text-neutral">@yield('page_title', 'Halo, ' . (Auth::guard('petugas')->user()->nama_petugas ?? 'Petugas'))</h1>
            @yield('header_action')
        </header>

        <div class="p-8 overflow-y-auto">
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800">
                    <p class="font-bold mb-2">Ada data yang perlu diperbaiki:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>