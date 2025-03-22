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
}
