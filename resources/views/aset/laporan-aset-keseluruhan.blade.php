<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Aset</title>
<style>
    body {
        font-family: DejaVu Sans;
        font-size: 11px;
    }

    .header {
        text-align: center;
        margin-bottom: 15px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #000;
        padding: 4px;
    }

    th {
        background-color: #f2f2f2;
    }

    .footer {
        margin-top: 40px;
        text-align: right;
    }
</style>
</head>
<body>

<div class="header">
    <h2>PT. Astra Inovasi Teknologi</h2>
    <h4>LAPORAN KESELURUHAN DATA ASET</h4>
    <p>Tanggal Cetak: {{ $tanggal }}</p>
    <p>Total Aset: {{ $total }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Merek</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Pengguna</th>
            <th>Tgl Masuk</th>
        </tr>
    </thead>
    <tbody>
        @foreach($asets as $index => $aset)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $aset->kode_aset }}</td>
            <td>{{ $aset->nama_aset }}</td>
            <td>{{ $aset->merek ?? '-' }}</td>
            <td>{{ $aset->kategori->nama_kategori ?? '-' }}</td>
            <td>{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
            <td>{{ $aset->karyawan->nama ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($aset->tgl_penambahan)->format('d-m-Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    <p>Mengetahui,</p>
    <br><br><br>
    <p>_________________________</p>
    <p>Manager</p>
</div>

</body>
</html>