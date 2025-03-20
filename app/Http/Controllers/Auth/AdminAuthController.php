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




    //     public function showLoginForm()
    //     {
    //         if (Auth::guard('admin')->check()) {
    //             return redirect()->route('dashboard');
    //         }
    //         return view('auth.admin-login');
    //     }

    //     public function login(Request $request)
    //     {
    //         $credentials = $request->validate([
    //             'email' => 'required|email',
    //             'password' => 'required'
    //         ]);

    //         if (Auth::guard('admin')->attempt($credentials)) {
    //             $request->session()->regenerate();
    //             return redirect()->route('dashboard');
    //         }

    //         return back()->withErrors([
    //             'email' => 'Email atau password salah.',
    //         ])->onlyInput('email');
    //     }

    //     public function logout(Request $request)
    //     {
    //         Auth::guard('admin')->logout();
    //         $request->session()->invalidate();
    //         $request->session()->regenerateToken();

    //         return redirect()->route('admin.login');
    //     }

    //     public function showRegisterForm()
    //     {
    //         return view('auth.admin-register'); // Pastikan file Blade ini ada di folder resources/views/auth
    //     }

    // /*************  ✨ Codeium Command ⭐  *************/
    //     /**
    //      * Handle an incoming registration request.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    // /******  e600c8e4-ab51-4815-9d74-a57e0915579b  *******/
    //     {
    //         $request->validate([
    //             'email' => 'required|string|email|max:255|unique:admins',
    //             'password' => 'required|string|min:6|confirmed',
    //             'nama_lengkap' => 'required|string|max:255',
    //             'no_hp' => 'required|string|max:255',
    //         ]);

    //         Admin::create([
    //             'email' => $request->email,
    //             'password' => Hash::make($request->password),
    //             'nama_lengkap' => $request->nama_lengkap,
    //             'no_hp' => $request->no_hp
    //         ]);

    //         return redirect()->route('admin.login')->with('success', 'Registrasi berhasil! Silakan login.');
    //     }
}
