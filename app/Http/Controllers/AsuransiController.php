<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Asuransi;

class AsuransiController extends Controller
{
    /**
     * Menampilkan daftar asuransi.
     */
    public function index()
    {
        // Ambil semua data asuransi dari database
        $asuransi = Asuransi::all();

        // Kirim data ke view 'asuransi'
        return view('asuransi', [
            'asuransi' => $asuransi
        ]);
    }

    /**
     * Menyimpan data asuransi baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_asuransi' => 'required|string|max:10|unique:asuransi,id_asuransi',
            'nama_asuransi' => 'required|string|max:30',
            'kontak' => 'required|string|max:15',
            'alamat' => 'required|string|max:50',
            'email' => 'required|string|max:35',
        ]);

        // Simpan data asuransi baru ke database
        Asuransi::create([
            'id_asuransi' => $request->id_asuransi,
            'nama_asuransi' => $request->nama_asuransi,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
            'email' => $request->email,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('asuransi.index')->with('success', 'Asuransi berhasil ditambahkan!');
    }

    /**
     * Memperbarui data asuransi berdasarkan ID.
     */
    public function update(Request $request, $id_asuransi) 
    {
        // Validasi input
        $request->validate([
            'nama_asuransi' => 'required|string|max:30',
            'kontak' => 'required|string|max:15',
            'alamat' => 'required|string|max:50',
            'email' => 'required|string|max:35',
        ]);

        // Temukan data asuransi berdasarkan ID
        $asuransi = Asuransi::findOrFail($id_asuransi);

        // Perbarui data asuransi
        $asuransi->update([
            'nama_asuransi' => $request->nama_asuransi,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
            'email' => $request->email,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('asuransi.index')->with('success', 'Asuransi berhasil diperbarui!');
    }

    /**
     * Menghapus data asuransi berdasarkan ID.
     */
    public function destroy($id_asuransi)
    {
        // Temukan data asuransi berdasarkan ID dan hapus
        $asuransi = Asuransi::findOrFail($id_asuransi);
        $asuransi->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('asuransi.index')->with('success', 'Asuransi berhasil dihapus!');
    }
}