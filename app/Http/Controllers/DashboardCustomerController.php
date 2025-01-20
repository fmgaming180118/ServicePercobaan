<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kendaraan;
use App\Models\DetailPekerjaan;
use App\Models\Service;
use App\Models\Customer;

class DashboardCustomerController extends Controller
{
    public function showCustomerDashboard()
{
    // Ambil data user yang sedang login
    $user = auth()->user();

    // Validasi jika user tidak login
    if (!$user) {
        return response()->json(['error' => 'Anda harus login terlebih dahulu.'], 401);
    }

    // Ambil data customer terkait dengan user yang login
    $customer = Customer::where('id', $user->id)->first();

    // Validasi jika customer tidak ditemukan
    if (!$customer) {
        return response()->json(['error' => 'Data customer tidak ditemukan.'], 404);
    }

    // Ambil id_customer dari objek customer
    $id_customer = $customer->id_customer;

    // Ambil data kendaraan terkait customer
    $kendaraan = Kendaraan::with('service')
        ->whereIn('no_polisi', Service::where('id_customer', $id_customer)->pluck('no_polisi'))
        ->get();

    // Ambil detail pekerjaan terkait service customer
    $pekerjaan = DetailPekerjaan::join('service', 'detail_pekerjaan.id_service', '=', 'service.id_service')
        ->join('pekerjaan', 'pekerjaan.id_pekerjaan', '=', 'detail_pekerjaan.id_pekerjaan')
        ->where('service.id_customer', $id_customer)
        ->select('pekerjaan.nama_pekerjaan', 'detail_pekerjaan.status_pekerjaan')
        ->get();

    // Ambil catatan terkait service customer
    $catatan = Service::where('id_customer', $id_customer)->pluck('catatan');

    // Return the data as JSON
    return response()->json([
        'kendaraan' => $kendaraan,
        'pekerjaan' => $pekerjaan,
        'catatan' => $catatan,
    ]);
}

}
