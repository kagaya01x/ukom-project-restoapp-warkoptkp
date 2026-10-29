<?php

namespace App\Http\Controllers\Auth;

use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class AuthPassportController extends Controller
{
    public function login(Request $request): JsonResponse{
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // cari pengguna bedasarkan username
        $user = UserModel::where('username', $request->username)->first();

        // verifikasi keberadaan user dengan cocokin password
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password tidak sesuai.',
            ], 401);
        }
        //buat personal access token menggunakan passport
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => [
                'id' => $user->user_id,
                'username' => $user->username,
                'role' => $user->role_id,
            ]
        ], 200);
    }
}
