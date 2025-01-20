@extends('layouts.master')

@section('content')
<div class="container-fluid main-container py-4">
    <div class="row">
        <!-- Data Karyawan -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Daftar Karyawan</h5>

                    <!-- Button Tambah Karyawan at the top left -->
                    <div class="mb-3 text-start">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKaryawan">Tambah Karyawan</button>
                    </div>

                    <!-- Tabel Karyawan -->
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID Karyawan</th>
                                <th>Nama Karyawan</th>
                                <th>Jabatan</th>
                                <th>User Name</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($karyawan as $key => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->id_karyawan }}</td>
                                <td>{{ $data->nama_karyawan }}</td>
                                <td>{{ $data->jabatan }}</td>
                                <td>{{ $data->user->name ?? 'Tidak ada' }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditKaryawan{{ $data->id_karyawan }}">Edit</button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('karyawan.destroy', $data->id_karyawan) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')">Hapus</button>
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

    <!-- Modal Edit Karyawan -->
    @foreach($karyawan as $data)
    <div class="modal fade" id="modalEditKaryawan{{ $data->id_karyawan }}" tabindex="-1" aria-labelledby="modalEditKaryawanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditKaryawanLabel">Edit Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('karyawan.update', $data->id_karyawan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                            <input type="text" name="nama_karyawan" class="form-control" value="{{ $data->nama_karyawan }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" value="{{ $data->jabatan }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="id" class="form-label">User </label>
                            <select name="id" class="form-control" required>
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

    <!-- Modal Tambah Karyawan -->
    <div class="modal fade" id="modalTambahKaryawan" tabindex="-1" aria-labelledby="modalTambahKaryawanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKaryawanLabel">Tambah Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('karyawan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_karyawan" class="form-label">ID Karyawan</label>
                            <input type="text" name="id_karyawan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                            <input type="text" name="nama_karyawan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="id" class="form-label">User </label>
                            <select name="id" class="form-control" required>
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