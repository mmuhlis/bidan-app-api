@extends('layouts.admin')

@section('title', 'Dashboard | Smart Bidan')
@section('content')
<div class="container-fluid mt-4">
    {{-- <h1 class="mb-4">Dashboard</h1> --}}

    <div class="row">
        <!-- Widget Jumlah Bidan -->
        <div class="col-lg-4 col-md-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalBidan }}</h3>
                    <p>Total Bidan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-nurse"></i>
                </div>
            </div>
        </div>

        <!-- Widget Jumlah Pasien -->
        <div class="col-lg-4 col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalPasien }}</h3>
                    <p>Total Pasien</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <!-- Widget Jumlah Rekam Medis -->
        <div class="col-lg-4 col-md-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalRekamMedis }}</h3>
                    <p>Total Rekam Medis</p>
                </div>
                <div class="icon">
                    <i class="fas fa-notes-medical"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Statistik -->
    {{-- <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>Statistik Pengguna</h3>
                </div>
                <div class="card-body">
                    <canvas id="userChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>Statistik Rekam Medis</h3>
                </div>
                <div class="card-body">
                    <canvas id="rekamMedisChart"></canvas>
                </div>
            </div>
        </div>
    </div> --}}
</div>

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Statistik Pengguna
    // var ctxUser = document.getElementById('userChart').getContext('2d');
    // new Chart(ctxUser, {
    //     type: 'doughnut',
    //     data: {
    //         labels: ['Bidan', 'Pasien'],
    //         datasets: [{
    //             data: [{{ $totalBidan }}, {{ $totalPasien }}],
    //             backgroundColor: ['#17a2b8', '#28a745']
    //         }]
    //     }
    // });

    // // Statistik Rekam Medis
    // var ctxRekam = document.getElementById('rekamMedisChart').getContext('2d');
    // new Chart(ctxRekam, {
    //     type: 'bar',
    //     data: {
    //         labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
    //         datasets: [{
    //             label: 'Jumlah Rekam Medis',
    //             data: @json($rekamMedisPerBulan),
    //             backgroundColor: '#ffc107'
    //         }]
    //     }
    // });
</script>
@endsection
