<?php

namespace App\Http\Controllers;

use App\Models\SkriningKehamilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SkriningKehamilan as Skrining;
use App\Models\User;

class SkriningKehamilanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_pengkajian' => 'required|date',
            'bidan_pelaksana' => 'required|string',

            'nama_ibu' => 'required|string',
            'umur_ibu' => 'required|integer',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'hamil_ke' => 'required|integer',
            'hpht' => 'required|date',
            'hpl' => 'required|date',
            'umur_kehamilan' => 'required|string',
            'tempat_periksa' => 'required|string',

            'jawaban_skrining' => 'required|array',
        ]);

        // Hitung skor total
        $totalSkor = 0;
        foreach ($validated['jawaban_skrining'] as $jawaban) {
            if ($jawaban['jawab'] === 'ya') {
                $totalSkor += $jawaban['skor'];
            }
        }

        // Tentukan kategori risiko
        if ($totalSkor >= 12) {
            $kategori = 'KRST';
        } elseif ($totalSkor >= 6) {
            $kategori = 'KRT';
        } else {
            $kategori = 'KRR';
        }

        // Simpan ke database
        $skrining = Skrining::create([
            ...$validated,
            'jawaban_skrining' => json_encode($validated['jawaban_skrining']),
            'total_skor' => $totalSkor,
            'kategori_risiko' => $kategori,
        ]);

        return response()->json([
            'message' => 'Skrining berhasil disimpan',
            'data' => $skrining
        ], 201);
    }


    public function riwayat($user_id)
    {
        $riwayat = Skrining::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $riwayat
        ]);
    }

    public function semua()
    {
        $data = Skrining::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }





    // Hitung skor berdasarkan jawaban Ya/Tidak
    private function hitungSkor($data)
    {
        $skor = 0;
        foreach (range(1, 21) as $i) {
            if (isset($data["p$i"]) && strtolower($data["p$i"]) === 'ya') {
                $skor += 1;
            }
        }
        return $skor;
    }
    private function tentukanKesimpulan($skor)
    {
        if ($skor >= 6) {
            return 'Risiko Tinggi';
        } elseif ($skor >= 3) {
            return 'Perlu Pemantauan';
        } else {
            return 'Normal';
        }
    }

    // User melihat hasil sendiri
    public function result()
    {
        $user = Auth::user();

        $skrining = SkriningKehamilan::where('user_id', $user->id)->latest()->first();

        if (!$skrining) {
            return response()->json([
                'message' => 'Belum ada data skrining ditemukan.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Berhasil mendapatkan data skrining.',
            'data' => $skrining
        ]);
    }
    // public function result()
    // {
    //     $skrining = Skrining::where('user_id', Auth::id())->latest()->first();
    //     return view('skrining.result', compact('skrining'));
    // }

    // Admin melihat semua hasil skrining user
    public function index()
    {
        $semua = Skrining::with('user')->latest()->get();
        return view('admin.skrining.index', compact('semua'));
    }

    // Admin melihat detail skrining tertentu
    public function show($id)
    {
        $skrining = Skrining::with('user')->findOrFail($id);
        return view('admin.skrining.show', compact('skrining'));
    }

    public function riwayatAdmin($user_id)
    {
        $user = User::with('SkriningKehamilan')->findOrFail($user_id);
        return view('admin.skrining.riwayat', compact('user'));
    }
}
