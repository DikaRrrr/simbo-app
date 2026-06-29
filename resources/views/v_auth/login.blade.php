<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMBO</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-white.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-primary min-h-screen flex flex-col font-worksans text-neutral">

    <div class="w-full px-8 pt-8 pb-2">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SIMBO" class="h-20 w-auto object-contain">
        </a>
    </div>

    <div class="flex-grow flex items-center justify-center p-4 sm:p-6">

        <div class="bg-white rounded-[25px] p-6 sm:px-10 sm:py-8 w-full max-w-[500px] shadow-xl">

            <div class="text-center mb-6">
                <h2 class="font-montserrat text-2xl font-bold text-neutral">Masuk</h2>
                <h3 class="font-montserrat text-2xl font-bold text-neutral uppercase">Simbo</h3>
            </div>

            <form action="{{ url('/login') }}" method="POST" class="space-y-4">
                @csrf
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl text-sm mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @error('email')
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl text-sm mb-4">
                        {{ $message }}
                    </div>
                @enderror

                <div>
                    <label for="email" class="block text-xs font-semibold mb-1 ml-1 text-neutral">Email</label>
                    <input type="email" id="email" name="email"
                        class="w-full bg-inputBg rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary transition-colors text-neutral text-sm"
                        required>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold mb-1 ml-1 text-neutral">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full bg-inputBg rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary transition-colors text-neutral text-sm"
                        required>
                </div>

                <div class="flex justify-end">
                    <a href="#" class="text-xs font-bold text-neutral hover:underline mt-1 mr-1">Lupa
                        Password?</a>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-neutral text-white font-worksans font-medium text-sm rounded-xl py-2.5 hover:bg-opacity-90 hover:scale-105 transition-all duration-300">
                        Masuk
                    </button>
                </div>
            </form>

            <div class="text-center mt-6 text-sm">
                <span class="text-neutral/70">Belum punya akun?</span>
                <a href="{{ url('/register') }}"
                    class="font-bold text-neutral hover:text-primary hover:underline transition-colors">Daftar di
                    sini.</a>
            </div>

        </div>
    </div>

</body>

</html>
