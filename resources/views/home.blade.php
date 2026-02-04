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
                        <div class="card-header">Total Aset</div>
                        <div class="card-body">
                            <p>0 Inventaris</p>
                        </div>
                    </div>
                </div>

                {{-- CARD: Lokasi --}}
                <div class="col-lg-3">
                    <div class="card card-danger">
                        <div class="card-header">Total Lokasi</div>
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
                            Aktivitas Akun
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
                                        <th>Akun</th>
                                        <th>Waktu</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Data dummy --}}
                                    <tr>
                                        <td>1</td>
                                        <td>staf 1</td>
                                        <td>24-01-2026 14:28</td>
                                        <td><span class="badge badge-info">update</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>staf 2</td>
                                        <td>19-01-2026 20:40</td>
                                        <td><span class="badge badge-info">create</span></td>
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
                            Status Akun
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
                                        <th>Akun</th>
                                        <th>Status</th>
                                        <th>Last Login</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Data dummy --}}
                                    <tr>
                                        <td>1</td>
                                        <td>staf</td>
                                        <td><span class="badge badge-success">online</span></td>
                                        <td>24 Jan 2026 19:02</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Manager</td>
                                        <td><span class="badge badge-secondary">offline</span></td>
                                        <td>23 Jan 2026 20:21</td>
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
                        <div class="card-header">Total Aset </div>
                        <div class="card-body"><p>8 aset</p></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card card-danger">
                        <div class="card-header">Total Lokasi</div>
                        <div class="card-body"><p>2 Lokasi</p></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card card-warning">
                        <div class="card-header">Total Kategori</div>
                        <div class="card-body"><p>5 Kategori</p></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card card-success">
                        <div class="card-header">Total Karyawan</div>
                        <div class="card-body"><p>10 Pelaporan</p></div>
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
                                    <i class="fa fa-back"></i> Cek Pelaporan Perbaikan
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Nama aset</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Data dummy --}}
                                    <tr>
                                        <td>1</td>
                                        <td>rusak</td>
                                        <td>Laptop HP 14s intel core i5	</td>
                                        <td>gudang</td>
                                        <td><span class="badge badge-warning">menunggu</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>perbaikan</td>
                                        <td>AC DAIKIN</td>
                                        <td>Kantor Aiti</td>
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
                        <div class="card-header">Total Aset</div>
                        <div class="card-body"><p>8 Aset</p></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card card-danger">
                        <div class="card-header">Total Lokasi</div>
                        <div class="card-body"><p>2 Lokasi</p></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card card-warning">
                        <div class="card-header">Perbaikan Menunggu</div>
                        <div class="card-body"><p>2 Pelaporan</p></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card card-success">
                        <div class="card-header">Perbaikan Selesai</div>
                        <div class="card-body"><p>5 Pelaporan</p></div>
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
                                    <i class="fa fa-back"></i> Pelaporan Perbaikan Masuk
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Nama Aset</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Data dummy --}}
                                    <tr>
                                        <td>1</td>
                                        <td>Upgrade</td>
                                        <td>Laptop HP 14s intel core i5</td>
                                        <td><span class="badge badge-primary">menunggu</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>perlu upgrade software</td>
                                        <td>Laptop HP UM82CM0V</td>
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
                                        <th>Nama Aset</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Data dummy --}}
                                    <tr>
                                        <td>1</td>
                                        <td>perlu upgrade software</td>
                                        <td>Laptop HP UM82CM0V</td>
                                        <td><span class="badge badge-warning">dikerjakan</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>rusak</td>
                                        <td>Laptop HP 14s intel core i5</td>
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
