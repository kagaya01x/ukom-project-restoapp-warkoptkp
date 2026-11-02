<?php

namespace App\Http\Controllers\Auth;

use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class AuthPassportController extends Controller
{
    public function index(){
        return view('login');
    }

    public function login(Request $request): JsonResponse{
        
        // validasi input
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // cari pengguna bedasarkan username
        $user = UserModel::where('username', $credentials['username'])->first();

        // cek apakah pengguna ada dan password sesuai
        if(!$user || !Hash::check($credentials['password'], $user->password)){

            return response()->json([
                'success' => false,
                'message' => 'Username atau password tidak sesuai.',
            ], 401);
        }
        //user berhasil login lalu buat token akses

        Auth::login($user);
        $request->session()->regenerate();
        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil',
            'redirect' => route('dashboard'),
            'data' => [
                'id' => $user->user_id,
                'username' => $user->username,
                'role' => $user->role_id,
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
