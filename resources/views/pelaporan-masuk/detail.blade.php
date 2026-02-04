@extends('layouts.main')

<style>
    td {
        font-size: 16px;
        padding-bottom: 5px;
    }
</style>

@section('content')
<div class="section-header">
    <h1>Detail Pelaporan</h1>
    <div class="ml-auto">
        <a href="/pelaporan-masuk" class="btn btn-primary">
            <i class="fa fa-back"></i> Kembali
        </a>
    </div>
</div>

<div class="section-body">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card card-primary">
                <div class="card-header">Pelaporan Inventaris</div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-4">
                            <label>Nama Aset</label>
                            <input class="form-control"
                                   value="{{ $pelaporan->aset->nama_aset }}" disabled>
                        </div>
                        <div class="col-lg-4">
                            <label>Kode Aset</label>
                            <input class="form-control"
                                   value="{{ $pelaporan->aset->kode_aset }}" disabled>
                        </div>
                        <div class="col-lg-4">
                            <label>Status Pelaporan</label>
                            @if ($pelaporan->status === 'Menunggu')
                                <div class="alert alert-warning">Menunggu</div>
                            @elseif ($pelaporan->status === 'Proses Pengecekan')
                                <div class="alert alert-primary">Proses Pengecekan</div>
                            @elseif ($pelaporan->status === 'Selesai')
                                <div class="alert alert-success">Selesai</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-lg-4">
                            <label>Kategori</label>
                            <input class="form-control"
                                   value="{{ $pelaporan->aset->kategori->nama_kategori }}" disabled>
                        </div>
                        <div class="col-lg-4">
                            <label>Merek</label>
                            <input class="form-control"
                                   value="{{ $pelaporan->aset->merek }}" disabled>
                        </div>
                        <div class="col-lg-4">
                            <label>Lokasi</label>
                            <input class="form-control"
                                   value="{{ $pelaporan->aset->lokasi->nama_lokasi }}" disabled>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label>Judul Pelaporan</label>
                        <input class="form-control" value="{{ $pelaporan->judul }}" disabled>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi Pelaporan</label>
                        <textarea class="form-control" rows="5" disabled>{{ $pelaporan->deskripsi }}</textarea>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-primary">
                <div class="card-header">Aksi</div>
                <div class="card-body">

                    @if ($pelaporan->status === 'Menunggu')
                        <form id="perbaikiForm{{ $pelaporan->id }}"
                              action="/pelaporan-masuk/detail/{{ $pelaporan->id }}/perbaiki"
                              method="POST">
                            @method('PUT')
                            @csrf
                            <button type="button"
                                    class="btn btn-primary btn-block"
                                    onclick="confirmPerbaiki({{ $pelaporan->id }})">
                                <i class="fas fa-tools"></i> Proses Pengecekan
                            </button>
                        </form>

                    @elseif ($pelaporan->status === 'Proses Pengecekan')
                        <form id="selesaiForm{{ $pelaporan->id }}"
                              action="/pelaporan-masuk/detail/{{ $pelaporan->id }}/selesai"
                              method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label>Analisis Pelaporan</label>
                                <textarea name="analisis_keputusan"
                                          class="form-control"
                                          rows="5" required></textarea>
                            </div>
                            <button type="button"
                                    class="btn btn-success btn-block"
                                    onclick="confirmSelesai({{ $pelaporan->id }})">
                                <i class="fas fa-check"></i> Selesai
                            </button>
                        </form>

                    @elseif ($pelaporan->status === 'Selesai')
                        @if ($feedback)
                            <label>Analisis Admin</label>
                            <div class="alert alert-light">
                                {{ $feedback->analisis_keputusan }}
                            </div>
                        @endif

                        @foreach ($feedbackReplies as $reply)
                            <label>Balasan User</label>
                            <div class="alert alert-primary">
                                {{ $reply->feedback_reply }}
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmPerbaiki(id) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Ubah status menjadi Sedang Dalam Pengecekan?',
        icon: 'question',
        showCancelButton: true
    }).then((res) => {
        if (res.isConfirmed) {
            document.getElementById('perbaikiForm' + id).submit();
        }
    });
}

function confirmSelesai(id) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Tandai pelaporan sebagai selesai?',
        icon: 'question',
        showCancelButton: true
    }).then((res) => {
        if (res.isConfirmed) {
            document.getElementById('selesaiForm' + id).submit();
        }
    });
}
</script>
@endsection
