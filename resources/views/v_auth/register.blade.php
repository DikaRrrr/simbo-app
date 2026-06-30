<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIMBO</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-white.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-primary min-h-screen flex flex-col font-worksans text-neutral overflow-y-auto">

    <div class="w-full px-8 pt-4 pb-0 shrink-0">
        <a href="{{ url('/') }}" class="flex items-center">
            <img src="{{ asset('images/logo-white.png') }}" alt="Logo SIMBO" class="h-20 w-auto object-contain">
        </a>
    </div>

    <div class="flex-grow flex items-center justify-center p-4 sm:p-6 min-h-0">

        <div class="bg-white rounded-[25px] p-5 sm:px-8 w-full max-w-[500px] shadow-xl flex flex-col justify-center">

            <div class="text-center mb-3">
                <h2 class="font-montserrat text-xl sm:text-2xl font-bold text-neutral">Daftar Akun Baru</h2>
            </div>

            @if ($errors->any())
                <div class="mb-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-xs text-red-700">
                    <p class="font-bold mb-1">Periksa kembali data pendaftaran.</p>
                    <ul class="list-disc ml-4 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST" class="space-y-2" id="registerForm">
                @csrf

                <div class="rounded-2xl border border-primary/10 bg-primary/5 p-3">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div>
                            <p class="font-montserrat text-sm font-bold text-neutral">Scan KTP</p>
                            <p class="text-[11px] leading-snug text-neutral/70">
                                Upload atau ambil foto KTP, lalu sistem akan mencoba mengisi NIK, nama lengkap, dan
                                alamat secara otomatis.
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <button type="button" id="pilihKtpBtn"
                                class="rounded-xl bg-white px-3 py-2 text-[11px] font-bold text-neutral shadow-sm hover:bg-gray-100 transition">
                                Upload KTP
                            </button>
                            <button type="button" id="scanKtpBtn"
                                class="rounded-xl bg-neutral px-3 py-2 text-[11px] font-bold text-white shadow-sm hover:bg-black/80 transition disabled:cursor-not-allowed disabled:opacity-50"
                                disabled>
                                Scan
                            </button>
                        </div>
                    </div>

                    {{-- Tidak memakai atribut name agar file KTP tidak ikut dikirim ke controller.
                         Sesuai permintaan, perubahan hanya di view register tanpa ubah controller, migration, dan model. --}}
                    <input type="file" id="foto_ktp" accept="image/jpeg,image/png,image/jpg" capture="environment"
                        class="hidden">

                    <div id="ktpPreviewWrap"
                        class="mt-3 hidden overflow-hidden rounded-xl border border-gray-200 bg-white">
                        <img id="ktpPreview" src="" alt="Preview KTP"
                            class="max-h-28 w-full object-contain bg-gray-50">
                    </div>

                    <div class="mt-2 flex items-center justify-between gap-3">
                        <p id="ktpFileName" class="text-[11px] text-neutral/60 truncate">Belum ada foto KTP dipilih.</p>
                        <p id="ocrStatus" class="text-[11px] font-semibold text-neutral/70 text-right"></p>
                    </div>

                    <div id="ocrProgressWrap" class="mt-2 hidden h-2 overflow-hidden rounded-full bg-gray-200">
                        <div id="ocrProgress" class="h-full w-0 rounded-full bg-primary transition-all"></div>
                    </div>
                </div>

                <div>
                    <label for="nik" class="block text-[11px] font-semibold mb-0.5 ml-1 text-neutral">NIK (Nomor
                        Induk Kependudukan)</label>
                    <input type="text" id="nik" name="nik" value="{{ old('nik') }}" inputmode="numeric"
                        maxlength="16"
                        class="w-full bg-[#F3F4F6] border border-transparent rounded-xl px-4 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors text-neutral text-sm"
                        required>
                </div>

                <div>
                    <label for="nama" class="block text-[11px] font-semibold mb-0.5 ml-1 text-neutral">Nama
                        Lengkap</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                        class="w-full bg-[#F3F4F6] border border-transparent rounded-xl px-4 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors text-neutral text-sm"
                        required>
                </div>

                <div>
                    <label for="email" class="block text-[11px] font-semibold mb-0.5 ml-1 text-neutral">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full bg-[#F3F4F6] border border-transparent rounded-xl px-4 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors text-neutral text-sm"
                        required>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="nohp" class="block text-[11px] font-semibold mb-0.5 ml-1 text-neutral">No.
                            HP</label>
                        <input type="tel" id="nohp" name="nohp" value="{{ old('nohp') }}"
                            class="w-full bg-[#F3F4F6] border border-transparent rounded-xl px-4 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors text-neutral text-sm"
                            required>
                    </div>

                    <div>
                        <label for="password"
                            class="block text-[11px] font-semibold mb-0.5 ml-1 text-neutral">Password</label>
                        <input type="password" id="password" name="password"
                            class="w-full bg-[#F3F4F6] border border-transparent rounded-xl px-4 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors text-neutral text-sm"
                            required>
                    </div>
                </div>

                <div>
                    <label for="alamat"
                        class="block text-[11px] font-semibold mb-0.5 ml-1 text-neutral">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="2"
                        class="w-full bg-[#F3F4F6] border border-transparent rounded-xl px-4 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors text-neutral resize-none text-sm"
                        required>{{ old('alamat') }}</textarea>
                </div>

                <p class="text-[11px] leading-relaxed text-neutral/60">
                    Catatan: hasil scan bergantung pada kualitas foto KTP. Jika hasil belum sesuai, data tetap bisa
                    diperbaiki manual sebelum daftar.
                </p>

                <div class="pt-3">
                    <button type="submit"
                        class="w-full bg-neutral text-white font-montserrat font-bold text-sm rounded-xl py-2.5 hover:bg-opacity-90 hover:-translate-y-0.5 transition-all shadow-md">
                        Daftar Sekarang
                    </button>
                </div>

                <div class="text-center pt-2">
                    <p class="text-xs text-neutral/70">Sudah punya akun? <a href="{{ url('/login') }}"
                            class="font-bold text-primary hover:underline">Masuk di sini</a></p>
                </div>

            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
    <script>
        const ktpInput = document.getElementById('foto_ktp');
        const pilihKtpBtn = document.getElementById('pilihKtpBtn');
        const scanKtpBtn = document.getElementById('scanKtpBtn');
        const ktpPreviewWrap = document.getElementById('ktpPreviewWrap');
        const ktpPreview = document.getElementById('ktpPreview');
        const ktpFileName = document.getElementById('ktpFileName');
        const ocrStatus = document.getElementById('ocrStatus');
        const ocrProgressWrap = document.getElementById('ocrProgressWrap');
        const ocrProgress = document.getElementById('ocrProgress');
        const nikInput = document.getElementById('nik');
        const namaInput = document.getElementById('nama');
        const alamatInput = document.getElementById('alamat');

        pilihKtpBtn?.addEventListener('click', function() {
            ktpInput.click();
        });

        ktpInput?.addEventListener('change', function() {
            const file = this.files?.[0];
            if (!file) return;

            const validTypes = ['image/jpeg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                resetKtpInput('Format KTP harus JPG, JPEG, atau PNG.');
                return;
            }

            if (file.size > 4 * 1024 * 1024) {
                resetKtpInput('Ukuran foto KTP maksimal 4MB.');
                return;
            }

            ktpFileName.textContent = file.name;
            scanKtpBtn.disabled = false;

            const reader = new FileReader();
            reader.onload = function(event) {
                ktpPreview.src = event.target.result;
                ktpPreviewWrap.classList.remove('hidden');
            };
            reader.readAsDataURL(file);

            scanKtpImage();
        });

        scanKtpBtn?.addEventListener('click', scanKtpImage);

        function resetKtpInput(message) {
            ktpInput.value = '';
            ktpFileName.textContent = 'Belum ada foto KTP dipilih.';
            ktpPreviewWrap.classList.add('hidden');
            scanKtpBtn.disabled = true;
            setOcrStatus(message, false);
        }

        function setOcrStatus(message, success = null) {
            ocrStatus.textContent = message || '';
            ocrStatus.classList.remove('text-green-700', 'text-red-700', 'text-neutral/70');
            if (success === true) {
                ocrStatus.classList.add('text-green-700');
            } else if (success === false) {
                ocrStatus.classList.add('text-red-700');
            } else {
                ocrStatus.classList.add('text-neutral/70');
            }
        }

        function setProgress(percent) {
            ocrProgressWrap.classList.remove('hidden');
            ocrProgress.style.width = `${Math.round(percent * 100)}%`;
        }

        function hideProgress() {
            setTimeout(function() {
                ocrProgressWrap.classList.add('hidden');
                ocrProgress.style.width = '0%';
            }, 700);
        }

        async function scanKtpImage() {
            const file = ktpInput.files?.[0];
            if (!file) {
                setOcrStatus('Pilih foto KTP terlebih dahulu.', false);
                return;
            }

            if (typeof Tesseract === 'undefined') {
                setOcrStatus('Mesin scan belum siap. Periksa koneksi internet, lalu coba lagi.', false);
                return;
            }

            scanKtpBtn.disabled = true;
            pilihKtpBtn.disabled = true;
            setOcrStatus('Memindai KTP...', null);
            setProgress(0.05);

            try {
                let result;
                try {
                    result = await Tesseract.recognize(file, 'ind+eng', {
                        logger: function(message) {
                            if (message.status === 'recognizing text') {
                                setProgress(message.progress || 0.15);
                            }
                        }
                    });
                } catch (firstError) {
                    result = await Tesseract.recognize(file, 'eng', {
                        logger: function(message) {
                            if (message.status === 'recognizing text') {
                                setProgress(message.progress || 0.15);
                            }
                        }
                    });
                }

                const parsed = parseKtpText(result.data.text || '');
                let filled = 0;

                if (parsed.nik) {
                    fillField(nikInput, parsed.nik);
                    filled++;
                }
                if (parsed.nama) {
                    fillField(namaInput, parsed.nama);
                    filled++;
                }
                if (parsed.alamat) {
                    fillField(alamatInput, parsed.alamat);
                    filled++;
                }

                setProgress(1);

                if (filled > 0) {
                    setOcrStatus('Data KTP berhasil dibaca.', true);
                } else {
                    setOcrStatus('Data belum terbaca jelas. Isi manual atau upload foto yang lebih terang.', false);
                }
            } catch (error) {
                setOcrStatus('Scan gagal. Coba gunakan foto KTP yang lebih jelas.', false);
            } finally {
                scanKtpBtn.disabled = false;
                pilihKtpBtn.disabled = false;
                hideProgress();
            }
        }

        function fillField(field, value) {
            if (!field || !value) return;
            field.value = value.trim();
            field.classList.add('ring-2', 'ring-primary', 'bg-white');
            setTimeout(function() {
                field.classList.remove('ring-2', 'ring-primary', 'bg-white');
            }, 1400);
        }

        function cleanLine(line) {
            return line
                .replace(/[|]/g, 'I')
                .replace(/[{}[\]]/g, '')
                .replace(/\s+/g, ' ')
                .trim();
        }

        function cleanValue(value) {
            return cleanLine(value)
                .replace(/^[\s:;=\-.]+/, '')
                .replace(/[\s:;=\-.]+$/, '')
                .trim();
        }

        function extractAfterLabel(lines, labels) {
            for (let i = 0; i < lines.length; i++) {
                const line = lines[i];
                for (const label of labels) {
                    const pattern = new RegExp(`^.*${label}\\s*[:;=\-]?\\s*(.*)$`, 'i');
                    const match = line.match(pattern);
                    if (match) {
                        const sameLineValue = cleanValue(match[1] || '');
                        if (sameLineValue && sameLineValue.length > 1) return sameLineValue;

                        const nextLineValue = cleanValue(lines[i + 1] || '');
                        if (nextLineValue && nextLineValue.length > 1) return nextLineValue;
                    }
                }
            }
            return '';
        }

        function parseKtpText(rawText) {
            const normalizedText = rawText
                .toUpperCase()
                .replace(/[|]/g, 'I')
                .replace(/\r/g, '\n');

            const lines = normalizedText
                .split('\n')
                .map(cleanLine)
                .filter(Boolean);

            let nik = '';
            const nikByLabel = normalizedText.match(/N\s*I\s*K\s*[:;=\-]?\s*([0-9OIL\s]{16,24})/i);
            const nikLoose = normalizedText.match(/\b([0-9OIL][0-9OIL\s]{15,23})\b/);
            const nikCandidate = nikByLabel?.[1] || nikLoose?.[1] || '';
            const nikDigits = nikCandidate
                .replace(/O/g, '0')
                .replace(/[IL]/g, '1')
                .replace(/\D/g, '');
            if (nikDigits.length >= 16) {
                nik = nikDigits.substring(0, 16);
            }

            let nama = extractAfterLabel(lines, ['NAMA', 'NAMA LENGKAP']);
            nama = nama
                .replace(/\b(TEMPAT|TGL|LAHIR|JENIS|KELAMIN|GOL|DARAH|ALAMAT)\b.*$/i, '')
                .replace(/[^A-Z\s.'-]/g, '')
                .replace(/\s+/g, ' ')
                .trim();

            let alamat = '';
            const alamatIndex = lines.findIndex(function(line) {
                return /^.*ALAMAT\b/i.test(line);
            });

            if (alamatIndex !== -1) {
                const parts = [];
                const firstValue = cleanValue(lines[alamatIndex].replace(/^.*ALAMAT\s*[:;=\-]?\s*/i, ''));
                if (firstValue) parts.push(firstValue);

                const stopPattern =
                    /^(AGAMA|STATUS|PERKAWINAN|PEKERJAAN|KEWARGANEGARAAN|BERLAKU|HINGGA|TEMPAT|TGL|LAHIR|JENIS|KELAMIN|GOL|DARAH)\b/i;
                for (let i = alamatIndex + 1; i < lines.length && parts.length < 5; i++) {
                    const line = cleanValue(lines[i]);
                    if (!line || stopPattern.test(line)) break;

                    if (/^(RT|RW|DESA|KEL|KELURAHAN|KEC|KECAMATAN)\b/i.test(line) || parts.length < 2) {
                        parts.push(line);
                    }
                }

                alamat = parts
                    .join(', ')
                    .replace(/\s+/g, ' ')
                    .trim();
            }

            return {
                nik,
                nama,
                alamat
            };
        }
    </script>

</body>

</html>
