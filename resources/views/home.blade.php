@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Dashboard</h1>
</div>

<div class="section-body">

{{-- =========================
    DASHBOARD ADMIN
========================= --}}
@if (auth()->user()->role->role === 'admin')

    {{-- ===== ROW CARD RINGKASAN ===== --}}
    <div class="row">

        {{-- CARD: Total Aset --}}
        <div class="col-lg-3">
            <div class="card card-primary">
                <div class="card-header">Total Aset</div>
                <div class="card-body">
                    <p>{{ $totalAset ?? 0 }} Inventaris</p>
                </div>
            </div>
        </div>

        {{-- CARD: Total Lokasi --}}
        <div class="col-lg-3">
            <div class="card card-danger">
                <div class="card-header">Total Lokasi</div>
                <div class="card-body">
                    <p>{{ $totalLokasi ?? 0 }} Lokasi</p>
                </div>
            </div>
        </div>

        {{-- CARD: Total Akun --}}
        <div class="col-lg-3">
            <div class="card card-warning">
                <div class="card-header">Total Akun</div>
                <div class="card-body">
                    <p>{{ $totalAkun ?? 0 }} Akun</p>
                </div>
            </div>
        </div>

        {{-- CARD: Pelaporan Diproses --}}
        <div class="col-lg-3">
            <div class="card card-success">
                <div class="card-header">Pelaporan Diproses</div>
                <div class="card-body">
                    <p>{{ $pelaporanProses ?? 0 }} Pelaporan</p>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== ROW TABLE ===== --}}
    <div class="row">

        {{-- AKTIVITAS AKUN / AUDIT LOG --}}
        <div class="col-lg-6">
            <div class="card card-warning">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Aktivitas Akun</span>
                    <a href="{{ route('audit.index') ?? '#' }}" class="btn btn-warning btn-sm">
                        Audit Log
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Akun</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($auditLogs as $log)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $log->user_name ?? 'System' }}
                                    </td>
                                    <td>
                                        {{ optional($log->occurred_at)->format('d-m-Y H:i') }}
                                    </td>
                                    <td>
                                        @if ($log->action === 'CREATE')
                                            <span class="badge badge-success">CREATE</span>
                                        @elseif ($log->action === 'UPDATE')
                                            <span class="badge badge-info">UPDATE</span>
                                        @elseif ($log->action === 'DELETE')
                                            <span class="badge badge-danger">DELETE</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $log->action }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        Belum ada aktivitas sistem
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- STATUS AKUN --}}
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Status Akun</span>
                    <a href="#" class="btn btn-primary btn-sm">
                        Status Login
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Akun</th>
                                <th>Status</th>
                                <th>Last Login</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($usersStatus as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $user->name }}
                                        <br>
                                        <small class="text-muted">{{ $user->role->role ?? '-' }}</small>
                                    </td>
                                    <td>
                                        @if ($user->is_online)
                                            <span class="badge badge-success">Online</span>
                                        @else
                                            <span class="badge badge-secondary">Offline</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $user->last_login_at
                                            ? $user->last_login_at->format('d M Y H:i')
                                            : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        Tidak ada data akun
                                    </td>
                                </tr>
                            @endforelse
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

    {{-- Total Aset --}}
    <div class="col-lg-3">
        <div class="card card-primary">
            <div class="card-header">Total Aset</div>
            <div class="card-body">
                <p>{{ $totalAset ?? 0 }} Aset</p>
            </div>
        </div>
    </div>

    {{-- Total Lokasi --}}
    <div class="col-lg-3">
        <div class="card card-danger">
            <div class="card-header">Total Lokasi</div>
            <div class="card-body">
                <p>{{ $totalLokasi ?? 0 }} Lokasi</p>
            </div>
        </div>
    </div>

    {{-- Total Kategori --}}
    <div class="col-lg-3">
        <div class="card card-warning">
            <div class="card-header">Total Kategori</div>
            <div class="card-body">
                <p>{{ $totalKategori ?? 0 }} Kategori</p>
            </div>
        </div>
    </div>

    {{-- Total Opname --}}
    <div class="col-lg-3">
        <div class="card card-success">
            <div class="card-header">Total Opname</div>
            <div class="card-body">
                <p>{{ $totalOpname ?? 0 }} Opname</p>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col">
        <div class="card card-primary">

            <div class="card-header">
                Status Pelaporan Inventaris
                <div class="ml-auto">
                    <a href="{{ url('/cek-pelaporan') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-search"></i> Cek Semua
                    </a>
                </div>
            </div>

            <div class="card-body">

                @if ($pelaporanStaf->isEmpty())
                    <div class="alert alert-info mb-0">
                        Belum ada pelaporan yang Anda buat.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Nama Aset</th>
                                    <th>Status</th>
                                    <th>Lokasi</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelaporanStaf as $row)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $row->judul }}</td>
                                        <td>{{ $row->aset->nama_aset ?? '-' }}</td>
                                        <td class="text-center">
                                            @if ($row->status === 'Menunggu')
                                                <span class="badge badge-warning">Menunggu</span>
                                            @elseif (in_array($row->status, ['Diproses','Proses Pengecekan']))
                                                <span class="badge badge-info">Diproses</span>
                                            @elseif ($row->status === 'Selesai')
                                                <span class="badge badge-success">Selesai</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $row->status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{ $row->aset->lokasi->nama_lokasi ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $row->created_at->format('d-m-Y') }}
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
</div>

