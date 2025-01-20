<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pekerjaan;

class PekerjaanController extends Controller
{
    /**
     * Menampilkan daftar pekerjaan.
     */
    public function index()
    {
        // Ambil semua data pekerjaan dari database
        $pekerjaan = Pekerjaan::all();

        // Kirim data ke view 'pekerjaan'
        return view('pekerjaan', [
            'pekerjaan' => $pekerjaan,
        ]);
    }

    /**
     * Menyimpan data pekerjaan baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_pekerjaan' => 'required|string|max:10|unique:pekerjaan,id_pekerjaan',
            'nama_pekerjaan' => 'required|string|max:25',
        ]);

        // Simpan data pekerjaan baru ke database
        Pekerjaan::create([
            'id_pekerjaan' => $request->id_pekerjaan,
            'nama_pekerjaan' => $request->nama_pekerjaan,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil ditambahkan!');
    }

    /**
     * Memperbarui data pekerjaan berdasarkan ID.
     */
    public function update(Request $request, $id_pekerjaan) 
    {
        // Validasi input
        $request->validate([
            'nama_pekerjaan' => 'required|string|max:25',
        ]);

        // Temukan data pekerjaan berdasarkan ID
        $pekerjaan = Pekerjaan::findOrFail($id_pekerjaan);

        // Perbarui data pekerjaan
        $pekerjaan->update([
            'nama_pekerjaan' => $request->nama_pekerjaan,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil diperbarui!');
    }

    /**
     * Menghapus data pekerjaan berdasarkan ID.
     */
    public function destroy($id_pekerjaan)
    {
        $pekerjaan = Pekerjaan::findOrFail($id_pekerjaan);
        $pekerjaan->delete();

        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil dihapus!');
    }
}