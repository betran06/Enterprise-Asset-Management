@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Detail Opname</h1>
    <div class="ml-auto">
        <a href="{{ route('opname.index') }}" class="btn btn-primary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="section-body">

    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card card-primary mb-3">
        <div class="card-header">
            <h4>Informasi Opname</h4>
        </div>
        <div class="card-body">
            <table class="table table-sm">
                <tr>
                    <th width="200">Kode Opname</th>
                    <td>{{ $opname->kode_opname }}</td>
                </tr>
                <tr>
                    <th>Nama Opname</th>
                    <td>{{ $opname->nama }}</td>
                </tr>
                <tr>
                    <th>Tanggal Opname</th>
                    <td>{{ \Carbon\Carbon::parse($opname->tanggal_opname)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if ($opname->status === 'DRAFT')
                            <span class="badge badge-warning">DRAFT</span>
                        @else
                            <span class="badge badge-success">FINAL</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Dibuat Oleh</th>
                    <td>{{ $opname->user->name }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">

            @if ($opname->status === 'DRAFT')
                <a href="{{ route('opname.input', $opname->id) }}"
                   class="btn btn-primary">
                    <i class="fa fa-plus"></i> Input Aset
                </a>

                <form action="{{ route('opname.final', $opname->id) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('Finalisasi opname? Data tidak bisa diubah.')">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-lock"></i> Finalisasi
                    </button>
                </form>
            @endif

            @if ($opname->status === 'FINAL')
                <a href="{{ route('opname.pdf', $opname->id) }}"
                   target="_blank"
                   class="btn btn-danger">
                    <i class="fa fa-file-pdf"></i> Export PDF
                </a>
            @endif

        </div>
    </div>


    <div class="card card-primary">
        <div class="card-header">
            <h4>Hasil Opname Aset</h4>
        </div>
        <div class="card-body">
            @if ($details->isEmpty())
                <div class="alert alert-info">
                    Belum ada aset yang diinput.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table-opname">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Aset</th>
                                <th>Nama Aset</th>
                                <th>Status Fisik</th>
                                <th>Lokasi</th>
                                <th>Karyawan</th>
                                <th>Departemen</th>
                                <th>Catatan</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->aset->kode_aset }}</td>
                                    <td>{{ $row->aset->nama_aset }}</td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $row->status_fisik }}
                                        </span>
                                    </td>
                                    <td>{{ $row->lokasi->nama_lokasi ?? '-' }}</td>
                                    <td>{{ $row->karyawan->nama ?? '-' }}</td>
                                    <td>{{ $row->karyawan->departement ?? '-' }}</td>
                                    <td>{{ $row->catatan ?? '-' }}</td>
                                    <td>{{ $row->user->name }}</td>
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
        $('#table-opname').DataTable();
    });
</script>
@endsection
