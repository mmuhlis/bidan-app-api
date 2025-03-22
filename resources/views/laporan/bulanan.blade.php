<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Konsultasi Bulanan</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        h1 { color: #333; }
        .container { margin: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 10px; }
        .data { font-size: 18px; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Konsultasi Ibu Hamil</h1>
        <p>Bulan: {{ \Carbon\Carbon::create()->month((int)$bulan)->format('F') }} {{ $tahun }}</p>
        <p class="data">Jumlah Konsultasi: {{ $jumlah_konsultasi }}</p>
    </div>
</body>
</html>
