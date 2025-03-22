<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\RekamMedis;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class LaporanController extends Controller
{


    public function laporanBulanan(Request $request)
    {
        // Ambil bulan dan tahun dari request, default ke bulan ini
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        // Hitung jumlah konsultasi ibu hamil
        $jumlah_konsultasi = RekamMedis::whereHas('user', function ($query) {
            $query->where('kategori', 'ibu hamil');
        })
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count();

        $pdf = Pdf::loadView('laporan.bulanan', compact('jumlah_konsultasi', 'bulan', 'tahun'));

        return $pdf->download("Laporan_Bulanan_$bulan-$tahun.pdf");
    }
}
