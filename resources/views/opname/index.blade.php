@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Daftar Opname Aset</h1>
    <div class="ml-auto">
        <a href="{{ route('opname.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Buat Opname Baru
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

    <div class="card card-primary">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table-opname">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Opname</th>
                            <th>Nama Opname</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Dibuat Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($opnames as $opname)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $opname->kode_opname }}</td>
                                <td>{{ $opname->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($opname->tanggal_opname)->format('d-m-Y') }}</td>
                                <td>
                                    @if ($opname->status === 'DRAFT')
                                        <span class="badge badge-warning">DRAFT</span>
                                    @else
                                        <span class="badge badge-success">FINAL</span>
                                    @endif
                                </td>
                                <td>{{ $opname->user->name }}</td>
                                <td>
                                    <a href="{{ route('opname.show', $opname->id) }}"
                                    class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i> Detail
                                    </a>

                                    @if ($opname->status === 'FINAL')
                                        <a href="{{ route('opname.pdf', $opname->id) }}"
                                        target="_blank"
                                        class="btn btn-danger btn-sm ml-1">
                                            <i class="fa fa-file-pdf"></i>
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
        $('#table-opname').DataTable();
    });
</script>
@endsection
