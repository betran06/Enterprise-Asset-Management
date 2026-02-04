@extends('layouts.main')

@section('content')
    <div class="section-header">
        <h1>Edit Data Aset</h1>
        <div class="ml-auto">
            <a href="{{ route('aset.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <div class="section-body">
        <form action="{{ route('aset.update', $aset->id) }}" method="POST" enctype="multipart/form-data" novalidate>
            @method('PUT')
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-primary">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="kode_aset">Kode Aset <span class="text-danger">*</span></label>
                                <input id="kode_aset" type="text"
                                       class="form-control @error('kode_aset') is-invalid @enderror"
                                       name="kode_aset"
                                       value="{{ old('kode_aset', $aset->kode_aset) }}"
                                       maxlength="35" required>
                                @error('kode_aset')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nama_aset">Nama Aset <span class="text-danger">*</span></label>
                                <input id="nama_aset" type="text"
                                       class="form-control @error('nama_aset') is-invalid @enderror"
                                       name="nama_aset"
                                       value="{{ old('nama_aset', $aset->nama_aset) }}"
                                       maxlength="150" required>
                                @error('nama_aset')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="merek">Merek</label>
                                <input id="merek" type="text"
                                       class="form-control @error('merek') is-invalid @enderror"
                                       name="merek"
                                       value="{{ old('merek', $aset->merek) }}" maxlength="100">
                                @error('merek')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea id="deskripsi"
                                          class="form-control @error('deskripsi') is-invalid @enderror"
                                          name="deskripsi" rows="4">{{ old('deskripsi', $aset->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="kategori_id">Kategori <span class="text-danger">*</span></label>
                                    <select id="kategori_id"
                                            class="form-control @error('kategori_id') is-invalid @enderror"
                                            name="kategori_id" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}"
                                                {{ old('kategori_id', $aset->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="lokasi_id">Lokasi <span class="text-danger">*</span></label>
                                    <select id="lokasi_id"
                                            class="form-control @error('lokasi_id') is-invalid @enderror"
                                            name="lokasi_id" required>
                                        <option value="">-- Pilih Lokasi --</option>
                                        @foreach ($lokasis as $lokasi)
                                            <option value="{{ $lokasi->id }}"
                                                {{ old('lokasi_id', $aset->lokasi_id) == $lokasi->id ? 'selected' : '' }}>
                                                {{ $lokasi->nama_lokasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('lokasi_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="karyawan_id">Pengguna (opsional)</label>
                                    <select id="karyawan_id"
                                            class="form-control @error('karyawan_id') is-invalid @enderror"
                                            name="karyawan_id">
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach ($karyawans as $karyawan)
                                            <option value="{{ $karyawan->id }}"
                                                {{ old('karyawan_id', $aset->karyawan_id) == $karyawan->id ? 'selected' : '' }}>
                                                {{ $karyawan->nama }} ({{ $karyawan->kode_karyawan }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('karyawan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="tgl_penambahan">Tanggal Penambahan <span class="text-danger">*</span></label>
                                <input id="tgl_penambahan" type="date"
                                       class="form-control @error('tgl_penambahan') is-invalid @enderror"
                                       name="tgl_penambahan"
                                       value="{{ old('tgl_penambahan', optional($aset->tgl_penambahan)->format('Y-m-d')) }}" required>
                                @error('tgl_penambahan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-primary">
                        <div class="card-body text-center">

                            <div class="form-group">
                                @if ($aset->gambar && Storage::disk('public')->exists($aset->gambar))
                                    <img id="preview" src="{{ Storage::url($aset->gambar) }}"
                                         class="img-preview img-fluid mb-3 mt-2"
                                         style="border-radius: 5px; max-height:300px; object-fit:contain;">
                                @else
                                    <img id="preview" src="" class="img-preview img-fluid mb-3 mt-2"
                                         style="border-radius: 5px; max-height:300px; object-fit:contain;">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="gambar">Ganti Gambar (jpeg/jpg/png)</label>
                                <input id="gambar" type="file"
                                       class="form-control @error('gambar') is-invalid @enderror"
                                       name="gambar" accept="image/png,image/jpeg" onchange="previewImage(event)">
                                @error('gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                            </div>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');

            if (input.files && input.files[0]) {
                preview.src = URL.createObjectURL(input.files[0]);
            }
        }
    </script>
@endsection
