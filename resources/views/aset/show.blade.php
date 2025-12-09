@extends('layouts.main')

@section('content')
<style>
    td {
        font-size: 16px;
        padding-bottom: 5px;
    }
    .detail-img {
        width:100%;
        height:auto;
        max-height:420px;
        object-fit:contain;
    }
</style>

    <div class="section-header">
        <h1>Detail Aset</h1>
        <div class="ml-auto">
            <a href="{{ route('aset.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            {{-- Left: gambar + QR --}}
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <label class="d-block"><b>Gambar Aset</b></label>

                        @if($aset->gambar && Storage::disk('public')->exists($aset->gambar))
                            <img src="{{ Storage::url($aset->gambar) }}" alt="gambar aset" class="card-img-top detail-img">
                        @else
                            <div class="border p-4 text-muted">Tidak ada gambar</div>
                        @endif
                    </div>

                    <hr>

                    <div class="card-body text-center">
                        <label class="d-block"><b>QR Code</b></label>
                        @php
                            $qrPath = 'qrcode/' . $aset->kode_aset . '.png';
                        @endphp

                        @if (Storage::disk('public')->exists($qrPath))
                            <img src="{{ Storage::url($qrPath) }}" alt="qr-code"
                                 style="width: 250px; height: 250px; display: block; margin: 0 auto;">
                        @else
                            <div class="border p-4 text-muted">QR Code belum tersedia</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: detail & history --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title"><b>{{ $aset->nama_aset }}</b></div>
                        <hr>
                        <table style="width:100%">
                            <tr>
                                <td><b>Kode Aset</b></td>
                                <td>:</td>
                                <td>{{ $aset->kode_aset }}</td>
                            </tr>
                            <tr>
                                <td><b>Tanggal Penambahan</b></td>
                                <td>:</td>
                                <td>{{ optional($aset->tgl_penambahan)->format('Y-m-d') ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><b>Kategori</b></td>
                                <td>:</td>
                                <td>{{ optional($aset->kategori)->nama_kategori ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><b>Merek</b></td>
                                <td>:</td>
                                <td>{{ $aset->merek ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><b>Lokasi</b></td>
                                <td>:</td>
                                <td>{{ optional($aset->lokasi)->nama_lokasi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><b>Deskripsi</b></td>
                                <td>:</td>
                                <td>{!! $aset->deskripsi ?? '-' !!}</td>
                            </tr>
                            <tr>
                                <td><b>Pengguna</b></td>
                                <td>:</td>
                                <td>{{ optional($aset->karyawan)->nama ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    <hr>

                    <div class="card-body">
                        <div class="section-title mt-0">History Perbaikan Aset</div>

                        <div class="table-responsive mt-2">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Pelaporan</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Analisis Perbaikan</th>
                                        <th scope="col">Tanggal Perbaikan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pelaporans as $pelaporan)
                                        @php
                                            // cari feedback terkait pelaporan ini (jika ada)
                                            $fb = $feedbacks->firstWhere('pelaporan_id', $pelaporan->id);
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pelaporan->judul }}</td>
                                            <td>{{ $pelaporan->deskripsi }}</td>
                                            <td>{{ $fb->analisis_keputusan ?? '-' }}</td>
                                            <td>{{ optional($pelaporan->updated_at)->format('Y-m-d H:i') ?? optional($pelaporan->created_at)->format('Y-m-d H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada riwayat perbaikan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
