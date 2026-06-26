<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas - SIMBO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-inputBg min-h-screen flex font-worksans">

    <aside class="w-64 bg-primary text-white flex flex-col justify-between hidden md:flex shadow-xl">
        <div>
            <div class="h-20 flex items-center px-8 border-b border-primary/30">
                <span class="font-montserrat text-2xl font-extrabold tracking-wide">SIMBO</span>
            </div>
            <nav class="p-4 space-y-2 mt-4">
                <a href="#" class="flex items-center gap-3 bg-white/10 text-white font-medium px-4 py-3 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 text-white/70 hover:bg-white/5 hover:text-white font-medium px-4 py-3 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Daftar Laporan
                </a>
            </nav>
        </div>
        <div class="p-6 border-t border-primary/30">
            <form action="{{ route('petugas.logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-white/60 hover:text-white font-bold text-sm">Keluar Petugas</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-20 bg-white border-b border-tertiary flex items-center justify-between px-8">
            <h1 class="text-xl font-bold font-montserrat text-neutral">Halo, {{ Auth::guard('petugas')->user()->nama_petugas ?? 'Petugas' }}</h1>
        </header>

        <div class="p-8 overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl border border-tertiary shadow-sm">
                    <p class="text-neutral/60 text-xs font-semibold uppercase tracking-wider">Total Laporan Masuk</p>
                    <h3 class="text-3xl font-bold font-montserrat mt-2 text-primary">45</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-tertiary shadow-sm">
                    <p class="text-neutral/60 text-xs font-semibold uppercase tracking-wider">Diproses</p>
                    <h3 class="text-3xl font-bold font-montserrat mt-2 text-secondary">12</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-tertiary shadow-sm">
                    <p class="text-neutral/60 text-xs font-semibold uppercase tracking-wider">Selesai</p>
                    <h3 class="text-3xl font-bold font-montserrat mt-2 text-primary">33</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-tertiary overflow-hidden">
                <div class="p-6 border-b border-tertiary flex justify-between items-center">
                    <h3 class="font-bold font-montserrat">Laporan Terbaru</h3>
                    <a href="#" class="text-sm font-semibold text-primary hover:underline">Lihat Semua</a>
                </div>
                <table class="w-full text-sm text-left">
                    <thead class="bg-inputBg text-neutral/70 font-semibold uppercase text-xs">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Masyarakat</th>
                            <th class="px-6 py-4">Laporan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-tertiary">
                        <tr>
                            <td class="px-6 py-4 font-mono font-bold">#001</td>
                            <td class="px-6 py-4 font-semibold">Budi Santoso</td>
                            <td class="px-6 py-4 text-neutral/70">Jalan rusak di depan...</td>
                            <td class="px-6 py-4">
                                <span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-3 py-1 rounded-full uppercase">Pending</span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="text-primary font-bold hover:underline">Tanggapi</a>
                            </td>
                        </tr>
                        </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>