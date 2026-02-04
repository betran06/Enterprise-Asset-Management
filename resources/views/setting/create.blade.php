@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Buat Setting Penyusutan Aset</h1>
    <div class="ml-auto">
        <a href="{{ route('setting.index') }}" class="btn btn-primary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="section-body">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-primary">
        <div class="card-body">
            <form action="{{ route('setting.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Aset <span class="text-danger">*</span></label>
                    <select name="aset_id" class="form-control" required>
                        <option value="">-- Pilih Aset --</option>
                        @foreach ($asets as $aset)
                            <option value="{{ $aset->id }}"
                                {{ old('aset_id', request('aset_id')) == $aset->id ? 'selected' : '' }}>
                                {{ $aset->kode_aset }} - {{ $aset->nama_aset }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Metode Penyusutan <span class="text-danger">*</span></label>
                            <select name="metode" class="form-control" required>
                                <option value="GARIS_LURUS">Garis Lurus</option>
                                <option value="SALDO_MENURUN">Saldo Menurun</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kelompok DJP <span class="text-danger">*</span></label>
                            <select name="djp_kelompok_id" class="form-control" required>
                                <option value="">-- Pilih Kelompok DJP --</option>
                                @foreach ($djpKelompoks as $row)
                                    <option value="{{ $row->id }}">
                                        {{ $row->nama }} ({{ $row->masa_manfaat_tahun }} tahun)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Harga Perolehan <span class="text-danger">*</span></label>
                            <input type="number" name="harga_perolehan" class="form-control"
                                   value="{{ old('harga_perolehan') }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nilai Sisa</label>
                            <input type="number" name="nilai_sisa" class="form-control"
                                   value="{{ old('nilai_sisa') }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Umur (bulan)</label>
                            <input type="number" name="umur_bulan" class="form-control"
                                   placeholder="Opsional (auto dari DJP)">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tanggal Mulai Pakai <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_mulai_pakai"
                           value="{{ old('tgl_mulai_pakai') }}"
                           class="form-control" required>
                    <small class="text-muted">
                        Penyusutan dimulai bulan berikutnya.
                    </small>
                </div>

                <div class="text-right">
                    <button class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan Setting
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
