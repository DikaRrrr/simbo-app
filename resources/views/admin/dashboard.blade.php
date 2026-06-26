<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIMBO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-worksans text-dash-neutral bg-dash-secondary h-screen flex overflow-hidden">

    <aside class="w-64 bg-white border-r border-dash-tertiary flex flex-col justify-between hidden md:flex z-20 shadow-sm shrink-0">
        <div>
            <div class="h-20 flex items-center px-8 border-b border-dash-tertiary">
                <span class="font-montserrat text-2xl font-extrabold tracking-wide text-dash-primary">SIMBO Admin</span>
            </div>
            <nav class="p-4 space-y-2 mt-4">
                <a href="#" class="flex items-center gap-3 bg-dash-primary text-white font-medium px-4 py-3 rounded-xl shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 text-dash-neutral/70 hover:bg-dash-tertiary/40 hover:text-dash-primary font-medium px-4 py-3 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Data Masyarakat
                </a>
                <a href="#" class="flex items-center gap-3 text-dash-neutral/70 hover:bg-dash-tertiary/40 hover:text-dash-primary font-medium px-4 py-3 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Verifikasi Laporan
                </a>
            </nav>
        </div>
        <div class="p-6 border-t border-dash-tertiary">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-red-600 font-bold hover:underline">Keluar Admin</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-20 bg-white border-b border-dash-tertiary flex items-center justify-between px-8">
            <h1 class="text-xl font-bold font-montserrat">Halo, Admin {{ Auth::guard('admin')->user()->nama_admin }}</h1>
        </header>

        <div class="p-8 overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl border border-dash-tertiary shadow-sm">
                    <p class="text-dash-neutral/60 text-sm font-semibold">Total Laporan</p>
                    <h3 class="text-3xl font-bold font-montserrat mt-2">128</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-dash-tertiary shadow-sm">
                    <p class="text-dash-neutral/60 text-sm font-semibold">Menunggu Verifikasi</p>
                    <h3 class="text-3xl font-bold font-montserrat mt-2 text-accent">14</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-dash-tertiary shadow-sm">
                    <p class="text-dash-neutral/60 text-sm font-semibold">Selesai</p>
                    <h3 class="text-3xl font-bold font-montserrat mt-2 text-dash-primary">114</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-dash-tertiary p-6">
                <h3 class="font-bold font-montserrat mb-4">Laporan Terbaru</h3>
                <div class="w-full text-sm text-dash-neutral/60 text-center py-10">
                    Belum ada data laporan yang masuk.
                </div>
            </div>
        </div>
    </main>
</body>
</html>