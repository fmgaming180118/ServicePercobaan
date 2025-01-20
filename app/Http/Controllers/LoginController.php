<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Customer;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ambil data email dan password
        $credentials = $request->only('email', 'password');

        // Cek apakah login berhasil
        if (Auth::attempt($credentials)) {
            // Ambil user yang sedang login
            $user = Auth::user();

            // Ambil data customer berdasarkan id user
            $customer = Customer::where('id', $user->id)->first();

            // Validasi jika customer tidak ditemukan
            if (!$customer && $user->role == 'customer') {
                Auth::logout(); // Logout otomatis jika tidak ada data customer
                return redirect()->route('login')->with('msg', 'Data customer tidak ditemukan.');
            }

            // Redirect berdasarkan role
            if ($user->role == 'admin') {
                return redirect()->route('dashboard');
            } elseif ($user->role == 'owner') {
                return redirect()->route('ownerdashboard');
            } elseif ($user->role == 'customer') {
                // Redirect ke dashboard customer dengan data customer
                return redirect()->route('customerdashboard')->with('customer', $customer);
            }

            // Jika role tidak dikenali
            return redirect()->route('login')->with('msg', 'Role tidak dikenali.');
        }

        // Jika login gagal
        return redirect()->back()->with('msg', 'Email atau password salah');
    }

    // Logout pengguna
    public function logout()
    {
        Auth::logout(); // Logout pengguna
        Session::flush(); // Hapus semua sesi
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }

    // Menampilkan halaman lupa password
    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Mengirim email reset password
    public function emailUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // Menampilkan halaman reset password baru
    public function newPassword(string $token)
    {
        return view('auth.recover-password', ['token' => $token]);
    }

    // Menyimpan password baru
    public function savePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:3|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
    
}
