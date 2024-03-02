<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Fungsi untuk menampilkan halaman login
    public function showLoginForm()
    {
        return view('pages.login');
    }

    // Fungsi untuk melakukan proses login
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Login berhasil
            return redirect()->intended('/');
        } else {
            // Login gagal
            return redirect()->route('login')->with('error', 'Email atau password salah');
        }
    }

    // Fungsi untuk menampilkan halaman register
    public function showRegistrationForm()
    {
        return view('pages.register');
    }

    // Fungsi untuk melakukan proses registrasi
    public function register(Request $request)
    {
        $user = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Membuat user baru
        User::create($user);

        // Redirect setelah registrasi berhasil
        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    // Fungsi untuk melakukan proses logout
    public function logout()
    {
        Auth::logout();

        return redirect()->route('auth.login');
    }
}
