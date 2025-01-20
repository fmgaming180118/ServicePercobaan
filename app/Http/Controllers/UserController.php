<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Service;

class UserController extends Controller
{
    /**
     * Tampilkan halaman dashboard.
     */
    public function index()
    {
        // Ambil data dari database
        $users = User::all();
        $service = Service::with('kendaraan')->get();

        // Kirim data ke view
        return view('user', [
            'users' => $users,
            'service' => $service,
        ]);
    }

    /**
     * Tambahkan user baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|string',
            'password' => 'required|min:6',
        ]);

        // Simpan data user baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function update(Request $request, $id) 
    {
        // Validasi input dengan pengecualian email pada pengguna yang sama
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Pengecualian untuk email yang sama
            'role' => 'required|string',
            'password' => 'nullable|min:6',  // Password bisa kosong, hanya diupdate jika ada
        ]);

        // Temukan data user berdasarkan id
        $user = User::findOrFail($id);

        // Perbarui data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? bcrypt($request->password) : $user->password,  // Update password hanya jika diisi
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kendaraan = User::findOrFail($id);
        $kendaraan->delete();

        return redirect()->route('users.index')->with('success', 'Kendaraan berhasil dihapus!');
    } 
}
