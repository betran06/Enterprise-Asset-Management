@extends('layouts.main')

@section('content')
    <div class="section-header">
        <h1>Data Karyawan</h1>
        <div class="ml-auto">
            @if (auth()->user()->inRoles(['admin','manager']))
                <a href="/karyawan/create" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Tambah Karyawan
                </a>
            @endif
        </div>
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
                            <table id="table_id" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Karyawan</th>
                                        <th>Nama</th>
                                        <th>Departemen</th>
                                        <th>Jabatan</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($karyawans as $karyawan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $karyawan->kode_karyawan }}</td>
                                            <td>{{ $karyawan->nama }}</td>
                                            <td>{{ $karyawan->departement ?? '-' }}</td>
                                            <td>{{ $karyawan->jabatan ?? '-' }}</td>
                                            <td>
                                                @if (auth()->user()->inRoles(['admin','manager']))
                                                    <a href="/karyawan/{{ $karyawan->id }}/edit"
                                                    class="btn btn-warning btn-sm">
                                                        Edit
                                                    </a>

                                                    <form id="hapus{{ $karyawan->id }}"
                                                        action="/karyawan/{{ $karyawan->id }}"
                                                        method="POST"
                                                        class="d-inline">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button"
                                                                class="btn btn-danger btn-sm swal-confirm"
                                                                data-form="hapus{{ $karyawan->id }}">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge badge-secondary">Readonly</span>
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
        </div>
    </div>

    {{-- Datatable --}}
    <script>
        $(document).ready(function () {
            $('#table_id').DataTable();
        });
    </script>
@endsection
