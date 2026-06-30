<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export PDF - Laporan SIMBO</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2,
        .header h3,
        .header p {
            margin: 0;
            padding: 2px;
        }

        .header h2 {
            font-size: 18px;
            text-transform: uppercase;
        }

        .header h3 {
            font-size: 16px;
        }

        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #999;
        }

        th {
            background-color: #f2f2f2;
            padding: 8px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
        }

        td {
            padding: 8px;
            vertical-align: top;
            font-size: 11px;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            width: 100%;
        }

        .signature {
            float: right;
            width: 250px;
            text-align: center;
        }

        .signature p {
            margin: 5px 0;
        }

        .signature .space {
            height: 70px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>PEMERINTAH KOTA BOGOR</h2>
        <h3>SISTEM PELAPORAN MASYARAKAT (SIMBO)</h3>
        <p>Jl. Ir. H. Juanda No.10, Kota Bogor, Jawa Barat</p>
    </div>

    <div class="title">
        Rekapitulasi Data Laporan Masyarakat
    </div>

    <p>Tanggal Cetak : {{ \Carbon\Carbon::now()->format('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="10%">ID Lap.</th>
                <th width="12%">Tanggal</th>
                <th width="15%">Nama Pelapor</th>
                <th width="15%">Kategori</th>
                <th width="28%">Judul Laporan</th>
                <th width="15%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporan as $index => $item)
                @php
                    $status = ucfirst($item->status_laporan ?? 'Menunggu');
                    // Menyederhanakan penamaan ID agar rapi di tabel PDF
                    $idFormat = '#' . str_pad($item->id_laporan, 3, '0', STR_PAD_LEFT);
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $idFormat }}</td>
                    <td>{{ optional($item->tanggal_laporan)->format('d-m-Y') }}</td>
                    <td>{{ $item->masyarakat->nama_lengkap ?? '-' }}</td>
                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $item->judul_laporan }}</td>
                    <td class="text-center">{{ $status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px;">Tidak ada data laporan untuk kriteria
                        ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Bogor, {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
            <p>Petugas SIMBO</p>
            <div class="space"></div>
            <p><strong>{{ Auth::guard('petugas')->user()->nama_petugas ?? 'Admin / Petugas' }}</strong></p>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>

</html>
