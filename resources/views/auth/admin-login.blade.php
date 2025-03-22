@extends('layouts.auth')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <b>Login</b>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <form action="{{ route('admin.login.submit') }}" method="POST">
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
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                </div>
            </form>

            <!-- Tambahkan link registrasi -->
            <p class="mt-3 text-center">
                Sudah punya akun? <a href="{{ route('admin.register') }}">Registrasi di sini</a>
            </p>

        </div>
    </div>
</div>
@endsection
