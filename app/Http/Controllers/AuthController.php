<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Method untuk menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Method untuk memproses data login (POST)
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login
       if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
            
            // Jika sukses, arahkan ke dashboard (atau halaman tujuan)
            // Pastikan kamu punya route '/dashboard' atau sesuaikan url ini
          return redirect()->intended('dashboard'); 
    }
        // Jika gagal, kembalikan ke form login dengan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }
    
    // Method Logout (Opsional, nanti pasti butuh)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}