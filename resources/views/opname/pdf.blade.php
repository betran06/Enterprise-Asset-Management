<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Opname Aset</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }
        h2, h3 {
            text-align: center;
            margin: 0;
        }
        h3 {
            margin-bottom: 10px;
        }
        hr {
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }
        th {
            background-color: #f0f0f0;
            text-align: center;
        }
        .no-border td {
            border: none;
            padding: 4px;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>

<h2>LAPORAN OPNAME ASET</h2>
<h3>Sistem Inventaris Aset</h3>
<hr>

<table class="no-border">
    <tr>
        <td width="30%">Kode Opname</td>
        <td width="2%">:</td>
        <td>{{ $opname->kode_opname }}</td>
    </tr>
    <tr>
        <td>Nama Opname</td>
        <td>:</td>
        <td>{{ $opname->nama }}</td>
    </tr>
    <tr>
        <td>Tanggal Opname</td>
        <td>:</td>
        <td>{{ \Carbon\Carbon::parse($opname->tanggal_opname)->format('d-m-Y') }}</td>
    </tr>
    <tr>
        <td>Status</td>
        <td>:</td>
        <td>{{ $opname->status }}</td>
    </tr>
    <tr>
        <td>Petugas</td>
        <td>:</td>
        <td>{{ $opname->user->name }}</td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th width="4%">No</th>
            <th width="13%">Kode Aset</th>
            <th width="18%">Nama Aset</th>
            <th width="10%">Status Fisik</th>
            <th width="14%">Lokasi</th>
            <th width="14%">Karyawan</th>
            <th width="14%">Departemen</th>
            <th width="13%">Catatan</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($details as $row)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $row->aset->kode_aset }}</td>
                <td>{{ $row->aset->nama_aset }}</td>
                <td class="center">{{ $row->status_fisik }}</td>
                <td>{{ $row->lokasi->nama_lokasi ?? '-' }}</td>
                <td>{{ $row->karyawan->nama ?? '-' }}</td>
                <td>{{ $row->karyawan->departement ?? '-' }}</td>
                <td>{{ $row->catatan ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="center">Tidak ada data opname</td>
            </tr>
        @endforelse
    </tbody>
</table>

<br><br>

<table class="no-border">
    <tr>
        <td width="60%"></td>
        <td class="center">
            Dicetak pada:<br>
            {{ now()->format('d-m-Y') }}
        </td>
    </tr>
</table>

</body>
</html>
