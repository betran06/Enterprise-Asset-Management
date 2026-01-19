@extends('layouts.app')

@section('content')
<div id="app">
    <section class="section" style="min-height: 100vh;">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-md-6 d-none d-md-block p-0"
                    style="background-image: url('{{ asset('assets/img/bg-auth1.png') }}');
                           background-size: cover;
                           background-position: center;
                           min-height: 100vh;">
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-center bg-light">

                    <div style="width: 100%; max-width: 420px;">
                        <div class="text-center mb-4">
                            <h3 class="custom-title">Sistem Inventaris</h3>
                            <p class="custom-subtitle">Pelaporan Barang Menggunakan QR CODE</p>
                        </div>

                        <div class="card card-primary shadow">
                            <div class="card-header">
                                <h4>Silakan login untuk melanjutkan</h4>
                            </div>

                            <div class="card-body">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                                    @csrf

                                    {{-- EMAIL --}}
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                                            </div>
                                            <input id="email" type="email" class="form-control" name="email"
                                                placeholder="Masukkan Email" required autofocus>
                                        </div>
                                    </div>

                                    {{-- PASSWORD --}}
                                    <div class="form-group">
                                        <label for="password" class="d-block">Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                            </div>
                                            <input id="password" type="password" class="form-control" name="password"
                                                placeholder="Masukkan Password" required>
                                        </div>
                                    </div>

                                    {{-- REMEMBER --}}
                                    <div class="form-group d-flex justify-content-between align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input" id="remember-me">
                                            <label class="custom-control-label" for="remember-me">Ingat Saya</label>
                                        </div>
                                    </div>

                                    {{-- BUTTON --}}
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            Login
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="simple-footer text-center mt-3 text-muted">
                            &copy; {{ date('Y') }} Aplikasi Inventaris
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </section>
</div>
@endsection
