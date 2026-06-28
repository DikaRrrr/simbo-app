<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Petugas - SIMBO</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-gold.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-primary min-h-screen flex flex-col font-worksans text-neutral">
    <div class="w-full px-8 pt-8 pb-2">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo-white.png') }}" alt="Logo SIMBO" class="h-20 w-auto object-contain">
        </a>
    </div>

    <div class="flex-grow flex items-center justify-center p-4">
        <div class="bg-white rounded-[25px] p-8 w-full max-w-[500px] shadow-xl">
            <div class="text-center mb-6">
                <h2 class="font-montserrat text-2xl font-bold text-neutral">Login Petugas</h2>
                <h3 class="font-montserrat text-xl font-bold text-neutral uppercase tracking-widest mt-1">Simbo</h3>
            </div>

            <form action="{{ route('petugas.login') }}" method="POST" class="space-y-4">
                @csrf
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl text-sm">{{ $errors->first() }}</div>
                @endif
                <div>
                    <label class="block text-xs font-semibold mb-1 ml-1">Email</label>
                    <input type="email" name="email" class="w-full bg-inputBg rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1 ml-1">Password</label>
                    <input type="password" name="password" class="w-full bg-inputBg rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none text-sm" required>
                </div>
                <button type="submit" class="w-full bg-primary text-white font-bold text-sm rounded-xl py-3 mt-4 hover:opacity-90 transition-all">
                    Masuk Petugas
                </button>
            </form>
        </div>
    </div>
</body>
</html>