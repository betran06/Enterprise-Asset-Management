<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Aset</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background: #f0f0f0;
        }
        img {
            width: 80px;
        }
    </style>
</head>
<body>

<h2>DAFTAR ASET INVENTARIS</h2>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="25%">Kode Aset</th>
            <th width="40%">Nama Aset</th>
            <th width="30%">QR Code</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($asets as $aset)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $aset->kode_aset }}</td>
                <td>{{ $aset->nama_aset }}</td>
                <td>
                    @php
                        $qrPath = public_path('storage/qrcode/' . $aset->kode_aset . '.png');
                    @endphp

                    @if (file_exists($qrPath))
                        <img src="{{ $qrPath }}">
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<br><br>

<p style="text-align:right">
    Dicetak pada: {{ now()->format('d-m-Y') }}
</p>

</body>
</html>
