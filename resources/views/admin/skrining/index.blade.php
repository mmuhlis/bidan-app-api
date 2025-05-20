@extends('layouts.admin')
@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-heartbeat"></i> Data Skrining Kehamilan</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>No</th>
                            <th>Nama Pasien</th>
                            <th>Jumlah Skrining</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grouped = $semua->groupBy('user_id'); @endphp
                        @foreach($grouped as $user_id => $skriningList)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $skriningList->first()->nama_ibu }}</td>
                            <td>{{ $skriningList->count() }}</td>
                            <td>
                                <a href="{{ route('admin.skrining.riwayat', $user_id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat Semua Skrining
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
