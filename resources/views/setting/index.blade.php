@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Setting Penyusutan Aset</h1>
    <div class="ml-auto">
        <a href="{{ route('setting.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Buat Setting
        </a>
    </div>
</div>

<div class="section-body">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card card-primary">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table-setting">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Aset</th>
                            <th>Nama Aset</th>
                            <th>Kategori</th>
                            <th>Metode</th>
                            <th>Status Setting</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($asets as $aset)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $aset->kode_aset }}</td>
                                <td>{{ $aset->nama_aset }}</td>
                                <td>{{ $aset->kategori->nama_kategori ?? '-' }}</td>
                                <td>
                                    @if ($aset->penyusutanSetting)
                                        <span class="badge badge-info">
                                            {{ $aset->penyusutanSetting->metode }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($aset->penyusutanSetting)
                                        <span class="badge badge-success">Sudah Diset</span>
                                    @else
                                        <span class="badge badge-secondary">Belum Diset</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($aset->penyusutanSetting)
                                        <a href="{{ route('setting.edit', $aset->id) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    @else
                                        <a href="{{ route('setting.create', ['aset_id' => $aset->id]) }}"
                                           class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i> Buat
                                        </a>
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
        $('#table-setting').DataTable();
    });
</script>
@endsection
