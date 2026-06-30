@extends('masyarakat.v_layouts.app')

@section('title', 'SIMBO - Profile Pengguna')
@section('page_title', 'Profile Pengguna')

@section('content')
    <main class="flex-1 md:ml-[92px] pb-24 bg-gray-50 min-h-screen">

        <div class="max-w-[980px] mx-auto px-4 sm:px-6 py-8 md:py-10">
            @if (session('success'))
                <div
                    class="mb-6 rounded-2xl bg-green-50 border border-green-200 text-green-700 px-5 py-4 text-sm font-semibold flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 px-5 py-4 text-sm shadow-sm">
                    <div class="flex items-center gap-2 mb-2 font-bold">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Periksa kembali data profil:
                    </div>
                    <ul class="list-disc ml-7 space-y-1 text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('masyarakat.profile.update') }}" method="POST" enctype="multipart/form-data"
                id="profileForm" class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="remove_photo" id="remove_photo" value="0">

                {{-- Card 1: Header Profile --}}
                <section
                    class="bg-white border border-gray-100 rounded-3xl p-6 md:p-8 flex flex-col md:flex-row md:items-center gap-6 md:gap-8 shadow-sm">
                    <div class="relative shrink-0 mx-auto md:mx-0">
                        <div class="w-32 h-32 rounded-full border-[6px] border-gray-50 shadow-inner overflow-hidden bg-gray-100 flex items-center justify-center relative group"
                            id="photoPreviewBox">
                            @if ($user->foto_profile)
                                <img src="{{ asset('storage/' . $user->foto_profile) }}" alt="Foto profil" id="photoPreview"
                                    class="w-full h-full object-cover">
                            @else
                                <svg id="photoPlaceholder" class="w-16 h-16 text-gray-300" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4Zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Z" />
                                </svg>
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 text-center md:text-left">
                        <h2 class="font-montserrat text-2xl font-black text-gray-900 mb-4 tracking-tight">
                            {{ old('nama_lengkap', $user->nama_lengkap) ?: 'Nama Pengguna' }}
                        </h2>
                        <div class="flex flex-wrap justify-center md:justify-start items-center gap-3">
                            <button type="button" id="changePhotoBtn"
                                class="inline-flex items-center justify-center bg-primary/10 text-primary hover:bg-primary/20 px-6 py-2.5 rounded-full text-sm font-bold cursor-pointer transition-colors">
                                Ubah Foto
                            </button>
                            <input id="foto_profile" type="file" name="foto_profile" accept="image/jpeg,image/png"
                                class="hidden">
                            <button type="button" id="removePhotoBtn"
                                class="inline-flex items-center justify-center bg-red-50 text-red-600 hover:bg-red-100 px-6 py-2.5 rounded-full text-sm font-bold transition-colors">
                                Hapus
                            </button>
                        </div>
                        <p class="text-xs font-medium text-gray-400 mt-3">Format: JPG, PNG. Maksimal 2MB.</p>
                    </div>
                </section>

                {{-- Card 2: Informasi Pribadi --}}
                <section class="bg-white border border-gray-100 rounded-3xl p-6 md:p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h2 class="font-montserrat text-lg font-bold text-gray-900">Informasi Pribadi</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                        <div>
                            <label for="nama_lengkap"
                                class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Nama
                                Lengkap</label>
                            <input id="nama_lengkap" name="nama_lengkap" type="text"
                                value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                                class="w-full h-11 rounded-xl bg-gray-50 px-4 text-sm font-medium text-gray-900 border border-gray-200 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                        </div>
                        <div>
                            <label for="email"
                                class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                                class="w-full h-11 rounded-xl bg-gray-50 px-4 text-sm font-medium text-gray-900 border border-gray-200 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                        </div>
                        <div>
                            <label for="no_hp"
                                class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Nomor
                                Telepon</label>
                            <input id="no_hp" name="no_hp" type="text" value="{{ old('no_hp', $user->no_hp) }}"
                                class="w-full h-11 rounded-xl bg-gray-50 px-4 text-sm font-medium text-gray-900 border border-gray-200 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                        </div>
                        <div>
                            <label for="nik"
                                class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">NIK</label>
                            <input id="nik" name="nik" type="text" value="{{ old('nik', $user->nik) }}"
                                class="w-full h-11 rounded-xl bg-gray-50 px-4 text-sm font-medium text-gray-900 border border-gray-200 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                        </div>
                    </div>
                </section>

                {{-- Card 3: Detail Alamat --}}
                <section class="bg-white border border-gray-100 rounded-3xl p-6 md:p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h2 class="font-montserrat text-lg font-bold text-gray-900">Detail Alamat</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                        <div class="md:col-span-2">
                            <label for="alamat"
                                class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Alamat Tempat
                                Tinggal</label>
                            <textarea id="alamat" name="alamat" rows="3"
                                class="w-full rounded-xl bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 border border-gray-200 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 resize-none transition-all">{{ old('alamat', $user->alamat) }}</textarea>
                        </div>
                    </div>
                </section>

                {{-- Card 4: Keamanan Akun --}}
                <section class="bg-white border border-gray-100 rounded-3xl p-6 md:p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="font-montserrat text-lg font-bold text-gray-900">Keamanan Akun</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                        <div class="md:col-span-2">
                            <label for="password_saat_ini"
                                class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Kata Sandi Saat
                                Ini</label>
                            <input id="password_saat_ini" name="password_saat_ini" type="password"
                                autocomplete="current-password"
                                placeholder="Biarkan kosong jika tidak ingin mengubah sandi"
                                class="w-full h-11 rounded-xl bg-gray-50 px-4 text-sm font-medium text-gray-900 border border-gray-200 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                        </div>
                        <div>
                            <label for="password_baru"
                                class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Kata Sandi
                                Baru</label>
                            <input id="password_baru" name="password_baru" type="password" autocomplete="new-password"
                                class="w-full h-11 rounded-xl bg-gray-50 px-4 text-sm font-medium text-gray-900 border border-gray-200 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                        </div>
                        <div>
                            <label for="password_baru_confirmation"
                                class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Konfirmasi Kata
                                Sandi Baru</label>
                            <input id="password_baru_confirmation" name="password_baru_confirmation" type="password"
                                autocomplete="new-password"
                                class="w-full h-11 rounded-xl bg-gray-50 px-4 text-sm font-medium text-gray-900 border border-gray-200 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                        </div>
                    </div>
                </section>

                <div class="flex justify-end items-center gap-4 pt-4">
                    <a href="{{ url('/') }}"
                        class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 px-8 py-3.5 rounded-xl text-sm font-bold transition-colors">
                        Batalkan
                    </a>
                    <button type="submit"
                        class="bg-primary hover:bg-primary/90 text-white px-8 py-3.5 rounded-xl text-sm font-bold shadow-sm shadow-primary/30 transition-all transform hover:-translate-y-0.5">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

    {{-- Modal Konfirmasi yang Disempurnakan --}}
    <div id="confirmModal"
        class="fixed inset-0 z-[100] hidden items-center justify-center bg-gray-900/60 backdrop-blur-sm px-4 transition-opacity">
        <div class="w-full max-w-md rounded-3xl bg-white shadow-2xl overflow-hidden transform transition-all scale-100">
            <div class="px-6 pt-8 pb-5 text-center">
                <div
                    class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-primary/10 text-primary">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                    </svg>
                </div>
                <h3 id="confirmTitle" class="font-montserrat text-xl font-black text-gray-900 tracking-tight mb-2">
                    Konfirmasi</h3>
                <p id="confirmMessage" class="text-sm font-medium leading-relaxed text-gray-500 px-2"></p>
            </div>

            <div
                class="bg-gray-50 px-6 py-5 flex flex-col-reverse sm:flex-row justify-center gap-3 border-t border-gray-100">
                <button type="button" id="confirmCancelBtn"
                    class="w-full sm:w-auto rounded-xl bg-white border border-gray-200 px-6 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="button" id="confirmOkBtn"
                    class="w-full sm:w-auto rounded-xl bg-primary px-6 py-3 text-sm font-bold text-white hover:bg-primary/90 shadow-sm shadow-primary/30 transition-colors">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    {{-- (Script JavaScript Anda tetap sama persis, tidak perlu diubah) --}}
    <script>
        // ... Script konfirmasi yang sudah Anda buat sebelumnya ...
        const fotoInput = document.getElementById('foto_profile');
        const removeInput = document.getElementById('remove_photo');
        const removeBtn = document.getElementById('removePhotoBtn');
        const changePhotoBtn = document.getElementById('changePhotoBtn');
        const previewBox = document.getElementById('photoPreviewBox');
        const profileForm = document.getElementById('profileForm');
        const confirmModal = document.getElementById('confirmModal');
        const confirmTitle = document.getElementById('confirmTitle');
        const confirmMessage = document.getElementById('confirmMessage');
        const confirmOkBtn = document.getElementById('confirmOkBtn');
        const confirmCancelBtn = document.getElementById('confirmCancelBtn');

        let confirmAction = null;
        let formConfirmed = false;

        const placeholderIcon =
            `<svg class="w-16 h-16 text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4Zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Z"/></svg>`;

        function openConfirm(title, message, okText, action) {
            confirmTitle.textContent = title;
            confirmMessage.textContent = message;
            confirmOkBtn.textContent = okText;
            confirmAction = action;
            confirmModal.classList.remove('hidden');
            confirmModal.classList.add('flex');
        }

        function closeConfirm() {
            confirmModal.classList.add('hidden');
            confirmModal.classList.remove('flex');
            confirmAction = null;
        }

        changePhotoBtn?.addEventListener('click', function() {
            openConfirm(
                'Ubah Foto Profil?',
                'Apakah Anda yakin ingin memilih foto profil baru? Foto baru akan diproses setelah tombol Simpan Perubahan ditekan.',
                'Ya, Pilih Foto',
                function() {
                    fotoInput.click();
                }
            );
        });

        fotoInput?.addEventListener('change', function() {
            const file = this.files?.[0];
            if (!file) return;

            const validTypes = ['image/jpeg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                this.value = '';
                openConfirm('Format Tidak Sesuai', 'Gunakan foto dengan format JPG, JPEG, atau PNG.', 'Mengerti',
                    function() {});
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                this.value = '';
                openConfirm('Ukuran Foto Terlalu Besar',
                    'Ukuran foto maksimal 2MB. Silakan pilih foto yang lebih kecil.', 'Mengerti',
                    function() {});
                return;
            }

            removeInput.value = '0';
            const reader = new FileReader();
            reader.onload = function(event) {
                previewBox.innerHTML =
                    `<img src="${event.target.result}" alt="Preview foto profil" class="w-full h-full object-cover">`;
            };
            reader.readAsDataURL(file);
        });

        removeBtn?.addEventListener('click', function() {
            openConfirm(
                'Hapus Foto Profil?',
                'Apakah Anda yakin ingin menghapus foto profil? Foto akan benar-benar dihapus setelah tombol Simpan Perubahan ditekan.',
                'Ya, Hapus Foto',
                function() {
                    fotoInput.value = '';
                    removeInput.value = '1';
                    previewBox.innerHTML = placeholderIcon;
                }
            );
        });

        profileForm?.addEventListener('submit', function(event) {
            if (formConfirmed) return;

            event.preventDefault();
            openConfirm(
                'Simpan Perubahan Profil?',
                'Perubahan pada informasi pribadi, detail alamat, foto profil, dan keamanan akun user masyarakat akan disimpan. Pastikan data sudah benar.',
                'Ya, Simpan Perubahan',
                function() {
                    formConfirmed = true;
                    profileForm.submit();
                }
            );
        });

        confirmOkBtn?.addEventListener('click', function() {
            const action = confirmAction;
            closeConfirm();
            if (typeof action === 'function') {
                action();
            }
        });

        confirmCancelBtn?.addEventListener('click', closeConfirm);

        confirmModal?.addEventListener('click', function(event) {
            if (event.target === confirmModal) {
                closeConfirm();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !confirmModal.classList.contains('hidden')) {
                closeConfirm();
            }
        });
    </script>
@endsection
