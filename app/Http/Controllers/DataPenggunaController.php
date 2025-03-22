<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;

class DataPenggunaController extends Controller
{
    public function index()
    {
        $admins = Admin::all(); // Ambil data bidan
        $users = User::all(); // Ambil data pasien

        return view('data-pengguna.index', compact('admins', 'users'));
    }

    public function getUsers()
    {
        $admins = Admin::all(); // Data bidan
        $users = User::all(); // Data pasien

        return response()->json([
            'status' => true,
            'message' => 'Data pengguna',
            'data' => [
                'admins' => $admins,
                'users' => $users
            ]
        ]);
    }

    public function create()
    {
        return view('data-pengguna.create');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('data-pengguna.index')->with('success', 'Data berhasil dihapus!');
    }
}
