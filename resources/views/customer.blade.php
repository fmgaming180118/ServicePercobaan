@extends('layouts.master')

@section('content')
<div class="container-fluid main-container py-4">
    <div class="row">
        <!-- Data Customer -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Daftar Customer</h5>

                    <!-- Button Tambah Customer at the top left -->
                    <div class="mb-3 text-start">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahCustomer">Tambah Customer</button>
                    </div>

                    <!-- Tabel Customer -->
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Nama Customer</th>
                                <th>No Telepon</th>
                                <th>Alamat</th>
                                <th>Username</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customer as $key => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->id_customer }}</td>
                                <td>{{ $data->nama_customer }}</td>
                                <td>{{ $data->no_telp }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td>{{ $data->user->name ?? 'Tidak ada' }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditCustomer{{ $data->id_customer }}">Edit</button>

                                    <!-- Delete Button -->
 <form action="{{ route('customer.destroy', $data->id_customer) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus Customer ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Customer -->
    @foreach($customer as $data)
    <div class="modal fade" id="modalEditCustomer{{ $data->id_customer }}" tabindex="-1" aria-labelledby="modalEditCustomerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditCustomerLabel">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('customer.update', $data->id_customer) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_customer" class="form-label">Nama Customer</label>
                            <input type="text" name="nama_customer" class="form-control" value="{{ $data->nama_customer }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">No Telepon</label>
                            <input type="text" name="no_telp" class="form-control" value="{{ $data->no_telp }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="{{ $data->alamat }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User </label>
                            <select name="user_id" class="form-control" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $data->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal Tambah Customer -->
    <div class="modal fade" id="modalTambahCustomer" tabindex="-1" aria-labelledby="modalTambahCustomerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahCustomerLabel">Tambah Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('customer.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_customer" class="form-label">Nama Customer</label>
                            <input type="text" name="nama_customer" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">No Telepon</label>
                            <input type="text" name="no_telp" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User </label>
                            <select name="user_id" class="form-control" required>
                                <option value="" selected disabled>Pilih User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection