@extends('masyarakat.v_layouts.app')

@section('title', 'SIMBO - Profile Pengguna')
@section('page_title', 'Profile Pengguna')

@section('content')
    <main class="flex-1 md:ml-[92px] pb-24">

        <div class="max-w-[980px] mx-auto px-4 sm:px-6 py-6 md:py-8">
            @if (session('success'))
                <div
                    class="mb-5 rounded-2xl bg-green-100 border border-green-300 text-green-800 px-5 py-3 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-2xl bg-red-100 border border-red-300 text-red-800 px-5 py-3 text-sm">
                    <p class="font-bold mb-1">Periksa kembali data profil.</p>
                    <ul class="list-disc ml-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('masyarakat.profile.update') }}" method="POST" enctype="multipart/form-data"
                id="profileForm" class="space-y-3">
                @csrf
                @method('PUT')
                <input type="hidden" name="remove_photo" id="remove_photo" value="0">

                <section
                    class="bg-[#c9c9c9] rounded-2xl p-5 md:p-7 flex flex-col md:flex-row md:items-center gap-6 md:gap-8 shadow-sm">
                    <div class="relative shrink-0 mx-auto md:mx-0">
                        <div class="w-28 h-28 rounded-full border-[7px] border-white overflow-hidden bg-[#eeeeee] flex items-center justify-center"
                            id="photoPreviewBox">
                            @if ($user->foto_profile)
                                <img src="{{ asset('storage/' . $user->foto_profile) }}" alt="Foto profil" id="photoPreview"
                                    class="w-full h-full object-cover">
                            @else
                                <svg id="photoPlaceholder" class="w-20 h-20 text-white" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4Zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Z" />
                                </svg>
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 text-center md:text-left">
                        <h2 class="font-montserrat text-lg font-extrabold mb-5">
                            {{ old('nama_lengkap', $user->nama_lengkap) ?: 'Nama Pengguna' }}</h2>
                        <div class="flex flex-wrap justify-center md:justify-start items-center gap-3">
                            <button type="button" id="changePhotoBtn"
                                class="inline-flex items-center justify-center bg-[#eeeeee] hover:bg-white px-6 py-2.5 rounded-full text-sm font-bold cursor-pointer transition">
                                Ubah Foto
                            </button>
                            <input id="foto_profile" type="file" name="foto_profile" accept="image/jpeg,image/png"
                                class="hidden">
                            <button type="button" id="removePhotoBtn"
                                class="inline-flex items-center justify-center bg-[#eeeeee] hover:bg-white px-8 py-2.5 rounded-full text-sm font-bold transition">
                                Hapus
                            </button>
                        </div>
                        <p class="text-xs font-semibold mt-3">Format yang didukung: JPG, PNG. Maksimal ukuran file 2MB.</p>
                    </div>
                </section>

                <section class="bg-[#c9c9c9] rounded-2xl p-5 md:p-7 shadow-sm">
                    <h2 class="font-montserrat text-lg font-extrabold text-center mb-6">Informasi Pribadi</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-4">
                        <div>
                            <label for="nama_lengkap" class="block text-xs font-medium mb-2">Nama Lengkap</label>
                            <input id="nama_lengkap" name="nama_lengkap" type="text"
                                value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                                class="w-full h-10 rounded-full bg-[#e4e4e4] px-5 text-sm border border-transparent focus:outline-none focus:ring-2 focus:ring-[#142C14]/30">
                        </div>
                        <div>
                            <label for="email" class="block text-xs font-medium mb-2">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                                class="w-full h-10 rounded-full bg-[#e4e4e4] px-5 text-sm border border-transparent focus:outline-none focus:ring-2 focus:ring-[#142C14]/30">
                        </div>
                        <div>
                            <label for="no_hp" class="block text-xs font-medium mb-2">Nomor Telepon</label>
                            <input id="no_hp" name="no_hp" type="text" value="{{ old('no_hp', $user->no_hp) }}"
                                class="w-full h-10 rounded-full bg-[#e4e4e4] px-5 text-sm border border-transparent focus:outline-none focus:ring-2 focus:ring-[#142C14]/30">
                        </div>
                        <div>
                            <label for="nik" class="block text-xs font-medium mb-2">NIK</label>
                            <input id="nik" name="nik" type="text" value="{{ old('nik', $user->nik) }}"
                                class="w-full h-10 rounded-full bg-[#e4e4e4] px-5 text-sm border border-transparent focus:outline-none focus:ring-2 focus:ring-[#142C14]/30">
                        </div>
                    </div>
                </section>

                <section class="bg-[#c9c9c9] rounded-2xl p-5 md:p-7 shadow-sm">
                    <h2 class="font-montserrat text-lg font-extrabold text-center mb-6">Detail Alamat</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-4">
                        <div class="md:col-span-2">
                            <label for="alamat" class="block text-xs font-medium mb-2">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="2"
                                class="w-full rounded-2xl bg-[#e4e4e4] px-5 py-3 text-sm border border-transparent focus:outline-none focus:ring-2 focus:ring-[#142C14]/30 resize-none">{{ old('alamat', $user->alamat) }}</textarea>
                        </div>
                    </div>
                </section>

                <section class="bg-[#c9c9c9] rounded-2xl p-5 md:p-7 shadow-sm">
                    <h2 class="font-montserrat text-lg font-extrabold text-center mb-6">Keamanan Akun</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-4">
                        <div class="md:col-span-2">
                            <label for="password_saat_ini" class="block text-xs font-medium mb-2">Kata Sandi Saat
                                Ini</label>
                            <input id="password_saat_ini" name="password_saat_ini" type="password"
                                autocomplete="current-password"
                                class="w-full h-10 rounded-full bg-[#e4e4e4] px-5 text-sm border border-transparent focus:outline-none focus:ring-2 focus:ring-[#142C14]/30">
                        </div>
                        <div>
                            <label for="password_baru" class="block text-xs font-medium mb-2">Kata Sandi Baru</label>
                            <input id="password_baru" name="password_baru" type="password" autocomplete="new-password"
                                class="w-full h-10 rounded-full bg-[#e4e4e4] px-5 text-sm border border-transparent focus:outline-none focus:ring-2 focus:ring-[#142C14]/30">
                        </div>
                        <div>
                            <label for="password_baru_confirmation" class="block text-xs font-medium mb-2">Konfirmasi Kata
                                Sandi Baru</label>
                            <input id="password_baru_confirmation" name="password_baru_confirmation" type="password"
                                autocomplete="new-password"
                                class="w-full h-10 rounded-full bg-[#e4e4e4] px-5 text-sm border border-transparent focus:outline-none focus:ring-2 focus:ring-[#142C14]/30">
                        </div>
                    </div>
                </section>

                <div class="flex justify-end items-center gap-4 pt-2">
                    <a href="{{ url('/') }}"
                        class="bg-[#dddddd] hover:bg-[#eeeeee] text-[#444] px-8 py-3 rounded-xl text-xs font-semibold transition">Batalkan</a>
                    <button type="submit"
                        class="bg-[#eeeeee] hover:bg-white text-[#222] px-8 py-3 rounded-xl text-xs font-semibold shadow-sm transition">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </main>
    </div>

    <div id="confirmModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 px-4">
        <div class="w-full max-w-md rounded-3xl bg-white shadow-2xl overflow-hidden">
            <div class="bg-[#c9c9c9] px-6 py-5 text-center">
                <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-[#eeeeee] text-[#222]">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                    </svg>
                </div>
                <h3 id="confirmTitle" class="font-montserrat text-xl font-extrabold text-[#222]">Konfirmasi</h3>
            </div>

            <div class="px-6 py-5 text-center">
                <p id="confirmMessage" class="text-sm font-medium leading-relaxed text-[#444]"></p>
                <div class="mt-6 flex flex-col-reverse sm:flex-row justify-center gap-3">
                    <button type="button" id="confirmCancelBtn"
                        class="rounded-xl bg-[#dddddd] px-6 py-3 text-sm font-bold text-[#444] hover:bg-[#d2d2d2] transition">
                        Batal
                    </button>
                    <button type="button" id="confirmOkBtn"
                        class="rounded-xl bg-[#142C14] px-6 py-3 text-sm font-bold text-white hover:bg-[#1f3f1f] transition">
                        Ya, Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
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
            `<svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4Zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Z"/></svg>`;

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
