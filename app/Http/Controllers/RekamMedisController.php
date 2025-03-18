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

    public function getByUser(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Data rekam medis',
            'data' => RekamMedis::with(['user', 'admin'])->get()
        ]);
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



    // public function edit($id)
    // {
    //     $rekamMedis = RekamMedis::findOrFail($id);
    //     return view('rekam-medis.edit', compact('rekamMedis'));
    // }
}























// namespace App\Http\Controllers;

// use App\Models\RekamMedis;
// use App\Models\admin;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class RekamMedisController extends Controller
// {
//     public function index()
//     {
//         // Ambil semua data rekam medis dengan relasi pasien & admin
//         $rekamMedis = RekamMedis::with('pasien')->get();

//         return view('rekam-medis.index', compact('rekamMedis'));
//     }

//     public function create()
//     {
//         // Ambil daftar pasien untuk dropdown pilihan
//         $pasien = User::all();

//         return view('rekam-medis.create', compact('pasien'));
//     }

//     public function store(Request $request)
//     {
//         // Validasi input
//         $request->validate([
//             'user_id' => 'required|exists:users,id',
//             'umur' => 'required|integer',
//             'kategori' => 'required|in:IBU HAMIL,BALITA,REMAJA,LANSIA',
//             'alamat' => 'required|string|max:255',
//             'keluhan' => 'required|string|max:255',
//             'diagnosa' => 'required|string|max:255',
//             'tindakan' => 'required|string|max:255',
//             'tanggal_periksa' => 'required|date',
//         ]);

//         // Simpan data ke tabel rekam_medis
//         $rekamMedis = RekamMedis::create([
//             'user_id' => $request->user_id,
//             'admin_id' => Auth::guard('admin')->id(), // Ambil ID admin yang login
//             'umur' => $request->umur,
//             'kategori' => $request->kategori,
//             'alamat' => $request->alamat,
//             'keluhan' => $request->keluhan,
//             'diagnosa' => $request->diagnosa,
//             'tindakan' => $request->tindakan,
//             'tanggal_periksa' => $request->tanggal_periksa,
//         ]);

//         return redirect()->route('rekam-medis.index')->with('success', 'Rekam medis berhasil ditambahkan.');
//     }

//     public function show($id)
//     {
//         // Ambil satu data rekam medis berdasarkan ID dengan relasi pasien & admin
//         $rekamMedis = RekamMedis::with(['pasien', 'admin'])->findOrFail($id);

//         // Kirim data ke view
//         return view('rekam-medis.show', compact('rekamMedis'));
//     }

//     public function edit($id)
//     {
//         $rekamMedis = RekamMedis::findOrFail($id);
//         $pasien = User::all(); // Ambil semua pasien untuk dropdown
//         return view('rekam-medis.edit', compact('rekamMedis', 'pasien'));
//     }

//     public function update(Request $request, $id)
//     {
//         $rekamMedis = RekamMedis::findOrFail($id);

//         $request->validate([
//             'user_id' => 'required|exists:users,id',
//             'umur' => 'required|integer',
//             'kategori' => 'required|in:ibu hamil,balita,remaja,lansia',
//             'alamat' => 'required|string|max:255',
//             'keluhan' => 'required|string|max:255',
//             'diagnosa' => 'required|string|max:255',
//             'tindakan' => 'required|string|max:255',
//             'tanggal_periksa' => 'required|date',
//         ]);

//         $rekamMedis->update($request->all());

//         return redirect()->route('rekam-medis.index')->with('success', 'Rekam medis berhasil diperbarui.');
//     }

//     public function destroy($id)
//     {
//         $rekamMedis = RekamMedis::findOrFail($id);
//         $rekamMedis->delete();

//         return redirect()->route('rekam-medis.index')->with('success', 'Rekam medis berhasil dihapus.');
//     }








