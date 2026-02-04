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
        <a href="{{ route('aset.index') }}" class="btn btn-primary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="section-body">
    <div class="row">

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <label class="d-block"><b>Gambar Aset</b></label>

                    @if($aset->gambar && Storage::disk('public')->exists($aset->gambar))
                        <img src="{{ Storage::url($aset->gambar) }}" class="detail-img">
                    @else
                        <div class="border p-4 text-muted">Tidak ada gambar</div>
                    @endif
                </div>

                <hr>

                <div class="card-body text-center">
                    <label class="d-block"><b>QR Code</b></label>
                    @php $qrPath = 'qrcode/' . $aset->kode_aset . '.png'; @endphp

                    @if (Storage::disk('public')->exists($qrPath))
                        <img src="{{ Storage::url($qrPath) }}"
                             style="width:250px;height:250px;margin:auto;">
                    @else
                        <div class="border p-4 text-muted">QR Code belum tersedia</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5><b>{{ $aset->nama_aset }}</b></h5>
                    <hr>

                    <table style="width:100%">
                        <tr>
                            <td><b>Kode Aset</b></td><td>:</td>
                            <td>{{ $aset->kode_aset }}</td>
                        </tr>
                        <tr>
                            <td><b>Tanggal Penambahan</b></td><td>:</td>
                            <td>{{ optional($aset->tgl_penambahan)->format('Y-m-d') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><b>Kategori</b></td><td>:</td>
                            <td>{{ optional($aset->kategori)->nama_kategori ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><b>Merek</b></td><td>:</td>
                            <td>{{ $aset->merek ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><b>Lokasi</b></td><td>:</td>
                            <td>{{ optional($aset->lokasi)->nama_lokasi ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td><b>Status Penyusutan</b></td><td>:</td>
                            <td>
                                @if (!$aset->penyusutanSetting)
                                    <span class="badge badge-secondary">Belum Diset</span>
                                @elseif ($aset->penyusutanSetting->is_disposed)
                                    <span class="badge badge-danger">Disposed</span>
                                @else
                                    <span class="badge badge-success">Aktif</span>
                                @endif
                            </td>
                        </tr>

                        @if ($aset->penyusutanSetting && $aset->penyusutanSetting->is_disposed)
                            <tr>
                                <td><b>Alasan Disposal</b></td><td>:</td>
                                <td>{{ $aset->penyusutanSetting->alasan_disposed ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><b>Catatan Disposal</b></td><td>:</td>
                                <td>{{ $aset->penyusutanSetting->catatan_disposal ?? '-' }}</td>
                            </tr>
                        @endif

                        <tr>
                            <td><b>Deskripsi</b></td><td>:</td>
                            <td>{!! $aset->deskripsi ?? '-' !!}</td>
                        </tr>
                        <tr>
                            <td><b>Pengguna Saat Ini</b></td><td>:</td>
                            <td>
                                {{ optional($aset->karyawan)->nama ?? 'Belum digunakan' }}
                            </td>
                        </tr>
                    </table>

                    @if (!$aset->penyusutanSetting || !$aset->penyusutanSetting->is_disposed)
                        <hr>
                        <h6 class="mb-3"><b>Atur Pengguna Aset</b></h6>

                        <form action="{{ route('aset.updatePengguna', $aset->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Pilih Karyawan</label>
                                <select name="karyawan_id" class="form-control">
                                    <option value="">-- Tidak Digunakan --</option>
                                    @foreach ($karyawans as $karyawan)
                                        <option value="{{ $karyawan->id }}"
                                            {{ $aset->karyawan_id == $karyawan->id ? 'selected' : '' }}>
                                            {{ $karyawan->nama }}
                                            @if($karyawan->jabatan)
                                                - {{ $karyawan->jabatan }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="btn btn-primary">
                                <i class="fa fa-save"></i> Simpan Pengguna
                            </button>
                        </form>
                    @else
                        <div class="alert alert-warning mt-3">
                            Aset sudah <b>Disposed</b>. Pengguna tidak dapat diubah.
                        </div>
                    @endif
                </div>

                <hr>
                <div class="card-body">
                    <div class="section-title mt-0">History Pelaporan Aset</div>

                    <div class="table-responsive mt-2">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Analisis</th>
                                    <th>Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pelaporans as $pelaporan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pelaporan->judul }}</td>
                                        <td>{{ $pelaporan->deskripsi }}</td>
                                        <td>
                                            <span class="badge
                                                @if($pelaporan->status === 'Menunggu') badge-warning
                                                @elseif($pelaporan->status === 'Sedang Diperbaiki') badge-primary
                                                @elseif($pelaporan->status === 'Selesai') badge-success
                                                @endif">
                                                {{ $pelaporan->status }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $pelaporan->feedbacks->last()->analisis_keputusan ?? '-' }}
                                        </td>
                                        <td>
                                            {{ ($pelaporan->updated_at ?? $pelaporan->created_at)->format('Y-m-d H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            Belum ada riwayat pelaporan.
                                        </td>
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
