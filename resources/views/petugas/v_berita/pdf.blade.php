<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Berita SIMBO</title>
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
        <h3>SISTEM PELAPORAN MASYARAKAT (SIMBO) - PORTAL BERITA</h3>
        <p>Jl. Ir. H. Juanda No.10, Kota Bogor, Jawa Barat</p>
    </div>

    <div class="title">
        Rekapitulasi Data Berita & Publikasi
    </div>

    <p>Tanggal Cetak : {{ \Carbon\Carbon::now()->format('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="10%">ID Berita</th>
                <th width="15%">Tgl Publish</th>
                <th width="15%">Kategori</th>
                <th width="35%">Judul Berita</th>
                <th width="15%">Penulis</th>
                <th width="10%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($berita as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">#{{ str_pad($item->id_berita, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ optional($item->tanggal_publish)->format('d-m-Y H:i') }}</td>
                    <td>{{ optional($item->kategori)->nama_kategori ?? 'Umum' }}</td>
                    <td>{{ $item->judul_berita }}</td>
                    <td>{{ optional($item->petugas)->nama_petugas ?? '-' }}</td>
                    <td class="text-center">{{ ucfirst($item->status_arsip) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px;">Tidak ada data berita untuk kriteria
                        ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Bogor, {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
            <p>Admin Portal Berita</p>
            <div class="space"></div>
            <p><strong>{{ Auth::guard('petugas')->user()->nama_petugas ?? 'Petugas' }}</strong></p>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>

</html>
