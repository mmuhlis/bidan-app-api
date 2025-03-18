@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    {{-- <h1 class="mb-4"><i class="fas fa-user-plus"></i> Tambah Akun</h1> --}}

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4><i class="fas fa-user-plus"></i> Form Tambah Akun</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="role"><i class="fas fa-user-tag"></i> Pilih Peran</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="admin">Bidan</option>
                        <option value="user">Pasien</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="nama_lengkap"><i class="fas fa-user"></i> Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group mb-3">
                    <label for="no_hp"><i class="fas fa-phone"></i> Nomor HP</label>
                    <input type="text" class="form-control" name="no_hp" required>
                </div>
                <div id="nikField" class="form-group mb-3">
                    <label for="nik"><i class="fas fa-id-card"></i> NIK (Untuk Pasien)</label>
                    <input type="text" class="form-control" name="nik">
                </div>
                <div id="alamatField" class="form-group mb-3">
                    <label for="alamat"><i class="fas fa-map-marker-alt"></i> Alamat (Untuk Pasien)</label>
                    <input type="text" class="form-control" name="alamat">
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Akun
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
