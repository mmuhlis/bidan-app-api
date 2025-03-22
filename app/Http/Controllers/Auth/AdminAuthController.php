<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $admin = Admin::where('email', $request->email)->first();

            if (!$admin || !Hash::check($request->password, $admin->password)) {
                throw ValidationException::withMessages(['email' => ['Kredensial salah.']]);
            }

            $token = $admin->createToken('admin_auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Masuk berhasil',
                'admin' => ['id' => $admin->id, 'name' => $admin->name, 'email' => $admin->email],
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Email atau password salah', 'error' => $e->getMessage()], 400);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|unique:admins',
                'password' => 'required|string|min:6|confirmed',
                'nama_lengkap' => 'required|string|max:255',
                'no_hp' => 'required|string|max:255',
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $admin = Admin::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nama_lengkap' => $request->nama_lengkap,
                'no_hp' => $request->no_hp,
                'avatar' => $request->avatar
            ]);

            $token = $admin->createToken('admin_auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Registrasi berhasil',
                'admin' => ['id' => $admin->id, 'name' => $admin->name, 'email' => $admin->email],
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Registrasi gagal', 'error' => $e->getMessage()], 400);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Keluar berhasil']);
    }

    public function getAdminById($id)
    {
        $bidan = Admin::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Data bidan berhasil diambil',
            'data' => [
                'id' => $bidan->id,
                'nama_lengkap' => $bidan->nama_lengkap,
                'email' => $bidan->email,
                'no_hp' => $bidan->no_hp,
            ]
        ], 200);
    }

    public function updateProfile(Request $request, $id)
    {
        $bidan = Admin::find($id); // Ambil data bidan berdasarkan ID

        if (!$bidan) {
            return response()->json([
                'message' => 'Bidan tidak ditemukan'
            ], 404);
        }

        // Validasi data
        $request->validate([
            'nama_lengkap' => 'string|max:255',
            'email' => 'email|unique:admins,email,' . $id,
            'no_hp' => 'string|max:15',
        ]);

        // Update data
        $bidan->update($request->only(['nama_lengkap', 'email', 'no_hp']));

        return response()->json([
            'message' => 'Profil bidan berhasil diperbarui',
            'data' => $bidan
        ], 200);
    }
}
