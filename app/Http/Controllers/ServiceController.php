<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kendaraan;
use App\Models\Karyawan;
use App\Models\Customer;
use App\Models\Service;
use App\Http\Resources\ServiceResource;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\ServiceValueResolver;

class ServiceController extends Controller
{
    /**
     * Menampilkan daftar service.
     */
    public function index()
    {
        $service = Service::with('customer', 'kendaraan', 'karyawan')->get();
        $customer = Customer::all();
        $kendaraan = Kendaraan::all();
        $karyawan = Karyawan::all();

        return view('service', [
            'service' => $service,
            'kendaraan' => $kendaraan,
            'customer' => $customer,
            'karyawan' => $karyawan,
        ]);
    }

    /**
     * Menyimpan data service baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_service' => 'required|string|max:10|unique:service,id_service',
            'no_polisi' => 'required|string|max:10|exists:kendaraan,no_polisi',
            'id_customer' => 'required|string|max:10|exists:customer,id_customer',
            'tanggal' => 'required|date',
            'jenis_service' => 'required|string|max:30',
            'status' => 'required|string|max:20',
            'catatan' => 'required|string|max:100',
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
        ]);

        // Simpan data service baru ke database
        Service::create([
            'id_service' => $request->id_service,
            'no_polisi' => $request->no_polisi,
            'id_customer' => $request->id_customer,
            'tanggal' => $request->tanggal,
            'jenis_service' => $request->jenis_service,
            'status' => $request->status,
            'catatan' => $request->catatan,
            'id_karyawan' => $request->id_karyawan,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('service.index')->with('success', 'Service berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk memperbarui data service berdasarkan ID.
     */
    public function edit($id_service)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login')->with('msg', 'Anda harus login untuk mengubah data.');
        }

        // Mencari service berdasarkan ID
        $service = Service::findOrFail($id_service);

        // Ambil semua data untuk ditampilkan di dropdown
        $kendaraan = Kendaraan::all();
        $customer = Customer::all();
        $karyawan = Karyawan::all();

        // Menampilkan form edit dengan data service dan dropdown
        return view('service.edit', compact('service', 'kendaraan', 'customer', 'karyawan'));
    }

    /**
     * Memperbarui data service berdasarkan ID.
     */
    public function update(Request $request, $id_service) 
    {
        // Validasi input
        $request->validate([
            'no_polisi' => 'required|string|max:10|exists:kendaraan,no_polisi',
            'id_customer' => 'required|string|max:10|exists:customer,id_customer',
            'tanggal' => 'required|date',
            'jenis_service' => 'required|string|max:30',
            'status' => 'required|string|max:20',
            'catatan' => 'required|string|max:100',
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
        ]);

        // Temukan data service berdasarkan ID
        $service = Service::findOrFail($id_service);

        // Perbarui data service
        $service->update([
            'no_polisi' => $request->no_polisi,
            'id_customer' => $request->id_customer,
            'tanggal' => $request->tanggal,
            'jenis_service' => $request->jenis_service,
            'status' => $request->status,
            'catatan' => $request->catatan,
            'id_karyawan' => $request->id_karyawan,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('service.index')->with('success', 'Service berhasil diperbarui!');
    }

    /**
     * Menghapus data service berdasarkan ID.
     */
    public function destroy($id_service)
    {
        $service = Service::findOrFail($id_service);
        $service->delete();

        return redirect()->route('service.index')->with('success', 'Service berhasil dihapus.');
    }


}