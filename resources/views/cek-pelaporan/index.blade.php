@extends('layouts.main')

@section('content')
    <div class="section-header">
        <h1>Cek Status Pelaporan</h1>
    </div>

    <div class="section-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_id" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Status</th>
                                        <th>Nama Aset</th>
                                        <th>Lokasi</th>
                                        <th>Tanggal Pelaporan</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pelaporans as $pelaporan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pelaporan->judul }}</td>
                                            <td>
                                                @if ($pelaporan->status === 'Menunggu')
                                                    <span class="badge badge-warning">Menunggu</span>
                                                @elseif ($pelaporan->status === 'Proses Pengecekan')
                                                    <span class="badge badge-primary">Proses Pengecekan</span>
                                                @elseif ($pelaporan->status === 'Selesai')
                                                    <span class="badge badge-success">Selesai</span>
                                                @else
                                                    <span class="badge badge-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $pelaporan->aset->nama_aset ?? '-' }}</td>
                                            <td>{{ $pelaporan->aset->lokasi->nama_lokasi ?? '-' }}</td>
                                            <td>{{ $pelaporan->created_at->format('d-m-Y H:i') }}</td>
                                            <td>
                                                <a href="{{ url('/cek-pelaporan/detail/' . $pelaporan->id) }}"
                                                   class="btn btn-sm btn-primary">
                                                    Detail
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

    {{-- Datatables --}}
    <script>
        $(document).ready(function () {
            $('#table_id').DataTable();
        });
    </script>
@endsection
