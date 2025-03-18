@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="nav-icon fas fa-user-injured"></i> Data Pasien </h4>
        </div>
        <div class="card-body">
            <!-- Input pencarian -->
            <div class="mb-3">
                <input type="text" class="form-control" id="searchInput" placeholder="Cari pasien...">
            </div>

            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>Alamat</th>
                        <th>No Hp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="patientTable">
                    @foreach($patients as $patient)
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>{{ $patient->nik }}</td>
                        <td>{{ $patient->nama_lengkap }}</td>
                        <td>{{ $patient->alamat }}</td>
                        <td>{{ $patient->no_hp }}</td>
                        <td>
                            <a href="{{ route('rekam-medis.show', $patient->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Lihat Rekam Medis
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script pencarian -->
<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#patientTable tr');

        rows.forEach(row => {
            let name = row.cells[1].textContent.toLowerCase();
            row.style.display = name.includes(value) ? '' : 'none';
        });
    });
</script>
@endsection
