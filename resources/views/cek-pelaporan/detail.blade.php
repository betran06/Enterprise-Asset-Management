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
            <a href="/cek-pelaporan" class="btn btn-primary">
                <i class="fa fa-back"></i> Kembali
            </a>
        </div>
    </div>

    <div class="section-body">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="card card-primary">
                    <div class="card-header">
                        Pelaporan Inventaris
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nama Aset</label>
                                    <input type="text" class="form-control"
                                           value="{{ optional($pelaporan->aset)->nama_aset }}"
                                           disabled>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Kode Aset</label>
                                    <input type="text" class="form-control"
                                           value="{{ optional($pelaporan->aset)->kode_aset }}"
                                           disabled>
                                </div>
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
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <input type="text" class="form-control"
                                           value="{{ optional(optional($pelaporan->aset)->kategori)->nama_kategori }}"
                                           disabled>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Merek</label>
                                    <input type="text" class="form-control"
                                           value="{{ optional($pelaporan->aset)->merek }}"
                                           disabled>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Lokasi</label>
                                    <input type="text" class="form-control"
                                           value="{{ optional(optional($pelaporan->aset)->lokasi)->nama_lokasi }}"
                                           disabled>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label>Judul Pelaporan</label>
                            <input type="text" class="form-control"
                                   value="{{ $pelaporan->judul }}" disabled>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi Pelaporan</label>
                            <textarea class="form-control" rows="6" disabled>{{ $pelaporan->deskripsi }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-primary">
                    <div class="card-header">
                        Analisis Perbaikan & Feedback
                    </div>
                    <div class="card-body">

                        {{-- ANALISIS ADMIN --}}
                        @if ($feedback)
                            <label>Analisis Admin</label>
                            <div class="alert alert-light">
                                {{ $feedback->analisis_keputusan }}
                            </div>
                        @endif

                        {{-- BALASAN USER --}}
                        @if ($feedbackReply)
                            <label>Balasan User</label>
                            <div class="alert alert-primary">
                                {{ $feedbackReply->feedback_reply }}
                            </div>
                        @endif

                        <hr>

                        {{-- FORM BALASAN (jika belum ada reply) --}}
                        @if ($feedback && !$feedbackReply)
                            <form action="/cek-pelaporan/detail/{{ $pelaporan->id }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Berikan Feedback</label>
                                    <textarea class="form-control"
                                              name="feedback_replies"
                                              rows="5"
                                              required></textarea>
                                    @error('feedback_replies')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit"
                                        class="btn btn-success float-right">
                                    Kirim Balasan
                                </button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
