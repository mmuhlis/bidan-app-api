@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-file-medical"></i> Tambah Rekam Medis</h4>
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

            <form action="{{ route('rekam-medis.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nik"><i class="fas fa-id-card"></i> NIK Pasien</label>
                            <input type="text" class="form-control" name="nik" placeholder="Masukkan NIK pasien" required>
                        </div>

                        <div class="form-group">
                            <label for="umur"><i class="fas fa-birthday-cake"></i> Umur</label>
                            <input type="number" class="form-control" name="umur" placeholder="Masukkan umur pasien" required>
                        </div>

                        <div class="form-group">
                            <label for="kategori"><i class="fas fa-user-tag"></i> Kategori</label>
                            <select class="form-control" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="IBU HAMIL">IBU HAMIL</option>
                                <option value="BALITA">BALITA</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="alamat"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                            <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat pasien" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="keluhan"><i class="fas fa-exclamation-triangle"></i> Keluhan</label>
                            <textarea class="form-control" name="keluhan" rows="2" placeholder="Keluhan pasien" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="diagnosa"><i class="fas fa-stethoscope"></i> Diagnosa</label>
                            <textarea class="form-control" name="diagnosa" rows="2" placeholder="Diagnosa dokter" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="tindakan"><i class="fas fa-notes-medical"></i> Tindakan</label>
                            <textarea class="form-control" name="tindakan" rows="2" placeholder="Tindakan yang diberikan" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_periksa"><i class="fas fa-calendar-alt"></i> Tanggal Periksa</label>
                            <input type="date" class="form-control" name="tanggal_periksa" required>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <button type="button" class="btn btn-secondary" onclick="history.back()">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection








































{{-- @extends('layouts.admin')

@section('content')
<div class="container-fluid">
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Rekam Medis</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('rekam-medis.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama Pasien</label>
                            <select name="user_id" class="form-control">
                                @foreach ($pasien as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Umur</label>
                            <input type="number" name="umur" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="IBU HAMIL">IBU HAMIL</option>
                                <option value="BALITA">BALITA</option>
                            </select>
                        </div>                        
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" name="alamat" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Keluhan</label>
                            <input type="text" name="keluhan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Diagnosa</label>
                            <input type="text" name="diagnosa" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tindakan</label>
                            <input type="text" name="tindakan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Periksa</label>
                            <input type="date" name="tanggal_periksa" class="form-control" required value="{{ date('Y-m-d') }}">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('rekam-medis.index') }}" class="btn btn-primary">Kembali</a>
                    </form>
                    
                </div>
            </div>
        </div>
    </section>
</div>
@endsection --}}
