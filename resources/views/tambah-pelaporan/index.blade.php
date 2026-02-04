@extends('layouts.main')

@section('content')
    <div class="section-header">
        <h1>Tambah Pelaporan Perbaikan</h1>
    </div>

    <div class="section-body">
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-lg-4">
                <div class="card card-primary">
                    <div class="card-header">Scan QR Code</div>
                    <div class="card-body">
                        <div id="reader" style="width:100%"></div>
                        <div id="scan-status" class="mt-2 text-muted">Menunggu scan...</div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="col-lg-8">
                <div class="card card-primary">
                    <div class="card-header">Detail Aset Inventaris</div>
                    <div class="card-body">
                        <form action="{{ route('tambah-pelaporan.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="aset_id" id="aset_id">

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label>Nama Aset</label>
                                    <input type="text" id="nama_aset" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Kode Aset</label>
                                    <input type="text" id="kode_aset" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Kategori</label>
                                    <input type="text" id="kategori" class="form-control" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label>Merek</label>
                                    <input type="text" id="merek" class="form-control" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label>Lokasi</label>
                                    <input type="text" id="lokasi" class="form-control" readonly>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <label>Judul Pelaporan <span class="text-danger">*</span></label>
                                <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                                @error('judul') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Pelaporan <span class="text-danger">*</span></label>
                                <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label>Masukkan Kode Aset (Manual jika perlu)</label>
                                <div class="input-group">
                                    <input type="text" id="manual_kode" class="form-control" placeholder="Masukkan kode aset">
                                    <div class="input-group-append">
                                        <button type="button" id="btn-fill-manual" class="btn btn-outline-secondary">Isi</button>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary float-right">Kirim Laporan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/page/html5-qrcode.min.js') }}"></script>


    <script>
        let isProcessingScan = false;
        const debounceMs = 800; // minimal delay between requests

        function clearFields() {
            document.getElementById('aset_id').value = '';
            document.getElementById('nama_aset').value = '';
            document.getElementById('kode_aset').value = '';
            document.getElementById('kategori').value = '';
            document.getElementById('merek').value = '';
            document.getElementById('lokasi').value = '';
        }

        function fillFields(data, code) {
            document.getElementById('aset_id').value = data.id ?? '';
            document.getElementById('nama_aset').value = data.nama_aset ?? '';
            document.getElementById('kode_aset').value = code ?? '';
            document.getElementById('kategori').value = data.kategori ?? '';
            document.getElementById('merek').value = data.merek ?? '';
            document.getElementById('lokasi').value = data.lokasi ?? '';
        }

        function fetchAsetByCode(code) {
            if (!code) return;
            if (isProcessingScan) return;
            isProcessingScan = true;
            document.getElementById('scan-status').innerText = 'Memeriksa data aset...';

            fetch('/get-data-aset?result=' + encodeURIComponent(code), {
                method: 'GET',
                credentials: 'same-origin' // same origin cookies if available
            })
            .then(res => {
                if (!res.ok) throw res; // trigger catch for non-200
                return res.json();
            })
            .then(json => {
                if (json && json.id) {
                    fillFields(json, code);
                    document.getElementById('scan-status').innerText = 'Aset ditemukan';
                } else {
                    clearFields();
                    document.getElementById('kode_aset').value = code;
                    document.getElementById('scan-status').innerText = 'Aset tidak ditemukan';
                }
            })
            .catch(err => {
                console.warn('Fetch error:', err);
                clearFields();
                document.getElementById('kode_aset').value = code;
                if (err.status === 419) {
                    document.getElementById('scan-status').innerText = 'Session tidak valid (419). Refresh halaman.';
                } else {
                    document.getElementById('scan-status').innerText = 'Terjadi kesalahan saat memeriksa aset.';
                }
            })
            .finally(() => {
                setTimeout(() => { isProcessingScan = false; }, debounceMs);
            });
        }

        const scanner = new Html5QrcodeScanner(
            "reader",
            { fps: 8, qrbox: { width: 250, height: 250 } },
            false
        );

        function onScanSuccess(decodedText, decodedResult) {
            fetchAsetByCode(decodedText);
        }

        function onScanFailure(error) {
        }

        scanner.render(onScanSuccess, onScanFailure);

        document.getElementById('btn-fill-manual').addEventListener('click', () => {
            const code = document.getElementById('manual_kode').value.trim();
            if (!code) return alert('Masukkan kode aset terlebih dahulu.');
            fetchAsetByCode(code);
        });

        clearFields();
    </script>
@endsection
