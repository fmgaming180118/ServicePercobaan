<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kendaraan;
use App\Models\Asuransi;
use App\Models\Service;

class KendaraanController extends Controller
{
    /**
     * Menampilkan daftar kendaraan.
     */
    public function index()
    {
        $kendaraan = Kendaraan::with('asuransi')->get();
        $asuransi = Asuransi::all();

        return view('kendaraan', [
            'kendaraan' => $kendaraan,
            'asuransi' => $asuransi,
        ]);
    }

    /**
     * Menyimpan data kendaraan baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'no_polisi' => 'required|string|max:10|unique:kendaraan,no_polisi',
            'nama_kendaraan' => 'required|string|max:20',
            'warna' => 'required|string|max:15',
            'id_asuransi' => 'required|exists:asuransi,id_asuransi',  // Validasi ID asuransi harus ada di tabel asuransi
        ]);

        // Simpan data kendaraan baru ke database
        Kendaraan::create([
            'no_polisi' => $request->no_polisi,
            'nama_kendaraan' => $request->nama_kendaraan,
            'warna' => $request->warna,
            'id_asuransi' => $request->id_asuransi,  // Menggunakan ID Asuransi yang dipilih
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    /**
     * Memperbarui data kendaraan berdasarkan no_polisi.
     */
    public function update(Request $request, $no_polisi) 
    {
        // Validasi input
        $request->validate([
            'nama_kendaraan' => 'required|string|max:20',
            'warna' => 'required|string|max:15',
            'id_asuransi' => 'required|exists:asuransi,id_asuransi',  // Validasi ID asuransi harus ada di tabel asuransi
        ]);

        // Temukan data kendaraan berdasarkan no_polisi
        $kendaraan = Kendaraan::findOrFail($no_polisi);

        // Perbarui data kendaraan
        $kendaraan->update([
            'nama_kendaraan' => $request->nama_kendaraan,
            'warna' => $request->warna,
            'id_asuransi' => $request->id_asuransi,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui!');
    }

    /**
     * Menghapus data kendaraan berdasarkan no_polisi.
     */
    public function destroy($no_polisi)
    {
        $kendaraan = Kendaraan::findOrFail($no_polisi);
        $kendaraan->delete();

        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil dihapus!');
    }

    public function index_android(Request $request)
    {
        // Mendapatkan data kendaraan berdasarkan customer yang sedang login
        $customer = $request->user()->customer;

        // Mengambil kendaraan yang terkait dengan customer
        $kendaraan = Service::where('id_customer', $customer->id_customer)
                            ->with('kendaraan') // Mengambil data kendaraan dari relasi service
                            ->get()
                            ->pluck('kendaraan'); // Hanya mengambil data kendaraan

        return response()->json($kendaraan);
    }
}