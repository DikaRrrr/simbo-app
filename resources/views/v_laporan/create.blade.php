<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan - SIMBO</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-worksans text-neutral bg-formBG h-screen flex overflow-hidden">

    <aside class="w-64 bg-white border-r border-tertiary flex flex-col justify-between hidden md:flex z-20 shadow-sm shrink-0">
        <div>
            <div class="h-20 flex items-center px-8 border-b border-tertiary">
                <a href="{{ url('/') }}" class="flex items-center gap-3 font-montserrat text-2xl font-extrabold tracking-wide text-primary">
                    SIMBO
                </a>
            </div>

            <nav class="p-4 space-y-2 mt-4">
                <a href="#" class="flex items-center gap-3 bg-primary text-white font-medium px-4 py-3 rounded-xl transition-colors shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Laporan Masalah
                </a>
                
                <a href="#" class="flex items-center gap-3 text-neutral/70 hover:bg-tertiary/40 hover:text-primary font-medium px-4 py-3 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan Saya
                </a>
                
                <a href="#" class="flex items-center gap-3 text-neutral/70 hover:bg-tertiary/40 hover:text-primary font-medium px-4 py-3 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Statistik
                </a>
            </nav>
        </div>

        <div class="p-6">
            <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 text-neutral/60 hover:text-primary font-semibold px-4 py-2 bg-tertiary/40 rounded-lg hover:bg-tertiary transition-colors w-max">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <header class="h-20 bg-white border-b border-tertiary flex items-center justify-between px-8 z-10 shadow-sm shrink-0">
            <h1 class="font-montserrat text-xl md:text-2xl font-bold text-neutral">
                Buat Laporan Masalah
            </h1>
            
            <div class="flex items-center gap-3 cursor-pointer hover:opacity-80 transition-opacity">
                <span class="font-worksans font-semibold text-sm hidden sm:block">
                    Hi, {{ Auth::user()->nama_lengkap ?? 'Pengguna' }}
                </span>
                <div class="w-10 h-10 bg-tertiary rounded-full flex items-center justify-center text-primary border-2 border-primary/20">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-6 md:p-8 lg:p-12">
            <div class="max-w-5xl mx-auto">
                
                <div class="flex justify-center items-center mb-12">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-montserrat font-bold text-lg shadow-md">1</div>
                        <span class="font-montserrat font-bold text-primary text-xs mt-2">Detail</span>
                    </div>
                    <div class="w-16 sm:w-24 h-[2px] bg-tertiary mb-6 mx-2 sm:mx-4"></div>
                    
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-tertiary text-neutral/50 flex items-center justify-center font-montserrat font-bold text-lg">2</div>
                        <span class="font-montserrat font-bold text-neutral/50 text-xs mt-2">Lokasi</span>
                    </div>
                    <div class="w-16 sm:w-24 h-[2px] bg-tertiary mb-6 mx-2 sm:mx-4"></div>

                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-tertiary text-neutral/50 flex items-center justify-center font-montserrat font-bold text-lg">3</div>
                        <span class="font-montserrat font-bold text-neutral/50 text-xs mt-2">Tinjauan</span>
                    </div>
                </div>

                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                        
                        <div class="lg:col-span-2 bg-white rounded-3xl p-8 border border-tertiary shadow-sm">
                            <h2 class="font-montserrat text-xl font-bold text-neutral mb-8">Deskripsi Masalah</h2>
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="judul" class="block font-montserrat font-semibold text-sm text-neutral mb-2">Judul laporan</label>
                                    <input type="text" id="judul" name="judul" required placeholder="Contoh : Jalan rusak di depan Taman Heulang" class="w-full bg-inputBG border border-tertiary text-neutral text-sm rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent transition-all placeholder-neutral/40">
                                </div>

                                <div>
                                    <label for="kategori" class="block font-montserrat font-semibold text-sm text-neutral mb-2">Kategori</label>
                                    <div class="relative">
                                        <select id="kategori" name="kategori" required class="w-full bg-inputBG border border-tertiary text-neutral text-sm rounded-xl px-4 py-3.5 appearance-none focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent transition-all">
                                            <option value="" disabled selected>Pilih Kategori...</option>
                                            <option value="infrastruktur">Infrastruktur</option>
                                            <option value="fasilitas">Fasilitas Umum</option>
                                            <option value="kebersihan">Kebersihan</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-neutral/60">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="deskripsi" class="block font-montserrat font-semibold text-sm text-neutral mb-2">Deskripsi Detail</label>
                                    <textarea id="deskripsi" name="deskripsi" required rows="6" placeholder="Mohon berikan detail spesifik tentang masalah tersebut..." class="w-full bg-inputBG border border-tertiary text-neutral text-sm rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent transition-all placeholder-neutral/40 resize-none"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-1 flex flex-col gap-6 lg:gap-8">
                            
                            <div class="bg-white rounded-3xl p-6 border border-tertiary shadow-sm">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="font-montserrat text-base font-bold text-neutral">Bukti Foto</h3>
                                    <svg class="w-5 h-5 text-neutral/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                
                                <input type="file" id="foto" name="foto" accept="image/*" required class="hidden">
                                <label for="foto" class="border-2 border-dashed border-tertiary hover:border-accent hover:bg-accent/5 bg-inputBG rounded-2xl flex flex-col items-center justify-center text-center p-8 cursor-pointer transition-colors aspect-square lg:aspect-auto lg:h-[220px]">
                                    <svg class="w-8 h-8 text-neutral/40 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    <p class="font-worksans text-sm font-semibold text-neutral">Klik untuk upload foto</p>
                                    <p class="font-worksans text-xs text-neutral/50 mt-1">Mendukung JPG, PNG<br>(Maks. 5MB)</p>
                                </label>
                            </div>

                            <div class="bg-formBG border border-tertiary rounded-3xl p-6">
                                <ul class="space-y-5">
                                    <li class="flex items-start gap-4">
                                        <div class="mt-0.5 text-primary">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"></path></svg>
                                        </div>
                                        <div>
                                            <h4 class="font-montserrat font-bold text-sm text-neutral">Data Terlindungi</h4>
                                            <p class="font-worksans text-xs text-neutral/70 mt-1 leading-relaxed">Informasi pribadi Anda akan dijaga kerahasiaannya.</p>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-4">
                                        <div class="mt-0.5 text-primary">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                        </div>
                                        <div>
                                            <h4 class="font-montserrat font-bold text-sm text-neutral">Verifikasi Cepat</h4>
                                            <p class="font-worksans text-xs text-neutral/70 mt-1 leading-relaxed">Verifikasi dalam kurun waktu 24 jam.</p>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-4">
                                    <div class="mt-0.5 text-primary">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l-7 13h4l-5 7h6v-3h2v3h6l-5-7h4z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-montserrat font-bold text-sm text-neutral">Bogor Bersih</h4>
                                        <p class="font-worksans text-xs text-neutral/70 mt-1 leading-relaxed">Kontribusi Anda sangat berharga untuk mewujudkan lingkungan Rain City yang asri.</p>
                                    </div>
                                </li>
                                </ul>
                            </div>

                        </div>
                    </div> <div class="mt-8 flex justify-end pb-8">
                        <button type="submit" class="bg-primary text-white font-montserrat font-bold text-sm px-8 py-3.5 rounded-full hover:bg-[#112A20] hover:shadow-lg transition-all flex items-center gap-3">
                            Lanjut ke Lokasi
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                </form> </div>
        </div>
    </main>

</body>
</html>