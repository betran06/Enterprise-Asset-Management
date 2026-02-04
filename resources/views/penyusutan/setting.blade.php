@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Setting Penyusutan Aset</h1>
    <div class="ml-auto">
        <a href="{{ route('penyusutan.show', $aset->id) }}" class="btn btn-primary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="section-body">

    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ $aset->nama_aset }} ({{ $aset->kode_aset }})</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('setting.store', $aset->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Metode Penyusutan <span class="text-danger">*</span></label>
                    <select name="metode" class="form-control" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="GARIS_LURUS">Garis Lurus</option>
                        <option value="SALDO_MENURUN">Saldo Menurun</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kelompok DJP <span class="text-danger">*</span></label>
                    <select name="djp_kelompok_id" class="form-control" required>
                        @foreach ($kelompoks as $djp)
                            <option value="{{ $djp->id }}">
                                {{ $djp->nama }} ({{ $djp->masa_manfaat_tahun }} th)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Harga Perolehan <span class="text-danger">*</span></label>
                    <input type="number" name="harga_perolehan" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Nilai Sisa (Opsional)</label>
                    <input type="number" name="nilai_sisa" class="form-control">
                </div>

                <div class="form-group">
                    <label>Tanggal Mulai Pakai <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_mulai_pakai" class="form-control" required>
                    <small class="text-muted">
                        Penyusutan dimulai bulan berikutnya
                    </small>
                </div>

                <button type="submit" class="btn btn-primary float-right">
                    Simpan Setting
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
