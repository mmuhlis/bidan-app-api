@extends('layouts.admin')

@section('title', 'Detail Rekam Medis | Smart Bidan')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Detail Rekam Medis</h1>

    <div class="text-right mb-3">
        <a href="{{ route('rekam-medis.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Rekam Medis
        </a>
    </div>

    <!-- Informasi Pasien -->
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Informasi Pasien</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Nama Pasien</th>
                    <td>{{ $user->nama_lengkap }}</td>
                </tr>
                <tr>
                    <th>NIK</th>
                    <td>{{ $user->nik }}</td>
                </tr>
            </table>
        </div>
    </div>

    <h4 class="mt-4">Riwayat Rekam Medis</h4>

    @if($user->rekamMedis->isEmpty())
        <div class="alert alert-warning text-center mt-3">Belum ada riwayat rekam medis.</div>
    @else
        @foreach($user->rekamMedis as $index => $rekam)
            <div class="card mt-3 shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Rekam Medis #{{ $index + 1 }}</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Tanggal Periksa</th>
                            <td>{{ date('d M Y', strtotime($rekam->tanggal_periksa)) }}</td>
                        </tr>
                        <tr>
                            <th>Umur</th>
                            <td>{{ $rekam->umur }} Tahun</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td><span class="badge badge-info">{{ $rekam->kategori }}</span></td>
                        </tr>
                        <tr>
                            <th>Keluhan</th>
                            <td>{{ $rekam->keluhan }}</td>
                        </tr>
                        <tr>
                            <th>Diagnosa</th>
                            <td>{{ $rekam->diagnosa }}</td>
                        </tr>
                        <tr>
                            <th>Tindakan</th>
                            <td>{{ $rekam->tindakan }}</td>
                        </tr>
                        <tr>
                            <th>Bidan</th>
                            <td>{{ $rekam->admin->nama_lengkap }}</td>
                        </tr>
                    </table>

                    {{-- <div class="text-right">
                        <a href="{{ route('rekam-medis.edit', $rekam->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('rekam-medis.destroy', $rekam->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus rekam medis ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div> --}}
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection



{{-- Layout keren terbaru --}}
{{-- @extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Detail Rekam Medis</h1>

    <div class="text-right mb-3">
        <a href="{{ route('rekam-medis.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Rekam Medis
        </a>
    </div>

    <!-- Informasi Pasien -->
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Informasi Pasien</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Nama Pasien</th>
                    <td>{{ $user->nama_lengkap }}</td>
                </tr>
                <tr>
                    <th>NIK</th>
                    <td>{{ $user->nik }}</td>
                </tr>
            </table>
        </div>
    </div>

    <h4 class="mt-4">Riwayat Rekam Medis</h4>

    @if($user->rekamMedis->isEmpty())
        <div class="alert alert-warning text-center mt-3">Belum ada riwayat rekam medis.</div>
    @else
        @foreach($user->rekamMedis as $index => $rekam)
            <div class="card mt-3 shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Rekam Medis #{{ $index + 1 }}</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Tanggal Periksa</th>
                            <td>{{ date('d M Y', strtotime($rekam->tanggal_periksa)) }}</td>
                        </tr>
                        <tr>
                            <th>Umur</th>
                            <td>{{ $rekam->umur }} Tahun</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td><span class="badge badge-info">{{ $rekam->kategori }}</span></td>
                        </tr>
                        <tr>
                            <th>Keluhan</th>
                            <td>{{ $rekam->keluhan }}</td>
                        </tr>
                        <tr>
                            <th>Diagnosa</th>
                            <td>{{ $rekam->diagnosa }}</td>
                        </tr>
                        <tr>
                            <th>Tindakan</th>
                            <td>{{ $rekam->tindakan }}</td>
                        </tr>
                        <tr>
                            <th>Bidan</th>
                            <td>{{ $rekam->admin->nama_lengkap }}</td>
                        </tr>
                    </table>

                    <div class="text-right">
                        <a href="{{ route('rekam-medis.edit', $rekam->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('rekam-medis.destroy', $rekam->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus rekam medis ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection --}}




























{{-- layout terbaru --}}
{{-- @extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Detail Rekam Medis Pasien</h1>

    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Informasi Pasien</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Nama</th>
                    <td>{{ $user->nama_lengkap }}</td>
                </tr>
                <tr>
                    <th>NIK</th>
                    <td>{{ $user->nik }}</td>
                </tr>
            </table>
            <a href="{{ route('rekam-medis.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Rekam Medis
            </a>
        </div>
    </div>

    <!-- Tabel Rekam Medis -->
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Riwayat Rekam Medis</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="rekamMedisTable" class="table table-hover table-striped">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Periksa</th>
                            <th>Umur</th>
                            <th>Kategori</th>
                            <th>Keluhan</th>
                            <th>Diagnosa</th>
                            <th>Tindakan</th>
                            <th>Bidan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->rekamMedis as $index => $rekam)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ date('d M Y', strtotime($rekam->tanggal_periksa)) }}</td>
                            <td>{{ $rekam->umur }} Tahun</td>
                            <td><span class="badge badge-info">{{ $rekam->kategori }}</span></td>
                            <td>{{ $rekam->keluhan }}</td>
                            <td>{{ $rekam->diagnosa }}</td>
                            <td>{{ $rekam->tindakan }}</td>
                            <td>{{ $rekam->admin->nama_lengkap }}</td>
                            <td>
                                <a href="{{ route('rekam-medis.edit', $rekam->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('rekam-medis.destroy', $rekam->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus rekam medis ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- table-responsive -->
        </div> <!-- card-body -->
    </div> <!-- card -->
</div> <!-- container -->
@endsection --}}













{{-- @extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Detail Rekam Medis</h2>

    <table class="table table-bordered">
        <tr>
            <th>Nik</th>
            <td>{{ $rekamMedis->pasien->nik }}</td>
        </tr>
        <tr>
            <th>Nama Pasien</th>
            <td>{{ $rekamMedis->pasien->nama_lengkap }}</td>
        </tr>
        <tr>
            <th>Nama Bidan</th>
            <td>{{ $rekamMedis->admin->nama_lengkap }}</td>
        </tr>
        <tr>
            <th>Umur</th>
            <td>{{ $rekamMedis->umur }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $rekamMedis->kategori }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $rekamMedis->alamat }}</td>
        </tr>
        <tr>
            <th>Keluhan</th>
            <td>{{ $rekamMedis->keluhan }}</td>
        </tr>
        <tr>
            <th>Diagnosa</th>
            <td>{{ $rekamMedis->diagnosa }}</td>
        </tr>
        <tr>
            <th>Tindakan</th>
            <td>{{ $rekamMedis->tindakan }}</td>
        </tr>
        <tr>
            <th>Tanggal Periksa</th>
            <td>{{ $rekamMedis->tanggal_periksa }}</td>
        </tr>
    </table>

    <a href="{{ route('rekam-medis.index') }}" class="btn btn-primary">Kembali</a>
</div>
@endsection --}}
