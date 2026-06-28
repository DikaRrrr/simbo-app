@extends('petugas.v_layouts.app')

@section('title', 'Proses Laporan - Petugas SIMBO')
@section('page_title', 'Proses Laporan')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-extrabold font-montserrat text-neutral flex items-center gap-2">
                Proses Laporan
                <span
                    class="px-2 py-1 text-sm bg-gray-200 text-gray-700 rounded-md font-mono">#RPT-{{ str_pad($laporan->id_laporan, 4, '0', STR_PAD_LEFT) }}</span>
            </h2>
            <p class="text-sm text-gray-500 mt-1">Tindak lanjuti laporan warga dan perbarui status penanganannya.</p>
        </div>
        <a href="{{ route('petugas.laporan.index') }}"
            class="rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">
            <i class="ph ph-arrow-left"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div
            class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 shadow-sm flex items-start gap-3">
            <i class="ph ph-warning-circle text-xl mt-0.5"></i>
            <div>
                <p class="font-bold mb-1">Gagal menyimpan pembaruan:</p>
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

        {{-- BAGIAN READ-ONLY (Informasi Asli Laporan) --}}
        <div class="bg-gray-50/50 p-6 md:p-8 border-b border-gray-200 space-y-6">

            {{-- Foto pertama milik warga --}}
            @if ($laporan->fotoUtama)
                <img src="{{ asset('storage/' . $laporan->fotoUtama->file_foto) }}" alt="Bukti Laporan"
                    class="w-full h-full object-cover">
            @else
                <div class="text-gray-400 flex flex-col items-center">
                    <i class="ph ph-image-broken text-4xl mb-2"></i>
                    <span class="text-sm font-medium">Pelapor tidak melampirkan foto</span>
                </div>
            @endif

            {{-- Foto penyelesaian petugas --}}
            @php
                $fotoPenyelesaian = $laporan->fotoLaporan->count() > 1 ? $laporan->fotoLaporan->last() : null;
            @endphp

            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Detail
                Laporan Warga</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-bold text-gray-500 mb-1">Pelapor</p>
                    <p class="text-sm font-semibold text-neutral">{{ $laporan->masyarakat->nama_lengkap ?? 'Anonim' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 mb-1">Kategori & Prioritas</p>
                    <div class="flex items-center gap-2">
                        <span
                            class="text-sm font-semibold text-neutral">{{ $laporan->kategori->nama_kategori ?? '-' }}</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                        <span
                            class="text-sm font-bold {{ $laporan->prioritas_laporan == 'Tinggi' ? 'text-red-600' : ($laporan->prioritas_laporan == 'Sedang' ? 'text-amber-600' : 'text-green-600') }}">
                            {{ $laporan->prioritas_laporan }}
                        </span>
                    </div>
                </div>
            </div>

            <div>
                <p class="text-xs font-bold text-gray-500 mb-1">Judul Laporan</p>
                <p class="text-sm font-semibold text-neutral">{{ $laporan->judul_laporan }}</p>
            </div>

            <div>
                <p class="text-xs font-bold text-gray-500 mb-1">Isi Laporan</p>
                <div
                    class="bg-white border border-gray-200 rounded-xl p-4 text-sm text-gray-600 leading-relaxed shadow-inner">
                    {{ $laporan->isi_laporan }}
                </div>
            </div>

            <div>
                <p class="text-xs font-bold text-gray-500 mb-1">Lokasi Kejadian</p>
                <div
                    class="bg-white border border-gray-200 rounded-xl p-4 text-sm text-gray-600 shadow-inner flex items-start gap-2">
                    <i class="ph ph-map-pin text-red-500 text-lg mt-0.5 shrink-0"></i>
                    <span>{{ $laporan->lokasi }}</span>
                </div>
            </div>
        </div>

        {{-- BAGIAN EDITABLE (Pembaruan oleh Petugas) --}}
        <form action="{{ route('petugas.laporan.update', $laporan->id_laporan) }}" method="POST"
            enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <h3 class="text-sm font-bold text-primary uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Tindakan
                Petugas</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- Kolom Kiri: Status & Catatan --}}
                <div class="space-y-6">
                    <div>
                        <label for="status_laporan" class="block text-sm font-bold text-neutral mb-2">Ubah Status <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="status_laporan" name="status_laporan" required
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium outline-none focus:border-primary focus:ring-1 focus:ring-primary appearance-none cursor-pointer">
                                <option value="Menunggu" @selected(old('status_laporan', $laporan->status_laporan) === 'Menunggu')>⏳ Menunggu</option>
                                <option value="Diproses" @selected(old('status_laporan', $laporan->status_laporan) === 'Diproses')>🔄 Sedang Diproses</option>
                                <option value="Selesai" @selected(old('status_laporan', $laporan->status_laporan) === 'Selesai')>✅ Selesai</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <i class="ph ph-caret-down"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Catatan dari Admin (Read Only) --}}
                    @if (!empty($catatanAdmin))
                        <div>
                            <label class="block text-sm font-bold text-neutral mb-2">Instruksi dari Admin</label>
                            <div
                                class="w-full rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800 leading-relaxed">
                                {{ $catatanAdmin }}
                            </div>
                        </div>
                    @endif

                    {{-- Input Catatan Petugas --}}
                    <div>
                        <label for="catatan_petugas" class="block text-sm font-bold text-neutral mb-2">Catatan Penanganan
                            (Petugas)</label>
                        <textarea id="catatan_petugas" name="catatan_petugas" rows="4"
                            placeholder="Tuliskan tindakan apa saja yang sudah dilakukan di lapangan untuk warga..."
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary resize-none">{{ old('catatan_petugas', $catatanPetugas) }}</textarea>
                    </div>
                </div>

                {{-- Kolom Kanan: Upload Foto Penyelesaian --}}
                <div class="space-y-3">

                    {{-- Label + Badge Wajib (muncul otomatis saat status Selesai) --}}
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-bold text-neutral">Foto Penyelesaian Lapangan</label>
                        <span id="badge-wajib"
                            class="hidden text-[10px] font-bold px-2 py-1 rounded-full bg-red-100 text-red-600 border border-red-200 uppercase tracking-wide">
                            Wajib saat Selesai
                        </span>
                    </div>

                    {{-- Upload Area --}}
                    <label for="foto_penyelesaian" id="upload-area"
                        class="border-2 border-dashed border-gray-300 bg-gray-50 rounded-xl p-6 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-gray-100 hover:border-primary transition-all group h-[180px]">
                        <i
                            class="ph ph-camera-plus text-4xl text-gray-400 group-hover:text-primary transition-colors mb-2"></i>
                        <p class="text-sm font-bold text-gray-600 mb-1 group-hover:text-primary">Pilih atau Tarik Foto Baru
                        </p>
                        <p class="text-xs text-gray-400" id="upload-hint">
                            Wajib diunggah jika status Selesai<br>(Maks 5MB)
                        </p>
                        <input type="file" id="foto_penyelesaian" name="foto_penyelesaian" class="hidden"
                            accept="image/png, image/jpeg">
                    </label>

                    {{-- Preview Foto Baru (muncul setelah pilih file) --}}
                    <div id="preview-container" class="hidden">
                        <div class="relative rounded-xl overflow-hidden border-2 border-primary shadow-sm">
                            <img id="preview-img" src="#" alt="Preview" class="w-full h-40 object-cover">
                            <div class="absolute top-2 right-2">
                                <button type="button" onclick="hapusPreview()"
                                    class="w-7 h-7 bg-red-600 text-white rounded-full flex items-center justify-center hover:bg-red-700 transition-colors shadow">
                                    <i class="ph ph-x text-xs"></i>
                                </button>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-black/50 px-3 py-1.5">
                                <p id="preview-nama" class="text-xs text-white font-medium truncate"></p>
                            </div>
                        </div>
                        <p class="text-xs text-green-600 font-semibold mt-1.5 flex items-center gap-1">
                            <i class="ph ph-check-circle"></i>
                            Foto siap diunggah
                        </p>
                    </div>

                    {{-- Foto Penyelesaian Sebelumnya (jika ada) --}}
                    @php
                        $fotoPenyelesaian = $laporan->fotoLaporan->count() > 1 ? $laporan->fotoLaporan->last() : null;
                    @endphp

                    @if ($fotoPenyelesaian)
                        <div class="p-3 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
                            <img src="{{ asset('storage/' . $fotoPenyelesaian->file_foto) }}"
                                class="w-12 h-12 rounded-lg object-cover border border-green-300 shrink-0">
                            <div>
                                <p class="text-xs font-bold text-green-700">Foto penyelesaian sebelumnya</p>
                                <p class="text-[10px] text-green-600 mt-0.5">Upload foto baru untuk menggantinya</p>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- ACTION BUTTONS --}}
                <div class="flex flex-wrap items-center justify-end gap-3 border-t border-gray-200 pt-6 mt-8">

                    {{-- Tombol Submit Standar --}}
                    <button type="submit"
                        class="px-6 py-3 rounded-xl border border-primary bg-white text-primary text-sm font-bold hover:bg-primary/5 transition-all shadow-sm flex items-center gap-2">
                        <i class="ph ph-floppy-disk text-lg"></i> Simpan Saja
                    </button>

                    {{-- Tombol Submit + Kirim WA --}}
                    <button type="submit" name="kirim_wa" value="1"
                        class="px-6 py-3 rounded-xl bg-green-600 text-white text-sm font-bold hover:bg-green-700 transition-all shadow-md flex items-center gap-2 border-none ring-0">
                        <i class="ph ph-whatsapp-logo text-lg"></i>
                        Selesaikan & Hubungi via WA
                    </button>
                </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const selectStatus = document.getElementById('status_laporan');
                const uploadArea = document.getElementById('upload-area');
                const badgeWajib = document.getElementById('badge-wajib');
                const inputFoto = document.getElementById('foto_penyelesaian');
                const previewBox = document.getElementById('preview-container');
                const previewImg = document.getElementById('preview-img');
                const previewNama = document.getElementById('preview-nama');
                const forceSelesai = document.getElementById('force_selesai');
                const form = document.querySelector('form[action*="update"]');

                // ── Toggle tampilan wajib foto saat status berubah ─────────────
                function updateUploadState() {
                    const isSelesai = selectStatus.value === 'Selesai';

                    badgeWajib.classList.toggle('hidden', !isSelesai);
                    uploadArea.classList.toggle('border-red-400', isSelesai);
                    uploadArea.classList.toggle('bg-red-50/30', isSelesai);
                    uploadArea.classList.toggle('border-gray-300', !isSelesai);
                    uploadArea.classList.toggle('bg-gray-50', !isSelesai);
                }

                selectStatus.addEventListener('change', updateUploadState);
                updateUploadState(); // Jalankan saat halaman load

                // ── Preview foto yang dipilih ───────────────────────────────────
                inputFoto.addEventListener('change', function() {
                    const file = this.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewImg.src = e.target.result;
                        previewNama.textContent = file.name;
                        previewBox.classList.remove('hidden');
                        uploadArea.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                });

                // ── Hapus preview & reset input ────────────────────────────────
                window.hapusPreview = function() {
                    inputFoto.value = '';
                    previewImg.src = '#';
                    previewBox.classList.add('hidden');
                    uploadArea.classList.remove('hidden');
                };

                // ── Tombol Selesaikan ──────────────────────────────────────────
                window.setSelesai = function() {
                    selectStatus.value = 'Selesai';
                    forceSelesai.value = '1';
                    updateUploadState();

                    // Validasi foto wajib jika belum ada foto sebelumnya
                    @if (!$fotoPenyelesaian)
                        if (!inputFoto.files.length) {
                            uploadArea.classList.add('border-red-500', 'animate-pulse');
                            setTimeout(() => uploadArea.classList.remove('animate-pulse'), 1500);
                            alert('Harap upload foto penyelesaian terlebih dahulu sebelum menyelesaikan laporan.');
                            return;
                        }
                    @endif

                    form.submit();
                };

                // ── Tombol Selesaikan + WA ─────────────────────────────────────
                window.setSelesaiWa = function() {
                    selectStatus.value = 'Selesai';
                    forceSelesai.value = '1';
                    updateUploadState();

                    @if (!$fotoPenyelesaian)
                        if (!inputFoto.files.length) {
                            uploadArea.classList.add('border-red-500', 'animate-pulse');
                            setTimeout(() => uploadArea.classList.remove('animate-pulse'), 1500);
                            alert('Harap upload foto penyelesaian terlebih dahulu sebelum menyelesaikan laporan.');
                            return;
                        }
                    @endif

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'kirim_wa';
                    input.value = '1';
                    form.appendChild(input);
                    form.submit();
                };

            });
        </script>
    @endpush
@endsection
