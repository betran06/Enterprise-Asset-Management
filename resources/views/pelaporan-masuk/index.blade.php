@extends('layouts.main')

@section('content')
    <div class="section-header">
        <h1>Pelaporan Perbaikan Masuk</h1>
    </div>

    <div class="section-body">
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
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
                                        <th>Judul</th>
                                        <th>Status</th>
                                        <th>Nama Aset</th>
                                        <th>Lokasi</th>
                                        <th>Lihat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pelaporans as $pelaporan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pelaporan->judul }}</td>
                                            <td>
                                                @if ($pelaporan->status === 'Menunggu')
                                                    <span class="badge badge-warning m-2">Menunggu</span>
                                                @elseif ($pelaporan->status === 'Sedang Diperbaiki')
                                                    <span class="badge badge-primary m-2">Sedang Diperbaiki</span>
                                                @elseif ($pelaporan->status === 'Selesai')
                                                    <span class="badge badge-success m-2">Selesai</span>
                                                @else
                                                    <span class="badge badge-secondary m-2">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $pelaporan->aset->nama_aset ?? '-' }}</td>
                                            <td>{{ $pelaporan->aset->lokasi->nama_lokasi ?? '-' }}</td>
                                            <td>
                                                <a href="/pelaporan-masuk/detail/{{ $pelaporan->id }}"
                                                    class="btn btn-success btn-sm">Detail</a>
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
        $(document).ready(function() {
            $('#table_id').DataTable();
        });
    </script>
@endsection
