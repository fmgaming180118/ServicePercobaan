<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CustomerController extends Controller
{
    /**
     * Menampilkan daftar customer.
     */
    public function index()
    {
        // Ambil semua data customer dari database
        $customer = Customer::with('user')->get();
        $users = User::all();

        // Kirim data ke view 'customer'
        return view('customer', [   
            'customer' => $customer,
            'users' => $users
        ]);
    }

    /**
     * Menyimpan data customer baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_customer' => 'required|string|max:60',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string|max:100',
            'user_id' => 'required|exists:users,id',
        ]);

        // Simpan data customer baru ke database
        Customer::create([
            'nama_customer' => $request->nama_customer,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'user_id' => $request->user_id
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('customer.index')->with('success', 'Customer berhasil ditambahkan!');
    }

    /**
     * Memperbarui data customer berdasarkan ID.
     */
    public function update(Request $request, $id_customer) 
    {
        // Validasi input
        $request->validate([
            'nama_customer' => 'required|string|max:60',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string|max:100',
            'user_id' => 'required|exists:users,id',
        ]);

        // Temukan data customer berdasarkan ID
        $customer = Customer::findOrFail($id_customer);

        // Perbarui data customer
        $customer->update([
            'nama_customer' => $request->nama_customer,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'user_id' => $request->user_id,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('customer.index')->with('success', 'Customer berhasil diperbarui!');
    }

    /**
     * Menghapus data customer berdasarkan ID.
     */
    public function destroy($id_customer)
    {
        $customer = Customer::findOrFail($id_customer);
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Customer berhasil dihapus!');
    }
}