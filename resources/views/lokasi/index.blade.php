@extends('layouts.main')

@section('content')
    <div class="section-header">
        <h1>Data Lokasi</h1>
        <div class="ml-auto">
            <a href="{{ route('lokasi.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Lokasi</a>
        </div>
    </div>

    <div class="section-body">
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <div class="col">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_id" class="table table-bordered table-hover table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Lokasi</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lokasis as $lokasi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            {{-- gunakan field sesuai migrasi/model --}}
                                            <td>{{ $lokasi->nama_lokasi }}</td>
                                            <td>
                                                <a href="{{ route('lokasi.edit', $lokasi->id) }}" class="btn btn-warning">Edit</a>

                                                <form id="delete-form-{{ $lokasi->id }}"
                                                      action="{{ route('lokasi.destroy', $lokasi->id) }}"
                                                      method="POST" class="d-inline">
                                                    @method('DELETE')
                                                    @csrf

                                                    {{-- tombol bertipe button agar JS swal-confirm bisa mencegah submit --}}
                                                    <button type="button"
                                                            class="btn btn-danger swal-confirm"
                                                            data-form="delete-form-{{ $lokasi->id }}">
                                                        Hapus
                                                    </button>
                                                </form>
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

    <!-- Datatables Jquery -->
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable();
        });
    </script>
@endsection
