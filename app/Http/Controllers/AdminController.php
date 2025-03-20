<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBidan = Admin::count();
        $totalPasien = User::count();
        $totalRekamMedis = RekamMedis::count();

        // Hitung jumlah rekam medis per bulan
        $rekamMedisPerBulan = RekamMedis::selectRaw("MONTH(created_at) as bulan, COUNT(*) as total")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total')
            ->toArray();

        return view('admin.dashboard', compact('totalBidan', 'totalPasien', 'totalRekamMedis', 'rekamMedisPerBulan'));
    }


    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // public function logout(Request $request)
    // {
    //     Auth::guard('admin')->logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect()->route('admin.login');
    // }

    public function showRegisterForm()
    {
        return view('auth.admin-register'); // Pastikan file Blade ini ada di folder resources/views/auth
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:6|confirmed',
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
        ]);

        Admin::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp' => $request->no_hp
        ]);

        return redirect()->route('admin.login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('data-pengguna.index')->with('success', 'Data Admin berhasil dihapus.');
    }

    public function edit()
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        return view('admin.profile.edit', compact('admin'));
    }

    public function show()
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        return view('admin.profile.show', compact('admin'));
    }


    // // Menampilkan Profil Admin
    public function showProfile()
    {
        $admin = Auth::user();
        return view('admin.profile.profile', compact('admin'));
    }

    // Halaman Edit Profil
    public function editProfile()
    {
        $admin = Auth::user();
        return view('admin.profile.edit', compact('admin'));
    }

    // Update Profil
    public function updateProfile(Request $request)
    {
        $admin = Admin::find(Auth::id());

        if (!$admin) {
            return redirect()->back()->with('error', 'Admin tidak ditemukan.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $admin->nama_lengkap = $request->nama_lengkap;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = bcrypt($request->password);
        }

        $admin->save();

        return redirect()->route('admin.profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }













    // public function register(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'name' => 'required|string|max:255',
    //             'email' => 'required|string|email|max:255|unique:admins',
    //             'password' => 'required|string|min:8',
    //             'nama_lengkap' => 'required|string|max:255',
    //             'alamat' => 'required|string|max:255',
    //             'tempat_praktek' => 'required|string|max:255',
    //             'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //         ]);

    //         $avatarPath = $request->hasFile('avatar') ? $request->file('avatar')->store('images/admins', 'public') : null;

    //         $admin = Admin::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'password' => Hash::make($request->password),
    //             'nama_lengkap' => $request->nama_lengkap,
    //             'alamat' => $request->alamat,
    //             'tempat_praktek' => $request->tempat_praktek,
    //             'avatar' => $avatarPath,
    //         ]);

    //         return response()->json(['message' => 'Pendaftaran berhasil', 'admin' => $admin], 201);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Pendaftaran gagal', 'error' => $e->getMessage()], 400);
    //     }
    // }

    // public function login(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'email' => 'required|email',
    //             'password' => 'required|string',
    //         ]);

    //         $admin = Admin::where('email', $request->email)->first();

    //         if (!$admin || !Hash::check($request->password, $admin->password)) {
    //             throw ValidationException::withMessages(['email' => ['Kredensial salah.']]);
    //         }

    //         $token = $admin->createToken('admin_auth_token')->plainTextToken;

    //         return response()->json([
    //             'message' => 'Masuk berhasil',
    //             'admin' => ['id' => $admin->id, 'name' => $admin->name, 'email' => $admin->email],
    //             'token' => $token,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Masuk gagal', 'error' => $e->getMessage()], 400);
    //     }
    // }

    // public function logout(Request $request)
    // {
    //     $request->user()->currentAccessToken()->delete();
    //     return response()->json(['message' => 'Keluar berhasil']);
    // }

    // public function profile(Request $request)
    // {
    //     return response()->json($request->user());
    // }

    // public function updateProfile(Request $request)
    // {
    //     try {
    //         $admin = $request->user();

    //         $request->validate([
    //             'name' => 'nullable|string|max:255',
    //             'email' => 'nullable|email|unique:admins,email,' . $admin->id,
    //             'nama_lengkap' => 'nullable|string|max:255',
    //             'alamat' => 'nullable|string|max:255',
    //             'tempat_praktek' => 'nullable|string|max:255',
    //             'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         ]);

    //         if ($request->hasFile('avatar')) {
    //             Storage::disk('public')->delete($admin->avatar);
    //             $admin->avatar = $request->file('avatar')->store('avatars', 'public');
    //         }

    //         $admin->fill($request->only(['name', 'email', 'nama_lengkap', 'alamat', 'tempat_praktek']));
    //         $admin->save();

    //         return response()->json(['status' => 'success', 'admin' => $admin]);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Gagal memperbarui profil', 'error' => $e->getMessage()], 500);
    //     }
    // }

    // public function listUsers()
    // {
    //     try {
    //         $users = User::all()->map(function ($user) {
    //             if ($user->avatar) {
    //                 $user->avatar = url('storage/' . $user->avatar);
    //             }
    //             return $user;
    //         });

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Semua pengguna berhasil didapatkan',
    //             'users' => $users
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal mengambil daftar pengguna',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function getUser($id)
    // {
    //     try {
    //         $user = User::findOrFail($id);

    //         if ($user->avatar) {
    //             $user->avatar = url('storage/' . $user->avatar);
    //         }

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Pengguna berhasil ditemukan',
    //             'user' => $user
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Pengguna tidak ditemukan',
    //             'error' => $e->getMessage()
    //         ], 404);
    //     }
    // }

    // public function updateUser(Request $request, $id)
    // {
    //     try {
    //         $user = User::findOrFail($id);

    //         $request->validate([
    //             'name' => 'nullable|string|max:255',
    //             'email' => 'nullable|email|unique:users,email,' . $user->id,
    //             'nama_lengkap' => 'nullable|string|max:255',
    //             'alamat' => 'nullable|string|max:255',
    //             'no_hp' => 'nullable|string|max:255',
    //             'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         ]);

    //         if ($request->hasFile('avatar')) {
    //             if ($user->avatar) {
    //                 Storage::disk('public')->delete($user->avatar);
    //             }
    //             $avatarPath = $request->file('avatar')->store('avatars', 'public');
    //             $user->avatar = $avatarPath;
    //         }

    //         $user->update($request->only(['name', 'email', 'nama_lengkap', 'alamat', 'no_hp']));

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Data pengguna berhasil diperbarui',
    //             'user' => $user
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal memperbarui data pengguna',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function deleteUser($id)
    // {
    //     try {
    //         $user = User::findOrFail($id);

    //         if ($user->avatar) {
    //             Storage::disk('public')->delete($user->avatar);
    //         }

    //         $user->delete();

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Pengguna berhasil dihapus'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal menghapus pengguna',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function searchUsers(Request $request)
    // {
    //     try {
    //         $query = User::query();

    //         if ($request->has('name')) {
    //             $query->where('name', 'like', '%' . $request->name . '%');
    //         }
    //         if ($request->has('email')) {
    //             $query->where('email', 'like', '%' . $request->email . '%');
    //         }
    //         if ($request->has('nama_lengkap')) {
    //             $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
    //         }
    //         if ($request->has('alamat')) {
    //             $query->where('alamat', 'like', '%' . $request->alamat . '%');
    //         }
    //         if ($request->has('no_hp')) {
    //             $query->where('no_hp', 'like', '%' . $request->no_hp . '%');
    //         }

    //         $users = $query->get()->map(function ($user) {
    //             if ($user->avatar) {
    //                 $user->avatar = url('storage/' . $user->avatar);
    //             }
    //             return $user;
    //         });

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Hasil pencarian pengguna berhasil didapatkan',
    //             'users' => $users
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal mencari pengguna',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
}
