<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekam Medis</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2, h3 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Rekam Medis</h2>
    <h3>Nama Pasien: {{ $user->nama_lengkap }}</h3>
    <h3>NIK: {{ $user->nik }}</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Periksa</th>
                <th>Umur</th>
                <th>Keluhan</th>
                <th>Diagnosa</th>
                <th>Tindakan</th>
                <th>Bidan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user->rekamMedis as $index => $rekam)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ date('d M Y', strtotime($rekam->tanggal_periksa)) }}</td>
                <td>{{ $rekam->umur }} Tahun</td>
                <td>{{ $rekam->keluhan }}</td>
                <td>{{ $rekam->diagnosa }}</td>
                <td>{{ $rekam->tindakan }}</td>
                <td>{{ $rekam->admin->nama_lengkap }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
