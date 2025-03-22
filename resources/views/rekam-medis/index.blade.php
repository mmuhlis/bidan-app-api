@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-notes-medical"></i> Daftar Rekam Medis</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('rekam-medis.create') }}" class="btn btn-success mb-3">
                        <i class="fas fa-plus"></i> Tambah Rekam Medis
                    </a>

                    <div class="table-responsive">
                        <table id="rekamMedisTable" class="table table-hover table-striped">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama Pasien</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rekamMedis as $index => $pasien)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pasien->nik }}</td>
                                    <td>{{ $pasien->nama_lengkap }}</td>
                                    <td>
                                        <a href="{{ route('rekam-medis.show', $pasien->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                        {{-- <a href="{{ route('rekam-medis.pdf', $pasien->id) }}" class="btn btn-danger btn-sm">
                                            <i class="fas fa-file-pdf"></i> Download Laporan PDF
                                        </a>
                                        <a href="{{ route('laporan.bulanan', ['bulan' => now()->month, 'tahun' => now()->year]) }}" class="btn btn-primary">
                                            Download Laporan Bulanan
                                        </a> --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- table-responsive -->
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col-md-12 -->
    </div> <!-- row -->
</div> <!-- container-fluid -->
@endsection
