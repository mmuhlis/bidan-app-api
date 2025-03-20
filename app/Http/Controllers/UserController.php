<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use App\Models\RekamMedis;
use App\Models\Admin;

class UserController extends Controller
{
    public function index()
    {
        $patients = User::all(); // Mengambil semua pasien
        return view('data-pasien.index', compact('patients'));
    }

    public function getByPasien()
    {
        $patients = User::all(); // Ambil semua pasien

        return response()->json([
            'status' => true,
            'message' => 'Data pasien',
            'data' => $patients
        ]);
    }



    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('data-pengguna.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('data-pengguna.index')->with('success', 'Data berhasil dihapus!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,user',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|unique:admins,email',
            'password' => 'required|string|min:6',
            'no_hp' => 'required|string|max:20',
            'nik' => 'nullable|required_if:role,user|unique:users,nik',
            'alamat' => 'nullable|required_if:role,user|string|max:255',
        ]);

        if ($request->role === 'admin') {
            Admin::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_hp' => $request->no_hp,
            ]);
        } else {
            User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nik' => $request->nik,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);
        }

        return redirect()->back()->with('success', 'Akun berhasil ditambahkan.');
    }


    public function register(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'nama_lengkap' => 'required|string|max:255',
                'alamat' => 'required|string|max:255',
                'no_hp' => 'required|string|max:255',
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $avatarPath = $request->hasFile('avatar') ? $request->file('avatar')->store('images/users', 'public') : null;

            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'avatar' => $avatarPath,
            ]);

            return response()->json(['message' => 'Pendaftaran berhasil', 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Pendaftaran gagal', 'error' => $e->getMessage()], 400);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages(['email' => ['Kredensial salah.']]);
            }

            $token = $user->createToken('user_auth_token')->plainTextToken;

            return response()->json(['message' => 'Masuk berhasil', 'user' => $user, 'token' => $token]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Masuk gagal', 'error' => $e->getMessage()], 400);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }

    public function profile(Request $request)
    {
        return response()->json(['message' => 'Berhasil mendapatkan profil', 'user' => $request->user()]);
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();

            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'nama_lengkap' => 'nullable|string|max:255',
                'alamat' => 'nullable|string|max:255',
                'no_hp' => 'nullable|string|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('avatar')) {
                Storage::disk('public')->delete($user->avatar);
                $user->avatar = $request->file('avatar')->store('avatars', 'public');
            }

            $user->fill($request->only(['name', 'email', 'nama_lengkap', 'alamat', 'no_hp']));
            $user->save();

            return response()->json(['message' => 'Profil berhasil diperbarui', 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui profil', 'error' => $e->getMessage()], 400);
        }
    }
}
