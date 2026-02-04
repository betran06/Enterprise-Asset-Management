@extends('layouts.main')

@section('content')
    <div class="section-header">
        <h1>Tambah Kategori</h1>
        <div class="ml-auto">
            <a href="{{ route('kategori.index') }}" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col">
                <div class="card card-primary">
                    <div class="card-body">
                        <form action="{{ route('kategori.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="nama_kategori">Kategori <span class="text-danger">*</span></label>
                                <input
                                    id="nama_kategori"
                                    type="text"
                                    class="form-control @error('nama_kategori') is-invalid @enderror"
                                    name="nama_kategori"
                                    value="{{ old('nama_kategori') }}"
                                    maxlength="50"
                                    required
                                >
                                @error('nama_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
