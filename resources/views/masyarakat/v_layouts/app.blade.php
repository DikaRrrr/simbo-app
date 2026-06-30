<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'SIMBO - Sistem Manajemen Bogor')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-white.png') }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">


    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .sidebar-text {
            transition: opacity 0.3s ease, width 0.3s ease;
            opacity: 0;
            width: 0;
            overflow: hidden;
            white-space: nowrap;
        }

        .sidebar-expanded .sidebar-text {
            opacity: 1;
            width: auto;
            margin-left: 12px;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-white text-neutral font-sans antialiased flex h-screen overflow-hidden relative">

    @include('masyarakat.v_layouts.sidebar')

    <main class="flex-1 flex flex-col overflow-hidden bg-white relative">
        @include('masyarakat.v_layouts.topbar')

        <div class="flex-1 overflow-y-auto">
            <div class="p-8 min-h-[calc(100vh-140px)] flex flex-col">
                <div class="flex-grow">
                    @yield('content')
                </div>

                <footer class="mt-8 py-3 px-8 border-t border-gray-100">
                    <p class="text-[9px] text-neutral/40 font-bold uppercase tracking-widest text-center">
                        &copy;Copyright {{ date('Y') }} SIMBO - Sistem Informasi Pengaduan Masyarakat Bogor 2026 BGR. All rights reserved and registered under the law
                    </p>
                </footer>
            </div>
        </div>
    </main>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const toggleIcon = document.getElementById('toggleIcon');
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    const sidebarDivider = document.querySelector('.sidebar-divider');
    const sidebarHeader = document.querySelector('.sidebar-header');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('sidebar-expanded');

        if (sidebar.classList.contains('sidebar-expanded')) {
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64');
            sidebar.classList.remove('items-center');
            sidebar.classList.add('items-start');

            toggleIcon.textContent = 'menu_open';
            sidebarToggle.classList.remove('justify-center');
            sidebarToggle.classList.add('justify-start');
            if (sidebarHeader) {
                sidebarHeader.classList.remove('justify-center');
                sidebarHeader.classList.add('justify-start');
            }

            sidebarLinks.forEach(link => {
                link.classList.remove('justify-center');
                link.classList.add('justify-start');
            });
            sidebarDivider.classList.remove('w-8');
            sidebarDivider.classList.add('w-full');
        } else {
            sidebar.classList.add('w-20');
            sidebar.classList.remove('w-64');
            sidebar.classList.add('items-center');
            sidebar.classList.remove('items-start');

            toggleIcon.textContent = 'menu';
            sidebarToggle.classList.add('justify-center');
            sidebarToggle.classList.remove('justify-start');
            if (sidebarHeader) {
                sidebarHeader.classList.add('justify-center');
                sidebarHeader.classList.remove('justify-start');
            }

            sidebarLinks.forEach(link => {
                link.classList.add('justify-center');
                link.classList.remove('justify-start');
            });
            sidebarDivider.classList.add('w-8');
            sidebarDivider.classList.remove('w-full');
        }
    });
</script>

<script>
    // Flash message dari session Laravel
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#142C14',
            timer: 3000,
            timerProgressBar: true,
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#EF4444',
        });
    @endif
</script>

@stack('scripts')
</body>

</html>
