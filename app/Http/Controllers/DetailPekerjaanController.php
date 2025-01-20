<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailPekerjaan;
use App\Models\Service;
use App\Models\Pekerjaan;

class DetailPekerjaanController extends Controller
{
    /**
     * Menampilkan daftar detail pekerjaan berdasarkan id_service.
     */
    public function index($id_service)
    {
        $detailPekerjaan = DetailPekerjaan::where('id_service', $id_service)->with('pekerjaan')->get();
        $service = Service::findOrFail($id_service);
        $pekerjaan = Pekerjaan::all();

        return view('detailpekerjaan', [
            'detailPekerjaan' => $detailPekerjaan,
            'service' => $service,
            'pekerjaan' => $pekerjaan,
        ]);
    }

    /**
     * Menyimpan detail pekerjaan baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_service' => 'required|exists:service,id_service',
            'id_pekerjaan' => 'required|exists:pekerjaan,id_pekerjaan',
            'status_pekerjaan' => 'required|string|max:20',
        ]);

        // Simpan detail pekerjaan baru ke database
        DetailPekerjaan::create([
            'id_service' => $request->id_service,
            'id_pekerjaan' => $request->id_pekerjaan,
            'status_pekerjaan' => $request->status_pekerjaan,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('detailpekerjaan.index', $request->id_service)->with('success', 'Detail pekerjaan berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk memperbarui detail pekerjaan berdasarkan id_service dan id_pekerjaan.
     */
    public function edit($id_service, $id_pekerjaan)
    {
        // Temukan detail pekerjaan berdasarkan id_service dan id_pekerjaan
        $detailPekerjaan = DetailPekerjaan::where('id_service', $id_service)
            ->where('id_pekerjaan', $id_pekerjaan)
            ->firstOrFail();
        $pekerjaan = Pekerjaan::all();

        return view('detailpekerjaan.edit', compact('detailPekerjaan', 'pekerjaan'));
    }

    /**
     * Memperbarui detail pekerjaan berdasarkan id_service dan id_pekerjaan.
     */
    public function update(Request $request, $id_service, $id_pekerjaan)
    {
        // Validasi input
        $request->validate([
            'id_pekerjaan' => 'required|exists:pekerjaan,id_pekerjaan',
            'status_pekerjaan' => 'required|string|max:20',
        ]);

        // Temukan detail pekerjaan berdasarkan id_service dan id_pekerjaan
        $detailPekerjaan = DetailPekerjaan::where('id_service', $id_service)
            ->where('id_pekerjaan', $id_pekerjaan)
            ->firstOrFail();

        // Perbarui detail pekerjaan
        $detailPekerjaan->update([
            'id_pekerjaan' => $request->id_pekerjaan,
            'status_pekerjaan' => $request->status_pekerjaan,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('detailpekerjaan.index', $id_service)->with('success', 'Detail pekerjaan berhasil diperbarui!');
    }

    /**
     * Menghapus detail pekerjaan berdasarkan id_service dan id_pekerjaan.
     */
    public function destroy($id_service, $id_pekerjaan)
    {
        // Temukan detail pekerjaan berdasarkan id_service dan id_pekerjaan
        $detailPekerjaan = DetailPekerjaan::where('id_service', $id_service)
            ->where('id_pekerjaan', $id_pekerjaan)
            ->firstOrFail();

        // Hapus detail pekerjaan
        $detailPekerjaan->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('detailpekerjaan.index', $id_service)->with('success', 'Detail pekerjaan berhasil dihapus!');
    }

    public function index_android(Request $request)
    {
        // Mendapatkan data pekerjaan yang terkait dengan customer yang sedang login
        $customer = $request->user()->customer;

        $pekerjaan = DetailPekerjaan::whereHas('service', function ($query) use ($customer) {
            $query->where('id_customer', $customer->id_customer);
        })->get();

        return response()->json($pekerjaan);
    }

}