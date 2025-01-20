<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class KaryawanController extends Controller
{
    /**
     * Menampilkan daftar karyawan.
     */
    public function index()
    {
        // Ambil semua data karyawan dari database
        $karyawans = Karyawan::with('user')->get();
        $users = User::all();

        // Kirim data ke view 'karyawan'
        return view('karyawan', [   
            'karyawan' => $karyawans,
            'users' => $users
        ]);
    }

    /**
     * Menyimpan data karyawan baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_karyawan' => 'required|string|max:10|unique:karyawan,id_karyawan',
            'nama_karyawan' => 'required|string|max:60',
            'jabatan' => 'required|string|max:15',
            'id' => 'required|exists:users,id', // Mengganti 'id' dengan 'user_id' untuk lebih jelas
        ]);

        // Simpan data karyawan baru ke database
        Karyawan::create([
            'id_karyawan' => $request->id_karyawan,
            'nama_karyawan' => $request->nama_karyawan,
            'jabatan' => $request->jabatan,
            'id' => $request->id // Mengganti 'id' dengan 'user_id' untuk lebih jelas
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    /**
     * Memperbarui data karyawan berdasarkan ID.
     */
    public function update(Request $request, $id_karyawan) 
    {
        // Validasi input
        $request->validate([
            'nama_karyawan' => 'required|string|max:60',
            'jabatan' => 'required|string|max:15',
            'id' => 'required|exists:users,id', // Mengganti 'id' dengan 'user_id' untuk lebih jelas
        ]);

        // Temukan data karyawan berdasarkan ID
        $karyawan = Karyawan::findOrFail($id_karyawan);

        // Perbarui data karyawan
        $karyawan->update([
            'nama_karyawan' => $request->nama_karyawan,
            'jabatan' => $request->jabatan,
            'id' => $request->id // Mengganti 'id' dengan 'user_id' untuk lebih jelas
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui!');
    }

    /**
     * Menghapus data karyawan berdasarkan ID.
     */
    public function destroy($id_karyawan)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus!');
    }
}