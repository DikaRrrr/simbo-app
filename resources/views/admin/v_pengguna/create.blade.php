  @extends('admin.v_layouts.app')

 @section('title', 'Manajemen Pengguna - Admin SIMBO')
 
 <!-- Content -->
        <main class="px-6 py-6">

            <!-- Back Link -->
            <a href="#" class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-wider text-neutral hover:text-primary">
                ← Kembali Manajemen Pengguna
            </a>

            <!-- Page Title -->
            <div class="mt-3">
                <h2 class="font-montserrat text-2xl font-extrabold tracking-wide">
                    Tambah Pengguna Baru
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Daftarkan pengguna baru ke dalam sistem SIMBO.
                </p>
            </div>

            <!-- Layout Form + Help -->
            <div class="grid grid-cols-1 lg:grid-cols-[1fr_280px] gap-8 mt-6 max-w-5xl">

                <!-- Form Card -->
                <div class="bg-white border border-tertiary/70 border-t-4 border-t-primary shadow-sm">

                    <form action="#" method="POST" class="p-7">
                        @csrf

                        <!-- Peran & Akses -->
                        <section>
                            <h3 class="font-montserrat text-base font-bold">
                                Peran & Akses
                            </h3>

                            <div class="border-t border-tertiary/70 mt-4 pt-5">
                                <label class="block text-xs font-bold mb-3">
                                    Pilih Peran Pengguna
                                </label>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

                                    <!-- Administrator -->
                                    <label class="cursor-pointer">
                                        <input 
                                            type="radio" 
                                            name="role" 
                                            value="admin" 
                                            class="peer hidden"
                                        >

                                        <div class="h-[66px] border border-tertiary rounded-sm bg-white px-4 py-3 
                                                    peer-checked:border-primary 
                                                    peer-checked:bg-primary/5 
                                                    hover:border-primary transition">
                                            <div class="flex items-start gap-3">
                                                <span class="mt-1 w-3 h-3 rounded-full border border-gray-500 flex items-center justify-center">
                                                    <span class="hidden peer-checked:block w-1.5 h-1.5 rounded-full bg-primary"></span>
                                                </span>

                                                <div>
                                                    <p class="text-xs font-bold text-neutral">
                                                        Administrator
                                                    </p>
                                                    <p class="text-[9px] uppercase tracking-wide text-gray-500 mt-1">
                                                        Akses penuh
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Petugas -->
                                    <label class="cursor-pointer">
                                        <input 
                                            type="radio" 
                                            name="role" 
                                            value="petugas" 
                                            class="peer hidden"
                                        >

                                        <div class="h-[66px] border border-tertiary rounded-sm bg-white px-4 py-3 
                                                    peer-checked:border-primary 
                                                    peer-checked:bg-primary/5 
                                                    hover:border-primary transition">
                                            <div class="flex items-start gap-3">
                                                <span class="mt-1 w-3 h-3 rounded-full border border-gray-500"></span>

                                                <div>
                                                    <p class="text-xs font-bold text-neutral">
                                                        Petugas Lapangan
                                                    </p>
                                                    <p class="text-[9px] uppercase tracking-wide text-gray-500 mt-1">
                                                        Operasional
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Masyarakat -->
                                    <label class="cursor-pointer">
                                        <input 
                                            type="radio" 
                                            name="role" 
                                            value="masyarakat" 
                                            class="peer hidden"
                                            checked
                                        >

                                        <div class="h-[66px] border border-tertiary rounded-sm bg-white px-4 py-3 
                                                    peer-checked:border-primary 
                                                    peer-checked:bg-primary/5 
                                                    hover:border-primary transition">
                                            <div class="flex items-start gap-3">
                                                <span class="mt-1 w-3 h-3 rounded-full border border-gray-500"></span>

                                                <div>
                                                    <p class="text-xs font-bold text-neutral">
                                                        Masyarakat
                                                    </p>
                                                    <p class="text-[9px] uppercase tracking-wide text-gray-500 mt-1">
                                                        Pelapor
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                </div>
                            </div>
                        </section>

                        <!-- Informasi Dasar -->
                        <section class="mt-7">
                            <h3 class="font-montserrat text-base font-bold">
                                Informasi Dasar
                            </h3>

                            <div class="border-t border-tertiary/70 mt-4 pt-5 grid grid-cols-1 md:grid-cols-2 gap-5">

                                <!-- Nama -->
                                <div>
                                    <label class="block text-xs font-bold mb-2">
                                        Nama Lengkap
                                    </label>
                                    <input 
                                        type="text"
                                        name="name"
                                        placeholder="Contoh: Andi Wijaya"
                                        class="w-full h-11 border border-tertiary bg-white px-4 text-sm outline-none focus:border-primary"
                                    >
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-xs font-bold mb-2">
                                        Alamat Email
                                    </label>
                                    <input 
                                        type="email"
                                        name="email"
                                        placeholder="andi.wijaya@simbo.go.id"
                                        class="w-full h-11 border border-tertiary bg-white px-4 text-sm outline-none focus:border-primary"
                                    >
                                </div>

                                <!-- Password -->
                                <div>
                                    <label class="block text-xs font-bold mb-2">
                                        Password
                                    </label>
                                    <input 
                                        type="password"
                                        name="password"
                                        placeholder="Masukkan password"
                                        class="w-full h-11 border border-tertiary bg-white px-4 text-sm outline-none focus:border-primary"
                                    >
                                </div>

                                <!-- NIK -->
                                <div>
                                    <label class="block text-xs font-bold mb-2">
                                        NIK
                                    </label>
                                    <input 
                                        type="text"
                                        name="nik"
                                        placeholder="19920815 202011 1 002"
                                        class="w-full h-11 border border-tertiary bg-white px-4 text-sm outline-none focus:border-primary"
                                    >
                                </div>

                                <!-- Nomor HP -->
                                <div>
                                    <label class="block text-xs font-bold mb-2">
                                        Nomor HP
                                    </label>
                                    <input 
                                        type="text"
                                        name="phone"
                                        placeholder="081234567890"
                                        class="w-full h-11 border border-tertiary bg-white px-4 text-sm outline-none focus:border-primary"
                                    >
                                </div>

                            </div>

                            <!-- Alamat -->
                            <div class="mt-5">
                                <label class="block text-xs font-bold mb-2">
                                    Alamat
                                </label>
                                <textarea 
                                    name="address"
                                    rows="4"
                                    placeholder="Masukkan alamat lengkap"
                                    class="w-full border border-tertiary bg-white px-4 py-3 text-sm outline-none focus:border-primary resize-none"
                                ></textarea>
                            </div>
                        </section>

                        <!-- Status Akun -->
                        <section class="mt-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xs font-bold">
                                        Status Akun
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Aktifkan akun ini segera setelah disimpan.
                                    </p>
                                </div>

                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="status" value="aktif" class="sr-only peer" checked>
                                    <div class="w-10 h-5 bg-inputBg peer-focus:outline-none rounded-sm peer peer-checked:bg-primary"></div>
                                    <div class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-sm transition peer-checked:translate-x-5"></div>
                                </label>
                            </div>
                        </section>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 mt-9">
                            <a href="#" class="w-28 h-11 border border-gray-400 bg-white text-sm font-bold flex items-center justify-center hover:bg-formBG">
                                Batal
                            </a>

                            <button 
                                type="submit"
                                class="w-36 h-11 bg-primary text-white text-sm font-bold hover:bg-[#0f220f]">
                                Simpan
                            </button>
                        </div>

                    </form>
                </div>

                <!-- Help Card -->
                <aside class="bg-white border-2 border-primary/30 h-fit p-6 shadow-sm">
                    <div class="flex items-center gap-2 text-primary">
                        <span class="text-lg">ⓘ</span>
                        <h3 class="font-montserrat text-base font-bold">
                            Bantuan Pendaftaran
                        </h3>
                    </div>

                    <p class="text-sm text-gray-600 leading-6 mt-4">
                        Pastikan NIP dan Email yang dimasukkan valid untuk menghindari duplikasi data di sistem SIMBO.
                    </p>

                    <ul class="mt-5 space-y-3 text-xs text-gray-600">
                        <li class="flex items-start gap-2">
                            <span class="text-primary">✓</span>
                            <span>Aktivasi otomatis setelah simpan.</span>
                        </li>

                        <li class="flex items-start gap-2">
                            <span class="text-primary">✓</span>
                            <span>Kirim email notifikasi akun.</span>
                        </li>
                    </ul>
                </aside>

            </div>

        </main>