@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Status User</h1>
</div>

<div class="section-body">
    <div class="card card-primary">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role_name }}</td>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
