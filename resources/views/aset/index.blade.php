@extends('layouts.main')

@section('content')
    <div class="section-header">
        <h1>Data Aset</h1>
        <div class="ml-auto">
            <a href="{{ route('aset.export.excel') }}"
                class="btn btn-success mr-2">
                <i class="fa fa-file-excel"></i> Export Excel
            </a>

            {{-- Export code --}}
            <a href="{{ route('aset.export.pdf') }}"
               target="_blank"
               class="btn btn-danger mr-2">
                <i class="fa fa-file-pdf"></i> Export QrCode
            </a>

            {{-- Export Laporan Keseluruhan --}}
            <a href="{{ route('aset.export.keseluruhan') }}"
            target="_blank"
            class="btn btn-danger mr-2">
                <i class="fa fa-file-pdf"></i> Export Laporan
            </a>

            <a href="{{ route('aset.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Aset
            </a>
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
                            <table id="table_id"
                                   class="table table-bordered table-hover table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="20%">Gambar</th>
                                        <th width="20%">Kode Aset</th>
                                        <th>Nama Aset</th>
                                        <th width="20%">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($asets as $aset)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td class="text-center">
                                                @if ($aset->gambar && Storage::disk('public')->exists($aset->gambar))
                                                    <img src="{{ Storage::url($aset->gambar) }}"
                                                         alt="gambar aset"
                                                         style="width:150px; height:150px; object-fit:cover; border-radius:4px;">
                                                @else
                                                    <div style="
                                                        width:150px;
                                                        height:150px;
                                                        display:flex;
                                                        align-items:center;
                                                        justify-content:center;
                                                        border:1px solid #ddd;
                                                        color:#777;">
                                                        No Image
                                                    </div>
                                                @endif
                                            </td>

                                            <td>{{ $aset->kode_aset }}</td>
                                            <td>{{ $aset->nama_aset }}</td>
                                            <td>
                                                <a href="{{ route('aset.show', $aset->id) }}"
                                                   class="btn btn-success btn-sm">
                                                    Detail
                                                </a>

                                                <a href="{{ route('aset.edit', $aset->id) }}"
                                                   class="btn btn-warning btn-sm">
                                                    Edit
                                                </a>

                                                <form id="delete-form-{{ $aset->id }}"
                                                      action="{{ route('aset.destroy', $aset->id) }}"
                                                      method="POST"
                                                      class="d-inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="button"
                                                            class="btn btn-danger btn-sm swal-confirm"
                                                            data-form="delete-form-{{ $aset->id }}">
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

    <script>
        $(document).ready(function () {
            $('#table_id').DataTable();
        });
    </script>
@endsection
