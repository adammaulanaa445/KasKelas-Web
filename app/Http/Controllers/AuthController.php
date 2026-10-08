<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    /// Form Login
    public function showLogin() { return view('auth.login'); }

    // Form Register
    public function showRegister() { return view('auth.register'); }

    // Proses Simpan User Baru
    public function register(Request $request) {
    // Validasi sederhana
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:5',
    ]);

    \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
    ]);

    return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
}

    // Proses Login
    public function login(Request $request) {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard');
        }
        return back()->with('error', 'Email atau password salah!');
    }

    // Logout
    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
