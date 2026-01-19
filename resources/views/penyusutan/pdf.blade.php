<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penyusutan Aset</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2, h3 {
            text-align: center;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background: #f0f0f0;
        }
        .no-border td {
            border: none;
            padding: 4px;
        }
        .right {
            text-align: right;
        }
    </style>
</head>
<body>

<h2>LAPORAN PENYUSUTAN ASET</h2>
<h3>Sistem Informasi Inventaris Aset</h3>

<hr>
<table class="no-border">
    <tr>
        <td width="30%">Kode Aset</td>
        <td width="2%">:</td>
        <td>{{ $aset->kode_aset }}</td>
    </tr>
    <tr>
        <td>Nama Aset</td>
        <td>:</td>
        <td>{{ $aset->nama_aset }}</td>
    </tr>
    <tr>
        <td>Kategori</td>
        <td>:</td>
        <td>{{ $aset->kategori->nama_kategori ?? '-' }}</td>
    </tr>
    <tr>
        <td>Lokasi</td>
        <td>:</td>
        <td>{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
    </tr>
</table>

<h4>Parameter Penyusutan Aset</h4>
<table>
    <tr>
        <th width="30%">Metode Penyusutan</th>
        <td>{{ $setting->metode }}</td>
    </tr>
    <tr>
        <th>Kelompok DJP</th>
        <td>{{ $setting->djpKelompok->nama ?? '-' }}</td>
    </tr>
    <tr>
        <th>Masa Manfaat</th>
        <td>{{ $setting->djpKelompok->masa_manfaat_tahun ?? 0 }} Tahun</td>
    </tr>
    <tr>
        <th>Harga Perolehan</th>
        <td class="right">
            Rp {{ number_format($setting->harga_perolehan, 0, ',', '.') }}
        </td>
    </tr>
    <tr>
        <th>Nilai Sisa</th>
        <td class="right">
            Rp {{ number_format($setting->nilai_sisa ?? 0, 0, ',', '.') }}
        </td>
    </tr>
    <tr>
        <th>Tanggal Mulai Pakai</th>
        <td>
            {{ \Carbon\Carbon::parse($setting->tgl_mulai_pakai)->format('d-m-Y') }}
        </td>
    </tr>
</table>

<h4>Riwayat Penyusutan Bulanan</h4>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Periode</th>
            <th>Metode</th>
            <th>Beban Bulan</th>
            <th>Akumulasi</th>
            <th>Nilai Buku Akhir</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($riwayat as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($row->periode)->format('m-Y') }}</td>
                <td>{{ $row->metode }}</td>
                <td class="right">
                    Rp {{ number_format($row->beban_bulan, 0, ',', '.') }}
                </td>
                <td class="right">
                    Rp {{ number_format($row->akumulasi_sd_bulan, 0, ',', '.') }}
                </td>
                <td class="right">
                    Rp {{ number_format($row->nilai_buku_akhir, 0, ',', '.') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" align="center">
                    Belum ada data penyusutan
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<br><br>

<table class="no-border">
    <tr>
        <td width="70%"></td>
        <td align="center">
            Dicetak pada:<br>
            {{ now()->format('d-m-Y') }}
        </td>
    </tr>
</table>

</body>
</html>