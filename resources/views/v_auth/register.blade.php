<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIMBO</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-white.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-primary min-h-screen flex flex-col font-worksans text-neutral overflow-hidden">

    <div class="w-full px-8 pt-4 pb-0 shrink-0">
        <a href="{{ url('/') }}" class="flex items-center">
            <img src="{{ asset('images/logo-white.png') }}" alt="Logo SIMBO" class="h-20 w-auto object-contain">
        </a>
    </div>

    <div class="flex-grow flex items-center justify-center p-4 sm:p-6 min-h-0">
        
        <div class="bg-white rounded-[25px] p-5 sm:px-8 w-full max-w-[450px] shadow-xl flex flex-col justify-center">
            
            <div class="text-center mb-3">
                <h2 class="font-montserrat text-xl sm:text-2xl font-bold text-neutral">Daftar Akun Baru</h2>
            </div>

            <form action="{{ url('/register') }}" method="POST" class="space-y-2">
                @csrf
                
                <div>
                    <label for="nik" class="block text-[11px] font-semibold mb-0.5 ml-1 text-neutral">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" id="nik" name="nik" class="w-full bg-[#F3F4F6] border border-transparent rounded-xl px-4 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors text-neutral text-sm" required>
                </div>

                <div>
                    <label for="nama" class="block text-[11px] font-semibold mb-0.5 ml-1 text-neutral">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="w-full bg-[#F3F4F6] border border-transparent rounded-xl px-4 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors text-neutral text-sm" required>
                </div>

                <div>
                    <label for="email" class="block text-[11px] font-semibold mb-0.5 ml-1 text-neutral">Email</label>
                    <input type="email" id="email" name="email" class="w-full bg-[#F3F4F6] border border-transparent rounded-xl px-4 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors text-neutral text-sm" required>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="nohp" class="block text-[11px] font-semibold mb-0.5 ml-1 text-neutral">No. HP</label>
                        <input type="tel" id="nohp" name="nohp" class="w-full bg-[#F3F4F6] border border-transparent rounded-xl px-4 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors text-neutral text-sm" required>
                    </div>

                    <div>
                        <label for="password" class="block text-[11px] font-semibold mb-0.5 ml-1 text-neutral">Password</label>
                        <input type="password" id="password" name="password" class="w-full bg-[#F3F4F6] border border-transparent rounded-xl px-4 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors text-neutral text-sm" required>
                    </div>
                </div>

                <div>
                    <label for="alamat" class="block text-[11px] font-semibold mb-0.5 ml-1 text-neutral">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="2" class="w-full bg-[#F3F4F6] border border-transparent rounded-xl px-4 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors text-neutral resize-none text-sm" required></textarea>
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full bg-neutral text-white font-montserrat font-bold text-sm rounded-xl py-2.5 hover:bg-opacity-90 hover:-translate-y-0.5 transition-all shadow-md">
                        Daftar Sekarang
                    </button>
                </div>

                <div class="text-center pt-2">
                    <p class="text-xs text-neutral/70">Sudah punya akun? <a href="{{ url('/login') }}" class="font-bold text-primary hover:underline">Masuk di sini</a></p>
                </div>

            </form>
            
        </div>
    </div>

</body>
</html>