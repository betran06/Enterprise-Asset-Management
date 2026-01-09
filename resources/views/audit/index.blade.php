@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Audit Trail</h1>
</div>

<div class="section-body">

    {{-- FILTER --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="form-inline">
                <select name="action" class="form-control mr-2">
                    <option value="">-- Semua Aksi --</option>
                    @foreach ($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            {{ $action }}
                        </option>
                    @endforeach
                </select>

                <select name="table" class="form-control mr-2">
                    <option value="">-- Semua Tabel --</option>
                    @foreach ($tables as $table)
                        <option value="{{ $table }}" {{ request('table') == $table ? 'selected' : '' }}>
                            {{ $table }}
                        </option>
                    @endforeach
                </select>

                <button class="btn btn-primary">Filter</button>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card card-primary">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Aksi</th>
                        <th>Tabel</th>
                        <th>Row ID</th>
                        <th>IP</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{ $log->occurred_at->format('d-m-Y H:i') }}</td>
                            <td>{{ $log->user_name }}</td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td>{{ $log->table_name }}</td>
                            <td>{{ $log->row_id ?? '-' }}</td>
                            <td>{{ $log->ip_address }}</td>
                            <td>
                                <a href="{{ route('audit.show', $log->id) }}"
                                   class="btn btn-sm btn-secondary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $logs->links() }}
        </div>
    </div>

</div>
@endsection
