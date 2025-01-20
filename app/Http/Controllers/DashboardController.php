<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan; // Pastikan model Vehicle ada
use App\Models\User; // Pastikan model User ada
use App\Models\Service; // Pastikan model Service ada
use App\Models\DetailPekerjaan; // Pastikan model DetailPekerjaan ada
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard.
     */
    public function index()
{
    // View Card 1: Kendaraan dengan status "sedang dikerjakan"
    $kendaraanSedangDikerjakan = Service::where('status', 'sedang dikerjakan')->with('kendaraan')->get();

    // View Card 2: Jumlah user dan list user
    $users = User::select('name', 'email')->get();
    $jumlahUsers = $users->count();

    // View Card 3: Chart penjualan per bulan (jumlah service berdasarkan bulan)
    $servicePerBulan = Service::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();
    
        $servicePerBulan = $servicePerBulan->map(function ($item) {
            // Pastikan bulan dalam rentang 1-12
            if ($item->month >= 1 && $item->month <= 12) {
                $item->month = Carbon::createFromFormat('m', $item->month)->format('F'); // Mengubah angka bulan menjadi nama bulan
            } else {
                $item->month = 'Invalid Month'; // Jika bulan tidak valid, beri label default
            }
            return $item;
        });

    // View Card 4: Progress pengerjaan (Detail pekerjaan)
    $progresPekerjaan = DetailPekerjaan::select('id_service', 'status_pekerjaan')
        ->with(['service.kendaraan'])
        ->get()
        ->groupBy('id_service')
        ->map(function ($pekerjaan) {
            $total = $pekerjaan->count();
            $selesai = $pekerjaan->where('status_pekerjaan', 'selesai')->count();
            $progress = ($total > 0) ? ($selesai / $total) * 100 : 0;

            return [
                'no_polisi' => $pekerjaan->first()->service->kendaraan->no_polisi ?? '-',
                'nama_kendaraan' => $pekerjaan->first()->service->kendaraan->nama_kendaraan ?? '-',
                'progress' => round($progress, 2)
            ];
        });

        return view('dashboard', compact(
            'kendaraanSedangDikerjakan',
            'users',
            'jumlahUsers',
            'servicePerBulan', // Ganti dengan variabel yang benar
            'progresPekerjaan'
        ));
        
        
}
}