<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\Customer;  // Pastikan model Customer sudah diimport
use Carbon\Carbon;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        // Ambil tahun saat ini
        $currentYear = Carbon::now()->year;

        // Ambil data service per bulan berdasarkan tahun saat ini
        $servicesPerMonth = Service::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)  // Filter berdasarkan tahun
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Ambil jumlah total service di tahun tersebut
        $totalServices = Service::whereYear('created_at', $currentYear)->count();

        // Ambil daftar service dengan ID, nama customer, dan tanggal
        $serviceDetails = Service::with('customer')  // Pastikan relasi sudah ada di model Service
            ->whereYear('created_at', $currentYear)
            ->get(['id_service', 'created_at', 'id_customer']); // Ambil ID, tanggal, dan customer_id

        // Ambil data total user
        $totalUsers = User::count();

        // Ambil daftar pengguna dengan nama dan email
        $users = User::select('name', 'email')->get();

        // Buat array bulan dari 1 hingga 12 untuk menampilkan data secara berurutan
        $months = range(1, 12);

        // Inisialisasi array untuk menyimpan jumlah service per bulan
        $serviceData = [];

        // Gabungkan data jumlah service ke dalam array berdasarkan bulan
        foreach ($months as $month) {
            // Ambil jumlah service untuk bulan yang sesuai, jika tidak ada, set ke 0
            $serviceData[$month] = $servicesPerMonth->firstWhere('month', $month)->count ?? 0;
        }

        // Kembalikan view dengan data yang diperlukan
        return view('ownerdashboard', compact('serviceData', 'totalUsers', 'users', 'currentYear', 'totalServices', 'serviceDetails'));
    }
}
