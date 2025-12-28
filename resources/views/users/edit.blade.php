@extends('layouts.main')

@section('content')
    <div class="section-header">
        <h1>Edit User</h1>
        <div class="ml-auto">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-primary">
                    <div class="card-body">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Nama --}}
                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       value="{{ old('name', $user->name) }}"
                                       required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email', $user->email) }}"
                                       required>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Role --}}
                            <div class="form-group">
                                <label>Role <span class="text-danger">*</span></label>
                                <select name="role_id" class="form-control" required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                            {{ strtoupper($role->role) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            {{-- Password (opsional) --}}
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       placeholder="Kosongkan jika tidak ingin mengubah password">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control"
                                       placeholder="Ulangi password baru">
                            </div>

                            {{-- Submit --}}
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update User
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div class="col-lg-4">
                <div class="card card-warning">
                    <div class="card-body">
                        <h6>Catatan</h6>
                        <ul class="mb-0">
                            <li>Email harus tetap unik</li>
                            <li>Password boleh dikosongkan</li>
                            <li>Role langsung memengaruhi akses menu</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
