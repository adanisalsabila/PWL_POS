<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import model User

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    // public function postlogin(Request $request)
    // {
    //     if ($request->ajax() || $request->wantsJson()) {
    //         $credentials = $request->only('username', 'password');
    //         if (Auth::attempt($credentials)) {
    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Login Berhasil',
    //                 'redirect' => url('/')
    //             ]);
    //         }
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Login Gagal'
    //         ]);
    //     }
    //     return redirect('login');
    // }
    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Bypass database check entirely and log the user in immediately
            $user = new \App\Models\User([
                'id' => 1, // or set any user ID, or use an empty user object for demo
                'name' => 'Administrator',
                'email' => 'dummy@example.com',
                'password' => '', // Empty password as we're bypassing validation
                'username' => 'admin', // Tambahkan username
                'level_id' => 1,
                'level_kode' => 'ADM',
                // Tambahkan kolom lain yang ada pada model user.
            ]);

            Auth::login($user);

            return response()->json([
                'status' => true,
                'message' => 'Login Berhasil',
                'redirect' => url('/')
            ]);
        }

        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}