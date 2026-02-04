@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Disposal Aset</h1>
    <div class="ml-auto">
        <a href="{{ route('penyusutan.show', $aset->id) }}" class="btn btn-primary">
            Kembali
        </a>
    </div>
</div>

<div class="section-body">
    <div class="card card-danger">
        <div class="card-header">
            <h4>Form Disposal Aset</h4>
        </div>

        <form action="{{ route('penyusutan.dispose.store', $aset->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="alert alert-warning">
                    <b>Perhatian:</b>  
                    Setelah aset didisposal, penyusutan <u>tidak dapat dilanjutkan</u>.
                </div>

                <div class="form-group">
                    <label>Kode Aset</label>
                    <input class="form-control" value="{{ $aset->kode_aset }}" disabled>
                </div>

                <div class="form-group">
                    <label>Nama Aset</label>
                    <input class="form-control" value="{{ $aset->nama_aset }}" disabled>
                </div>

                <div class="form-group">
                    <label>Alasan Disposal <span class="text-danger">*</span></label>
                    <select name="alasan_disposed" class="form-control" required>
                        <option value="">-- Pilih Alasan --</option>
                        <option value="RUSAK">Rusak</option>
                        <option value="DIJUAL">Dijual</option>
                        <option value="HIBAH">Hibah</option>
                        <option value="HILANG">Hilang</option>
                        <option value="LAINNYA">Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Catatan Disposal</label>
                    <textarea name="catatan_disposal" class="form-control" rows="4" placeholder="Opsional"></textarea>
                </div>

            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-trash"></i> Konfirmasi Disposal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
