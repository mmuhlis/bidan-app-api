@extends('layouts.admin')

@section('title', 'Data Pengguna | Smart Bidan')
@section('content')
<div class="container">
    {{-- <h1 class="mb-4"><i class="fas fa-users"></i> Data Pengguna</h1> --}}

    <!-- Tombol Tambah Akun -->
    <a href="{{ route('data-pengguna.create') }}" class="btn btn-success mt-3 mb-3">
        <i class="fas fa-user-plus"></i> Tambah Akun
    </a>

    <!-- Data Bidan -->
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h4><i class="fas fa-user-md"></i> Data Bidan</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $key => $admin)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $admin->nama_lengkap }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->password }}</td>
                            <td>
                                {{-- <button class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </button> --}}
                                <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Data Pasien -->
    <div class="card mt-4 shadow">
        <div class="card-header bg-success text-white">
            <h4><i class="fas fa-user-injured"></i> Data Pasien</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->nama_lengkap }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->password }}</td>
                            <td>
                                {{-- <button class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </button> --}}
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
