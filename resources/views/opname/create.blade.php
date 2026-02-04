@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Buat Opname Aset</h1>
    <div class="ml-auto">
        <a href="{{ route('opname.index') }}" class="btn btn-primary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="section-body">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('opname.store') }}" method="POST">
        @csrf

        <div class="card card-primary">
            <div class="card-header">
                <h4>Informasi Opname</h4>
            </div>

            <div class="card-body">

                <div class="form-group">
                    <label>Nama Opname <span class="text-danger">*</span></label>
                    <input type="text"
                           name="nama"
                           class="form-control"
                           placeholder="Contoh: Opname Semester 1 2026"
                           value="{{ old('nama') }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Tanggal Opname <span class="text-danger">*</span></label>
                    <input type="date"
                           name="tanggal_opname"
                           class="form-control"
                           value="{{ old('tanggal_opname', now()->toDateString()) }}"
                           required>
                </div>

                <div class="alert alert-info">
                    <b>Catatan:</b><br>
                    - Opname akan dibuat dengan status <b>DRAFT</b><br>
                    - Setelah dibuat, silakan input hasil opname per aset<br>
                    - Opname tidak bisa diubah setelah <b>FINAL</b>
                </div>

            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan & Lanjut Input
                </button>
            </div>
        </div>

    </form>

</div>
@endsection
