@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Detail Penyusutan Aset</h1>
    <div class="ml-auto">
        <a href="{{ route('penyusutan.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="section-body">

    {{-- ===============================
        INFORMASI ASET
    ================================ --}}
    <div class="card card-primary mb-3">
        <div class="card-header">
            <h4>Informasi Aset</h4>
        </div>
        <div class="card-body">
            <table class="table table-sm">
                <tr>
                    <th width="200">Kode Aset</th>
                    <td>{{ $aset->kode_aset }}</td>
                </tr>
                <tr>
                    <th>Nama Aset</th>
                    <td>{{ $aset->nama_aset }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $aset->kategori->nama_kategori ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Lokasi</th>
                    <td>{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ===============================
        SETTING PENYUSUTAN
    ================================ --}}
    <div class="card card-warning mb-3">
        <div class="card-header">
            <h4>Setting Penyusutan</h4>
        </div>
        <div class="card-body">
            @if ($aset->penyusutanSetting)
                <table class="table table-sm">
                    <tr>
                        <th width="200">Metode</th>
                        <td>{{ $aset->penyusutanSetting->metode }}</td>
                    </tr>
                    <tr>
                        <th>Harga Perolehan</th>
                        <td>
                            Rp {{ number_format($aset->penyusutanSetting->harga_perolehan, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <th>Nilai Sisa</th>
                        <td>
                            Rp {{ number_format($aset->penyusutanSetting->nilai_sisa ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai Pakai</th>
                        <td>
                            {{ \Carbon\Carbon::parse($aset->penyusutanSetting->tgl_mulai_pakai)->format('d-m-Y') }}
                        </td>
                    </tr>
                </table>
            @else
                <div class="alert alert-secondary">
                    Setting penyusutan belum dibuat untuk aset ini.
                </div>
            @endif
        </div>
    </div>

    {{-- ===============================
        TOMBOL SUSUTKAN (PASTI MUNCUL)
    ================================ --}}
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('penyusutan.susutkan', $aset->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning">
                    <i class="fa fa-calculator"></i>
                    Susutkan Bulan Ini
                </button>
            </form>
        </div>
    </div>

    {{-- ===============================
            RIWAYAT PENYUSUTAN
    =============================== --}}
    <div class="card card-primary">
        <div class="card-header d-flex align-items-center">
            <h4 class="mb-0">Riwayat Penyusutan Bulanan</h4>

            <div class="ml-auto">
                @if ($aset->penyusutanBulanan->isNotEmpty())
                    <a href="{{ route('penyusutan.export-pdf', $aset->id) }}"
                    target="_blank"
                    class="btn btn-danger btn-sm">
                        <i class="fa fa-file-pdf"></i> Export PDF
                    </a>
                @else
                    <button class="btn btn-secondary btn-sm" disabled>
                        <i class="fa fa-file-pdf"></i> Export PDF
                    </button>
                @endif
            </div>
        </div>

        <div class="card-body">
            @if ($aset->penyusutanBulanan->isEmpty())
                <div class="alert alert-info">
                    Belum ada data penyusutan.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table-riwayat">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>Metode</th>
                                <th>Beban Bulan</th>
                                <th>Akumulasi</th>
                                <th>Nilai Buku Akhir</th>
                                <th>Diinput Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aset->penyusutanBulanan as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($row->periode)->format('m-Y') }}</td>
                                    <td>{{ $row->metode }}</td>
                                    <td>Rp {{ number_format($row->beban_bulan, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($row->akumulasi_sd_bulan, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($row->nilai_buku_akhir, 0, ',', '.') }}</td>
                                    <td>{{ optional($row->user)->name ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        $('#table-riwayat').DataTable();
    });
</script>
@endsection
