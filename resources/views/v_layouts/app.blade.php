<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMBO - Sistem Informasi Masalah Bogor')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-worksans text-white bg-primary min-h-screen flex flex-col">

    @include('v_partials.navbar')

    @yield('content')

    @include('v_partials.footer')

    {{-- Script Hamburger Menu --}}
    <script>
        const hamburgerBtn  = document.getElementById('hamburger-btn');
        const mobileMenu    = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon     = document.getElementById('close-icon');

        if (hamburgerBtn) {
            hamburgerBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                mobileMenu.classList.toggle('flex');
                hamburgerIcon.classList.toggle('hidden');
                hamburgerIcon.classList.toggle('block');
                closeIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('block');
            });
        }
    </script>

    @stack('scripts')

</body>

</html>