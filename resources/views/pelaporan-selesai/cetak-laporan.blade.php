<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Perbaikan Aset</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .container {
            border: 1px solid #000;
            padding: 15px;
        }

        .header {
            text-align: center;
        }

        .header h2 {
            margin: 0;
        }

        hr {
            margin: 12px 0;
            border: 0;
            border-top: 1px solid #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 4px 2px;
            vertical-align: top;
        }

        .label {
            width: 30%;
            font-weight: bold;
        }

        .separator {
            width: 3%;
            text-align: center;
        }

        .value {
            width: 67%;
        }

        .section-title {
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <h2>LAPORAN PERBAIKAN ASET</h2>
        <p>Sistem Informasi Inventaris Aset</p>
    </div>

    <hr>

    <table>
        <tr>
            <td class="label">Judul Pelaporan</td>
            <td class="separator">:</td>
            <td class="value">{{ $pelaporan->judul }}</td>
        </tr>
        <tr>
            <td class="label">Deskripsi Pelaporan</td>
            <td class="separator">:</td>
            <td class="value">{!! $pelaporan->deskripsi !!}</td>
        </tr>
        <tr>
            <td class="label">Nama Aset</td>
            <td class="separator">:</td>
            <td class="value">{{ $pelaporan->aset?->nama_aset ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Kode Aset</td>
            <td class="separator">:</td>
            <td class="value">{{ $pelaporan->aset?->kode_aset ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Merek</td>
            <td class="separator">:</td>
            <td class="value">{{ $pelaporan->aset?->merek ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Kategori</td>
            <td class="separator">:</td>
            <td class="value">{{ $pelaporan->aset?->kategori?->nama_kategori ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Lokasi</td>
            <td class="separator">:</td>
            <td class="value">{{ $pelaporan->aset?->lokasi?->nama_lokasi ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Pelaporan</td>
            <td class="separator">:</td>
            <td class="value">{{ $pelaporan->created_at->format('d-m-Y H:i') }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Selesai</td>
            <td class="separator">:</td>
            <td class="value">{{ $pelaporan->updated_at->format('d-m-Y H:i') }}</td>
        </tr>
    </table>

    <hr>

    <div class="section-title">Analisis Perbaikan</div>
    <table>
        <tr>
            <td class="label">Analisis Admin</td>
            <td class="separator">:</td>
            <td class="value">
                {{ $feedback?->analisis_keputusan ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="label">Feedback User</td>
            <td class="separator">:</td>
            <td class="value">
                {{ $feedbackReply?->feedback_reply ?? '-' }}
            </td>
        </tr>
    </table>

    <div class="footer">
        <p>
            Dicetak pada: {{ now()->format('d-m-Y H:i') }} <br>
            Oleh Sistem Inventaris
        </p>
    </div>

</div>
</body>
</html>
