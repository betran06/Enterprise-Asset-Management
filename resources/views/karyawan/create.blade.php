@extends('layouts.main')

@section('content')
    <div class="section-header">
        <h1>Tambah Data Karyawan</h1>
        <div class="ml-auto">
            <a href="/karyawan" class="btn btn-primary">
                <i class="fa fa-back"></i> Kembali
            </a>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-body">

                        <form action="/karyawan" method="POST">
                            @csrf

                            <div class="form-group">
                                <label>Kode Karyawan <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="kode_karyawan"
                                       class="form-control"
                                       value="{{ old('kode_karyawan') }}"
                                       required>
                                @error('kode_karyawan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Nama Karyawan <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="nama"
                                       class="form-control"
                                       value="{{ old('nama') }}"
                                       required>
                                @error('nama')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Departemen</label>
                                <input type="text"
                                       name="departement"
                                       class="form-control"
                                       value="{{ old('departement') }}">
                            </div>

                            <div class="form-group">
                                <label>Jabatan</label>
                                <input type="text"
                                       name="jabatan"
                                       class="form-control"
                                       value="{{ old('jabatan') }}">
                            </div>

                            <button type="submit" class="btn btn-primary float-right">
                                Simpan
                            </button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
