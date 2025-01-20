<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('auth.register'); // Return ke view form register
    }

    // Proses registrasi
    public function register(Request $request)
    {
        // Validasi input dari form register
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|max:10'
        ]);

        // Simpan data user ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password untuk keamanan
            'role' => $request->role,
        ]);

        // Login user setelah registrasi
        auth()->login($user);

        // Redirect ke dashboard atau halaman lain setelah registrasi
        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil!');
    }
}
