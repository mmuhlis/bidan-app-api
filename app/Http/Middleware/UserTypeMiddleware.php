<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTypeMiddleware
{
    public function handle(Request $request, Closure $next, string $type)
    {
        $user = Auth::guard('admin')->user(); // Gunakan guard admin

        if (!$user) {
            return redirect()->route('admin.login')->withErrors(['message' => 'Silakan login terlebih dahulu.']);
        }

        if ($type === 'bidan' && get_class($user) !== 'App\Models\Admin') {
            return abort(403, 'Akses hanya untuk bidan.');
        }

        return $next($request);
    }
}
















// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
// use App\Models\admin;
// use App\Models\User;

// class UserTypeMiddleware
// {
//     /**
//      * Handle an incoming request.
//      */
//     public function handle(Request $request, Closure $next, string $type): Response
//     {
//         $user = $request->user();

//         // Pastikan user sudah login
//         if (!$user) {
//             return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
//         }

//         // Periksa apakah user sesuai dengan tipe yang diizinkan
//         if ($type === 'bidan' && !$user instanceof admin) {
//             return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
//         }

//         if ($type === 'user' && !$user instanceof User) {
//             return response()->json(['message' => 'Forbidden. User access required.'], 403);
//         }

//         return $next($request);
//     }
// }
