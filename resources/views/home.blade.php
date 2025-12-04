@extends('layouts.main')

@section('content')
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>

    <div class="section-body">

        {{-- =========================
                DASHBOARD ADMIN
        ========================== --}}
        @if (auth()->user()->role->role == 'admin')
            <div class="row">

                {{-- CARD: Total Inventaris --}}
                <div class="col-lg-3">
                    <div class="card card-primary">
                        <div class="card-header">Total Aset Inventaris</div>
                        <div class="card-body">
                            <p>0 Inventaris</p>
                        </div>
                    </div>
                </div>

                {{-- CARD: Lokasi --}}
                <div class="col-lg-3">
                    <div class="card card-danger">
                        <div class="card-header">Total Lokasi Inventaris</div>
                        <div class="card-body">
                            <p>0 Lokasi</p>
                        </div>
                    </div>
                </div>

                {{-- CARD: Pelaporan menunggu --}}
                <div class="col-lg-3">
                    <div class="card card-warning">
                        <div class="card-header">Total Akun</div>
                        <div class="card-body">
                            <p>0 Pelaporan</p>
                        </div>
                    </div>
                </div>

                {{-- CARD: Pelaporan Diproses --}}
                <div class="col-lg-3">
                    <div class="card card-success">
                        <div class="card-header">Pelaporan Diproses</div>
                        <div class="card-body">
                            <p>0 Pelaporan</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Tabel kiri & kanan --}}
            <div class="row">

                {{-- Audit Log --}}
                <div class="col-lg-6">
                    <div class="card card-warning">
                        <div class="card-header">
                            Aktivitas Sistem
                            <div class="ml-auto">
                                <a href="/pelaporan-masuk" class="btn btn-warning">
                                    <i class="fa fa-back"></i> Audit log
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Barang</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Data dummy --}}
                                    <tr>
                                        <td>1</td>
                                        <td>Dummy</td>
                                        <td>Barang 1</td>
                                        <td><span class="badge badge-primary">menunggu</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Dummy</td>
                                        <td>Barang 2</td>
                                        <td><span class="badge badge-primary">menunggu</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Akun yang sedang login --}}
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            Aktivitas Akun
                            <div class="ml-auto">
                                <a href="/pelaporan-masuk" class="btn btn-primary">
                                    <i class="fa fa-back"></i> Status Login
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Barang</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Data dummy --}}
                                    <tr>
                                        <td>1</td>
                                        <td>Dummy</td>
                                        <td>Barang A</td>
                                        <td><span class="badge badge-warning">dikerjakan</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Dummy</td>
                                        <td>Barang B</td>
                                        <td><span class="badge badge-warning">dikerjakan</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            {{-- =========================
                DASHBOARD USER (STAF)
            ========================== --}}
        @elseif (auth()->user()->role->role === 'staf')
            <div class="row">
                <div class="col-lg-3">
                    <div class="card card-primary">
                        <div class="card-header">Total Barang Inventaris</div>
                        <div class="card-body"><p>0 Inventaris</p></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card card-danger">
                        <div class="card-header">Total Lokasi Inventaris</div>
                        <div class="card-body"><p>0 Lokasi</p></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card card-warning">
                        <div class="card-header">Total Kategori Inventaris</div>
                        <div class="card-body"><p>0 Kategori</p></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card card-success">
                        <div class="card-header">Total Karyawan</div>
                        <div class="card-body"><p>0 Pelaporan</p></div>
                    </div>
                </div>

            </div>
            {{-- TABEL STATUS --}}
            <div class="row">
                <div class="col">
                    <div class="card card-primary">
                        <div class="card-header">
                            Status Pelaporan Inventaris
                            <div class="ml-auto">
                                <a href="/cek-pelaporan" class="btn btn-primary">
                                    <i class="fa fa-back"></i> Cek Pelaporan
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Barang</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Data dummy --}}
                                    <tr>
                                        <td>1</td>
                                        <td>Dummy</td>
                                        <td>Barang X</td>
                                        <td><span class="badge badge-warning">menunggu</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Dummy</td>
                                        <td>Barang Z</td>
                                        <td><span class="badge badge-success">selesai</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            {{-- =========================
                DASHBOARD USER (MANAGER)
            ========================== --}}
        @elseif (auth()->user()->role->role === 'manager')

            <div class="row">

                <div class="col-lg-3">
                    <div class="card card-primary">
                        <div class="card-header">Total Barang Inventaris</div>
                        <div class="card-body"><p>0 Inventaris</p></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card card-danger">
                        <div class="card-header">Total Lokasi Inventaris</div>
                        <div class="card-body"><p>0 Lokasi</p></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card card-warning">
                        <div class="card-header">Perbaikan Menunggu</div>
                        <div class="card-body"><p>0 Pelaporan</p></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card card-success">
                        <div class="card-header">Perbaikan Selesai</div>
                        <div class="card-body"><p>0 Pelaporan</p></div>
                    </div>
                </div>

            </div>

            {{-- Tabel kiri & kanan --}}
            <div class="row">

                {{-- Pelaporan menunggu --}}
                <div class="col-lg-6">
                    <div class="card card-warning">
                        <div class="card-header">
                            Pelaporan Menunggu
                            <div class="ml-auto">
                                <a href="/pelaporan-masuk" class="btn btn-warning">
                                    <i class="fa fa-back"></i> Pelaporan Masuk
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Barang</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Data dummy --}}
                                    <tr>
                                        <td>1</td>
                                        <td>Dummy</td>
                                        <td>Barang 1</td>
                                        <td><span class="badge badge-primary">menunggu</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Dummy</td>
                                        <td>Barang 2</td>
                                        <td><span class="badge badge-primary">menunggu</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Pelaporan dikerjakan --}}
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            Pelaporan Sedang Dikerjakan
                            <div class="ml-auto">
                                <a href="/pelaporan-masuk" class="btn btn-primary">
                                    <i class="fa fa-back"></i> Pelaporan Masuk
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Barang</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Data dummy --}}
                                    <tr>
                                        <td>1</td>
                                        <td>Dummy</td>
                                        <td>Barang A</td>
                                        <td><span class="badge badge-warning">dikerjakan</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Dummy</td>
                                        <td>Barang B</td>
                                        <td><span class="badge badge-warning">dikerjakan</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <p>Role tidak dikenali.</p>
        @endif

    </div>
@endsection
