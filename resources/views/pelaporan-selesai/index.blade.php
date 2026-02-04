@extends('layouts.main')

@section('content')
    <div class="section-header">
        <h1>Pelaporan Perbaikan Selesai</h1>
    </div>

    <div class="section-body">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_id"
                                   class="table table-bordered table-hover table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Pelaporan</th>
                                        <th>Status</th>
                                        <th>Nama Aset</th>
                                        <th>Lokasi</th>
                                        <th>Tgl. Pelaporan</th>
                                        <th>Selesai Perbaikan</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pelaporans as $pelaporan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pelaporan->judul }}</td>
                                            <td>
                                                <span class="badge badge-success">
                                                    {{ $pelaporan->status }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $pelaporan->aset?->nama_aset ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $pelaporan->aset?->lokasi?->nama_lokasi ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $pelaporan->created_at->format('d-m-Y H:i') }}
                                            </td>
                                            <td>
                                                {{ $pelaporan->updated_at->format('d-m-Y H:i') }}
                                            </td>
                                            <td>
                                                <a href="/pelaporan-selesai/cetak-laporan/{{ $pelaporan->id }}"
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fa fa-print"></i> Print
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#table_id').DataTable();
        });
    </script>
@endsection
