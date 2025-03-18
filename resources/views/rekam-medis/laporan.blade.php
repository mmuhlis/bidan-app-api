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
    </style>
</head>
<body>
    <h2>Laporan Rekam Medis</h2>
    <p><strong>Nama:</strong> {{ $user->nama_lengkap }}</p>
    <p><strong>NIK:</strong> {{ $user->nik }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal Periksa</th>
                <th>Umur</th>
                <th>Kategori</th>
                <th>Keluhan</th>
                <th>Diagnosa</th>
                <th>Tindakan</th>
                <th>Bidan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user->rekamMedis as $rekam)
            <tr>
                <td>{{ date('d M Y', strtotime($rekam->tanggal_periksa)) }}</td>
                <td>{{ $rekam->umur }} Tahun</td>
                <td>{{ $rekam->kategori }}</td>
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
