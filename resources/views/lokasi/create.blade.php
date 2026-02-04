@extends('layouts.main')

@section('content')
    <div class="section-header">
        <h1>Tambah Data Lokasi</h1>
        <div class="ml-auto">
            <a href="{{ route('lokasi.index') }}" class="btn btn-primary"><i class="fa fa-back"></i> Kembali</a>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col">
                <div class="card card-primary">
                    <div class="card-body">
                        <form action="{{ route('lokasi.store') }}" method="POST" novalidate>
                            @csrf

                            <div class="form-group">
                                <label for="nama_lokasi">Lokasi <span class="text-danger">*</span></label>
                                <input id="nama_lokasi"
                                       type="text"
                                       class="form-control @error('nama_lokasi') is-invalid @enderror"
                                       name="nama_lokasi"
                                       value="{{ old('nama_lokasi') }}"
                                       required
                                       aria-describedby="namaLokasiHelp">
                                @error('nama_lokasi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small id="namaLokasiHelp" class="form-text text-muted">Nama lokasi maksimal 50 karakter.</small>
                            </div>

                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
