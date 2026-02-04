@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Input Opname Aset</h1>
    <div class="ml-auto">
        <a href="{{ route('opname.show', $opname->id) }}" class="btn btn-primary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="section-body">

    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Scan QR Aset</h4>
                </div>
                <div class="card-body">
                    <div id="reader" style="width:100%"></div>
                    <div class="text-muted mt-2" id="scan-status">
                        Menunggu scan...
                    </div>

                    <hr>

                    <div class="form-group">
                        <label>Input Manual Kode Aset</label>
                        <div class="input-group">
                            <input type="text" id="manual_kode" class="form-control"
                                   placeholder="Masukkan kode aset">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary"
                                        id="btn-manual">
                                    Cari
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-warning">
                <div class="card-header">
                    <h4>Form Hasil Opname</h4>
                </div>

                <form action="{{ route('opname.input.store', $opname->id) }}" method="POST">
                    @csrf

                    <input type="hidden" name="aset_id" id="aset_id">

                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>Kode Aset</label>
                                <input type="text" id="kode_aset" class="form-control" disabled>
                            </div>
                            <div class="col-md-6">
                                <label>Nama Aset</label>
                                <input type="text" id="nama_aset" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Departement</label>
                            <input type="text" id="departement" class="form-control" disabled>
                        </div>

                        <div class="form-group">
                            <label>Status Fisik <span class="text-danger">*</span></label>
                            <select name="status_fisik" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="ADA">Ada</option>
                                <option value="RUSAK">Rusak</option>
                                <option value="TIDAK_ADA">Tidak Ada</option>
                                <option value="HILANG">Hilang</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Lokasi (Opsional)</label>
                            <select name="lokasi_id" id="lokasi_id" class="form-control">
                                <option value="">-- Tidak Diubah --</option>
                                @foreach ($lokasiAsets as $lokasi)
                                    <option value="{{ $lokasi->id }}">
                                        {{ $lokasi->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Karyawan (Opsional)</label>
                            <select name="karyawan_id" id="karyawan_id" class="form-control">
                                <option value="">-- Tidak Diubah --</option>
                                @foreach ($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id }}">
                                        {{ $karyawan->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="catatan"
                                      class="form-control"
                                      rows="3"
                                      placeholder="Catatan tambahan (opsional)"></textarea>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan Hasil Opname
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="card card-primary mt-3">
        <div class="card-header">
            <h4>Daftar Aset Teropname</h4>
        </div>
        <div class="card-body">
            @if ($details->isEmpty())
                <div class="alert alert-info">
                    Belum ada aset yang diinput.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Aset</th>
                                <th>Nama Aset</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->aset->kode_aset }}</td>
                                    <td>{{ $row->aset->nama_aset }}</td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $row->status_fisik }}
                                        </span>
                                    </td>
                                    <td>{{ $row->catatan ?? '-' }}</td>
                                    <td>
                                        <form action="{{ route('opname.detail.destroy', [$opname->id, $row->id]) }}"
                                              method="POST"
                                              onsubmit="return confirm('Hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- ======================
    SCRIPT QR
======================= --}}
<script src="{{ asset('assets/js/page/html5-qrcode.min.js') }}"></script>
<script>
let isProcessing = false;

function resetForm() {
    document.getElementById('aset_id').value = '';
    document.getElementById('kode_aset').value = '';
    document.getElementById('nama_aset').value = '';
    document.getElementById('departement').value = '';
    document.getElementById('lokasi_id').value = '';
    document.getElementById('karyawan_id').value = '';
}

function fetchAset(code) {
    if (isProcessing) return;
    isProcessing = true;

    fetch("{{ route('opname.getAsetData') }}?kode=" + encodeURIComponent(code))
        .then(res => res.json())
        .then(data => {
            if (!data.found) {
                resetForm();
                document.getElementById('scan-status').innerText = 'Aset tidak ditemukan';
                alert('Aset tidak ditemukan');
                return;
            }

            document.getElementById('aset_id').value = data.id;
            document.getElementById('kode_aset').value = data.kode_aset;
            document.getElementById('nama_aset').value = data.nama_aset;
            document.getElementById('departement').value = data.departement ?? '';

            if (data.lokasi_id) {
                document.getElementById('lokasi_id').value = data.lokasi_id;
            }

            if (data.karyawan_id) {
                document.getElementById('karyawan_id').value = data.karyawan_id;
            }

            document.getElementById('scan-status').innerText = 'Aset ditemukan';
        })
        .catch(() => alert('Gagal mengambil data aset'))
        .finally(() => {
            setTimeout(() => isProcessing = false, 800);
        });
}

const scanner = new Html5QrcodeScanner(
    "reader",
    { fps: 8, qrbox: { width: 250, height: 250 } },
    false
);

scanner.render(
    text => fetchAset(text),
    () => {}
);

document.getElementById('btn-manual').addEventListener('click', () => {
    const code = document.getElementById('manual_kode').value.trim();
    if (!code) return alert('Masukkan kode aset');
    fetchAset(code);
});
</script>
@endsection
