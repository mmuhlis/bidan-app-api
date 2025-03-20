@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Profil Saya</h2>
    <table class="table">
        <tr>
            <th>Nama Lengkap</th>
            <td>{{ $admin->nama_lengkap }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $admin->email }}</td>
        </tr>
    </table>
    <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">
        <i class="fas fa-edit"></i> Edit Profil
    </a>
</div>
@endsection
