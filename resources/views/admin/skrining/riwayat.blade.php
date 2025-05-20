@extends('layouts.admin')

@section('title', 'Detail Skrining Pasien | Smart Bidan')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Riwayat Skrining Pasien</h1>

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

    <!-- Riwayat Skrining -->
    <h4 class="mt-4">Riwayat Skrining Kehamilan</h4>

    @if($user->skriningKehamilan->isEmpty())
        <div class="alert alert-warning text-center mt-3">Belum ada data skrining.</div>
    @else
        @foreach($user->skriningKehamilan as $index => $skrining)
            <div class="card mt-3 shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Skrining #{{ $index + 1 }} - {{ $skrining->tanggal_pengkajian }}</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Bidan Pelaksana</th>
                            <td>{{ $skrining->bidan_pelaksana }}</td>
                        </tr>
                        <tr>
                            <th>Umur Ibu</th>
                            <td>{{ $skrining->umur_ibu }} tahun</td>
                        </tr>
                        <tr>
                            <th>Skor Total</th>
                            <td>{{ $skrining->total_skor }}</td>
                        </tr>
                        <tr>
                            <th>Kategori Risiko</th>
                            <td><span class="badge badge-info">{{ $skrining->kategori_risiko }}</span></td>
                        </tr>
                    </table>

                    <h6>Jawaban Skrining:</h6>
                    <ol>
                        @foreach(json_decode($skrining->jawaban_skrining, true) as $item)
                            <li>
                                <strong>{{ $item['pertanyaan'] ?? 'Pertanyaan tidak tersedia' }}</strong><br>
                                Jawaban: {{ strtoupper($item['jawab'] ?? '-') }} (Skor: {{ ($item['jawab'] ?? '-') == 'ya' ? ($item['skor'] ?? 0) : 0 }})
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
