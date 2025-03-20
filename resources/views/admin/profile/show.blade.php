@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Profil Admin</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Nama Lengkap:</strong> {{ $admin->nama_lengkap }}</p>
            <p><strong>Email:</strong> {{ $admin->email }}</p>
            <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">
                <i class="fas fa-user-edit"></i> Edit Profil
            </a>
        </div>
    </div>
</div>
@endsection
