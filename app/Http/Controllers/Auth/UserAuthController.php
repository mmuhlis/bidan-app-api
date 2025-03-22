<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        // Buat token untuk user
        $token = $user->createToken('user-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'nik' => 'required|numeric|unique:users',
            'nama_lengkap' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required|numeric',
        ]);

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'nik' => $validatedData['nik'],
            'nama_lengkap' => $validatedData['nama_lengkap'],
            'alamat' => $validatedData['alamat'],
            'no_hp' => $validatedData['no_hp'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'data' => $user,
        ], 201);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil'], 200);
    }

    public function getPasienById($id)
    {
        $pasien = User::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Data Pasien berhasil diambil',
            'data' => [
                'id' => $pasien->id,
                'nama_lengkap' => $pasien->nama_lengkap,
                'email' => $pasien->email,
                'nik' => $pasien->nik,
                'alamat' => $pasien->alamat,
                'no_hp' => $pasien->no_hp,
            ]
        ], 200);
    }
    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id); // Ambil data user berdasarkan ID

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        // Validasi input
        $request->validate([
            'email' => 'email|unique:users,email,' . $id,
            'nama_lengkap' => 'string|max:255',
            'nik' => 'numeric|unique:users,nik,' . $id,
            'alamat' => 'string',
            'no_hp' => 'string|max:15',
        ]);

        // Update data
        $user->update($request->only(['email', 'nama_lengkap', 'nik', 'alamat', 'no_hp']));

        return response()->json([
            'message' => 'Profil user berhasil diperbarui',
            'data' => $user
        ], 200);
    }
}
