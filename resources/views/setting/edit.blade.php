@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Edit Setting Penyusutan Aset</h1>
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

    <div class="card card-warning">
        <div class="card-body">
            <form action="{{ route('setting.update', $setting->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Aset</label>
                    <input type="text" class="form-control" disabled
                        value="{{ $setting->aset->kode_aset }} - {{ $setting->aset->nama_aset }}">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Metode Penyusutan <span class="text-danger">*</span></label>
                            <select name="metode" class="form-control" required>
                                <option value="GARIS_LURUS"
                                    {{ $setting->metode === 'GARIS_LURUS' ? 'selected' : '' }}>
                                    Garis Lurus
                                </option>
                                <option value="SALDO_MENURUN"
                                    {{ $setting->metode === 'SALDO_MENURUN' ? 'selected' : '' }}>
                                    Saldo Menurun
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kelompok DJP <span class="text-danger">*</span></label>
                            <select name="djp_kelompok_id" class="form-control" required>
                                @foreach ($djpKelompoks as $row)
                                    <option value="{{ $row->id }}"
                                        {{ $setting->djp_kelompok_id == $row->id ? 'selected' : '' }}>
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
                                value="{{ $setting->harga_perolehan }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nilai Sisa</label>
                            <input type="number" name="nilai_sisa" class="form-control"
                                value="{{ $setting->nilai_sisa }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Umur (bulan)</label>
                            <input type="number" name="umur_bulan" class="form-control"
                                value="{{ $setting->umur_bulan }}">
                            <small class="text-muted">
                                Kosongkan untuk mengikuti DJP
                            </small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tanggal Mulai Pakai <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_mulai_pakai"
                        value="{{ \Carbon\Carbon::parse($setting->tgl_mulai_pakai)->format('Y-m-d') }}"
                        class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Status Aset</label>
                    <select name="is_disposed" class="form-control">
                        <option value="0" {{ !$setting->is_disposed ? 'selected' : '' }}>Aktif</option>
                        <option value="1" {{ $setting->is_disposed ? 'selected' : '' }}>Disposed</option>
                    </select>
                </div>

                <div class="text-right">
                    <button class="btn btn-warning">
                        <i class="fa fa-save"></i> Update Setting
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
