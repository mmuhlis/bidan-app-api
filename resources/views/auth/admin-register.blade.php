@extends('layouts.auth')

@section('title', 'Register Admin | Smart Bidan')
@section('content')
<div class="register-box">
    <div class="register-logo">
        <b>Admin</b> Register
    </div>
    <div class="card">
        <div class="card-body register-card-body">
            <form action="{{ route('admin.register') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required>
                </div>
                <div class="input-group mb-3">
                    <input type="number" name="no_hp" class="form-control" placeholder="No Hp" required>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                </div>
            </form>

            <p class="mt-3 text-center">
                Sudah punya akun? <a href="{{ route('admin.login') }}">Login di sini</a>
            </p>

        </div>
    </div>
</div>
@endsection
