<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekamMedis;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use PDF;

class RekamMedisController extends Controller
{

    // public function generatePDF($id)
    // {
    //     $user = User::with('rekamMedis.admin')->findOrFail($id); // Ambil data pasien & rekam medisnya

    //     $pdf = PDF::loadView('rekam-medis.laporan', compact('user'));

    //     return $pdf->download('Laporan_Rekam_Medis_' . $user->nama_lengkap . '.pdf');
    // }

    public function index()
    {
        $rekamMedis = \App\Models\User::with('rekamMedis')->get(); // Ambil user dengan rekam medisnya
        return view('rekam-medis.index', compact('rekamMedis'));
    }

    //  * Pasien melihat hasil rekam medis miliknya.
    //  */
    public function getByUserRekamMedis(Request $request)
    {
        try {
            $user = Auth::user(); // Ambil user yang login

            $rekamMedis = RekamMedis::where('nik', $user->nik) // Cari berdasarkan NIK
                ->with('admin') // Menampilkan siapa bidan yang menangani
                ->get();

            if ($rekamMedis->isEmpty()) {
                return response()->json([
                    'message' => 'Tidak ada rekam medis yang ditemukan untuk pengguna ini',
                ], 404);
            }

            return response()->json([
                'message' => 'Rekam medis pasien ditemukan',
                'rekam_medis' => $rekamMedis,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // API untuk Bidan (Admin)
    public function getAllRekamMedis()
    {
        try {
            $rekamMedis = RekamMedis::with(['admin', 'user'])->get();

            return response()->json([
                'status' => true,
                'message' => 'Semua rekam medis ditemukan',
                'rekam_medis' => $rekamMedis,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $user = \App\Models\User::with('rekamMedis')->findOrFail($id);
        return view('rekam-medis.show', compact('user'));
    }


    /**
     * Menampilkan form tambah rekam medis.
     */
    public function create()
    {
        return view('rekam-medis.create');
    }

    /**
     * Menyimpan rekam medis berdasarkan NIK pasien.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|exists:users,nik',
            'umur' => 'required|integer',
            'kategori' => 'required|in:IBU HAMIL,BALITA',
            'alamat' => 'required|string',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'tanggal_periksa' => 'required|date',
        ]);

        $user = User::where('nik', $request->nik)->first(); // Cari user berdasarkan NIK

        if (!$user) {
            return back()->withErrors(['nik' => 'Pasien dengan NIK ini tidak ditemukan.']);
        }

        RekamMedis::create([
            'user_id' => $user->id, // Gunakan ID user, bukan hanya NIK
            'nik' => $user->nik,
            'admin_id' => Auth::guard('admin')->id(), // Ambil ID admin yang sedang login
            'umur' => $request->umur,
            'kategori' => $request->kategori,
            'alamat' => $request->alamat,
            'keluhan' => $request->keluhan,
            'diagnosa' => $request->diagnosa,
            'tindakan' => $request->tindakan,
            'tanggal_periksa' => $request->tanggal_periksa,
        ]);

        return redirect()->route('rekam-medis.index')->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $rekamMedis = RekamMedis::findOrFail($id); // Ambil satu data rekam medis berdasarkan ID
        $pasien = User::all(); // Ambil semua pasien untuk dropdown

        return view('rekam-medis.edit', compact('rekamMedis', 'pasien'));
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'umur' => 'required|integer|min:0|max:150',
            'kategori' => 'required|in:balita,remaja,ibu hamil,lansia',
            'tanggal_periksa' => 'required|date',
            'alamat' => 'required|string',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
        ]);

        // Cari rekam medis berdasarkan ID
        $rekamMedis = RekamMedis::findOrFail($id);

        // Update data
        $rekamMedis->update([
            'user_id' => $request->user_id,
            'umur' => $request->umur,
            'kategori' => $request->kategori,
            'tanggal_periksa' => $request->tanggal_periksa,
            'alamat' => $request->alamat,
            'keluhan' => $request->keluhan,
            'diagnosa' => $request->diagnosa,
            'tindakan' => $request->tindakan,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('rekam-medis.index')->with('success', 'Rekam Medis berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Cari rekam medis berdasarkan ID
        $rekamMedis = RekamMedis::findOrFail($id);

        // Hapus data rekam medis
        $rekamMedis->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('rekam-medis.index')->with('success', 'Rekam Medis berhasil dihapus!');
    }
}
