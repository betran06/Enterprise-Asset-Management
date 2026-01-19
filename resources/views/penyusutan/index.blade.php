@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Penyusutan Aset</h1>
</div>

<div class="section-body">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card card-primary">
        <div class="card-header">
            <h4>Daftar Aset & Penyusutan</h4>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table-penyusutan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Aset</th>
                            <th>Nama Aset</th>
                            <th>Metode</th>
                            <th>Harga Perolehan</th>
                            <th>Nilai Buku Terakhir</th>
                            <th>Periode Terakhir</th>
                            <th>Status</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($asets as $aset)
                            @php
                                $last = $aset->penyusutanBulanan->first();
                                $setting = $aset->penyusutanSetting;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $aset->kode_aset }}</td>
                                <td>{{ $aset->nama_aset }}</td>
                                <td>
                                    {{ $setting?->metode ?? '-' }}
                                </td>
                                <td>
                                    {{ $setting ? number_format($setting->harga_perolehan, 0, ',', '.') : '-' }}
                                </td>
                                <td>
                                    {{ $last ? number_format($last->nilai_buku_akhir, 0, ',', '.') : '-' }}
                                </td>
                                <td>
                                    {{ $last?->periode ?? '-' }}
                                </td>
                                <td>
                                    @if (!$setting)
                                        <span class="badge badge-secondary">Belum Disetting</span>
                                    @elseif ($setting->is_disposed)
                                        <span class="badge badge-danger">Disposed</span>
                                    @else
                                        <span class="badge badge-success">Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('penyusutan.show', $aset->id) }}"
                                       class="btn btn-info btn-sm">
                                        Detail
                                    </a>

                                    @if (auth()->user()->inRoles(['admin','manager']) && $setting && !$setting->is_disposed)
                                        <form action="{{ route('penyusutan.susutkan', $aset->id) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-warning btn-sm"
                                                    onclick="return confirm('Generate penyusutan bulan ini?')">
                                                Susutkan
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#table-penyusutan').DataTable();
    });
</script>
@endsection