/**
 * Admin/Bidan membuat rekam medis pasien.
 */
    // public function store(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'user_id' => 'required|exists:users,id', // ID Pasien
    //             'nama' => 'required|string|max:255',
    //             'umur' => 'required|integer|min:0',
    //             'kategori' => 'required|in:IBU HAMIL,BALITA,REMAJA,LANSIA',
    //             'alamat' => 'required|string|max:255',
    //             'keluhan' => 'required|string',
    //             'diagnosa' => 'required|string',
    //             'tindakan' => 'required|string',
    //             'tanggal_periksa' => 'required|date',
    //         ]);

    //         // Admin/Bidan yang sedang login
    //         $admin = Auth::user();

    //         $rekamMedis = RekamMedis::create([
    //             'user_id' => $request->user_id, // Pasien
    //             'admin_id' => $admin->id, // Bidan/Admin
    //             'nama' => $request->nama,
    //             'umur' => $request->umur,
    //             'kategori' => $request->kategori,
    //             'alamat' => $request->alamat,
    //             'keluhan' => $request->keluhan,
    //             'diagnosa' => $request->diagnosa,
    //             'tindakan' => $request->tindakan,
    //             'tanggal_periksa' => $request->tanggal_periksa,
    //         ]);

    //         return response()->json([
    //             'message' => 'Rekam medis berhasil dibuat',
    //             'rekam_medis' => $rekamMedis,
    //         ], 201);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Terjadi kesalahan saat menyimpan rekam medis',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // /**
    //  * Pasien melihat hasil rekam medis miliknya.
    //  */
    // public function getByUser(Request $request)
    // {
    //     try {
    //         $user = Auth::user(); // Ambil user yang login

    //         $rekamMedis = RekamMedis::where('user_id', $user->id)
    //             ->with('bidan') // Menampilkan siapa bidan yang menangani
    //             ->get();

    //         if ($rekamMedis->isEmpty()) {
    //             return response()->json([
    //                 'message' => 'Tidak ada rekam medis yang ditemukan untuk pengguna ini',
    //             ], 404);
    //         }

    //         return response()->json([
    //             'message' => 'Rekam medis pasien ditemukan',
    //             'rekam_medis' => $rekamMedis,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Terjadi kesalahan saat mengambil data',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // /**
    //  * Admin/Bidan melihat semua rekam medis.
    //  */
    // public function index()
    // {
    //     try {
    //         $rekamMedis = RekamMedis::with(['pasien', 'bidan'])->get();

    //         if ($rekamMedis->isEmpty()) {
    //             return response()->json([
    //                 'message' => 'Belum ada rekam medis yang tersedia',
    //             ], 404);
    //         }

    //         return response()->json([
    //             'message' => 'Semua rekam medis berhasil diambil',
    //             'rekam_medis' => $rekamMedis,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Terjadi kesalahan saat mengambil data rekam medis',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }
    // public function update(Request $request, $id)
    // {
    //     try {
    //         $request->validate([
    //             'keluhan' => 'required|string',
    //             'diagnosa' => 'required|string',
    //             'tindakan' => 'required|string',
    //         ]);

    //         $rekamMedis = RekamMedis::findOrFail($id);
    //         $rekamMedis->update([
    //             'keluhan' => $request->keluhan,
    //             'diagnosa' => $request->diagnosa,
    //             'tindakan' => $request->tindakan,
    //         ]);

    //         return response()->json([
    //             'message' => 'Rekam medis berhasil diperbarui',
    //             'rekam_medis' => $rekamMedis,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Gagal memperbarui rekam medis',
    //             'error' => $e->getMessage(),
    //         ], 400);
    //     }
    // }
    // public function destroy($id)
    // {
    //     try {
    //         $rekamMedis = RekamMedis::findOrFail($id);
    //         $rekamMedis->delete();

    //         return response()->json([
    //             'message' => 'Rekam medis berhasil dihapus',
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Gagal menghapus rekam medis',
    //             'error' => $e->getMessage(),
    //         ], 400);
    //     }
    // }
