@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Rekam Medis</h4>
        </div>
        <div class="card-body">
            <!-- Tampilkan error jika ada -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('rekam-medis.update', $rekamMedis->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Pasien -->
                    <div class="col-md-6 mb-3">
                        <label for="user_id" class="form-label"><i class="fas fa-user"></i> Pasien</label>
                        <select name="user_id" class="form-control" required>
                            @foreach($pasien as $p)
                                <option value="{{ $p->id }}" {{ old('user_id', $rekamMedis->user_id) == $p->id ? 'selected' : '' }}>
                                    {{ $p->nik }} - {{ $p->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Umur -->
                    <div class="col-md-6 mb-3">
                        <label for="umur" class="form-label"><i class="fas fa-calendar"></i> Umur</label>
                        <input type="number" name="umur" class="form-control" value="{{ old('umur', $rekamMedis->umur) }}" required min="0" max="150">
                    </div>
                </div>

                <div class="row">
                    <!-- Kategori -->
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label"><i class="fas fa-list"></i> Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="ibu hamil" {{ old('kategori', $rekamMedis->kategori) == 'ibu hamil' ? 'selected' : '' }}>Ibu Hamil</option>
                            <option value="balita" {{ old('kategori', $rekamMedis->kategori) == 'balita' ? 'selected' : '' }}>Balita</option>
                        </select>
                    </div>

                    <!-- Tanggal Periksa -->
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_periksa" class="form-label"><i class="fas fa-calendar-alt"></i> Tanggal Periksa</label>
                        <input type="date" name="tanggal_periksa" class="form-control" value="{{ old('tanggal_periksa', $rekamMedis->tanggal_periksa) }}" required>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $rekamMedis->alamat) }}</textarea>
                </div>

                <!-- Keluhan -->
                <div class="mb-3">
                    <label for="keluhan" class="form-label"><i class="fas fa-comment-medical"></i> Keluhan</label>
                    <textarea name="keluhan" class="form-control" rows="2" required>{{ old('keluhan', $rekamMedis->keluhan) }}</textarea>
                </div>

                <!-- Diagnosa -->
                <div class="mb-3">
                    <label for="diagnosa" class="form-label"><i class="fas fa-stethoscope"></i> Diagnosa</label>
                    <textarea name="diagnosa" class="form-control" rows="2" required>{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
                </div>

                <!-- Tindakan -->
                <div class="mb-3">
                    <label for="tindakan" class="form-label"><i class="fas fa-notes-medical"></i> Tindakan</label>
                    <textarea name="tindakan" class="form-control" rows="2" required>{{ old('tindakan', $rekamMedis->tindakan) }}</textarea>
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('rekam-medis.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