{{-- =========================
    DASHBOARD MANAGER
========================== --}}
@elseif (auth()->user()->role->role === 'manager')

<div class="row">

    <div class="col-lg-3">
        <div class="card card-primary">
            <div class="card-header">Total Aset</div>
            <div class="card-body">
                <p>{{ $totalAset ?? 0 }} Aset</p>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card card-danger">
            <div class="card-header">Total Lokasi</div>
            <div class="card-body">
                <p>{{ $totalLokasi ?? 0 }} Lokasi</p>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card card-warning">
            <div class="card-header">Aset Disusutkan</div>
            <div class="card-body">
                <p>{{ $totalPenyusutan ?? 0 }} Aset</p>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card card-success">
            <div class="card-header">Total Opname</div>
            <div class="card-body">
                <p>{{ $totalOpname ?? 0 }} Opname</p>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card card-warning">
            <div class="card-header">
                Pelaporan Masuk
                <div class="ml-auto">
                    <a href="{{ url('/pelaporan-masuk') }}" class="btn btn-warning btn-sm">
                        Lihat Semua
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Aset</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelaporanMasuk as $row)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $row->judul }}</td>
                                <td>{{ $row->aset->nama_aset ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($row->status === 'Menunggu')
                                        <span class="badge badge-warning">Menunggu</span>
                                    @elseif (in_array($row->status, ['Diproses','Proses Pengecekan']))
                                        <span class="badge badge-info">Diproses</span>
                                    @elseif ($row->status === 'Selesai')
                                        <span class="badge badge-success">Selesai</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $row->status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Tidak ada pelaporan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
   <div class="col-lg-6">
    <div class="card card-primary">
        <div class="card-header">
            Penyusutan Nilai Aset
            <div class="ml-auto">
                <a href="{{ route('penyusutan.index') }}" class="btn btn-primary btn-sm">
                    Detail Penyusutan
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Aset</th>
                            <th>Nilai Buku Terakhir</th>
                            <th>Periode Terakhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penyusutanTerakhir as $aset)
                            @php
                                $last = $aset->penyusutanBulanan->first();
                            @endphp
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $aset->nama_aset }}</td>
                                <td class="text-right">
                                    Rp {{ number_format($last->nilai_buku_akhir ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    {{ isset($last->periode) 
                                        ? \Carbon\Carbon::parse($last->periode)->format('m-Y') 
                                        : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Belum ada data penyusutan
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

@endif

</div>
@endsection

