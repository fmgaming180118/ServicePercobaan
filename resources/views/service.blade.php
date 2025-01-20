@extends('layouts.master')

@section('content')
<div class="container-fluid main-container py-4">
    <div class="row">
        <!-- Data Service -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Daftar Service</h5>

                    <!-- Button Tambah Service at the top left -->
                    <div class="mb-3 text-start">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahService">Tambah Service</button>
                    </div>

                    <!-- Tabel Service -->
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>No Polisi</th>
                                <th>Nama Customer</th>
                                <th>Tanggal</th>
                                <th>Jenis Service</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Nama Karyawan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($service as $key => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->id_service }}</td>
                                <td>{{ $data->kendaraan->no_polisi ?? 'Tidak ada' }}</td>
                                <td>{{ $data->customer->nama_customer ?? 'Tidak ada' }}</td>
                                <td>{{ $data->tanggal }}</td>
                                <td>{{ $data->jenis_service }}</td>
                                <td>{{ $data->status }}</td>
                                <td>{{ $data->catatan }}</td>
                                <td>{{ $data->karyawan->nama_karyawan ?? 'Tidak ada' }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditService{{ $data->id_service }}">Edit</button>

                                    <!-- Detail Button -->
                                    <a href="{{ route('detailpekerjaan.index', $data->id_service) }}" class="btn btn-info btn-sm">Detail Pekerjaan</a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('service.destroy', $data->id_service) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus Service ini?')">Hapus</button>
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

    <!-- Modal Edit Service -->
    @foreach($service as $data)
    <div class="modal fade" id="modalEditService{{ $data->id_service }}" tabindex="-1" aria-labelledby="modalEditServiceLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditServiceLabel">Edit Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('service.update', $data->id_service) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_service" class="form-label">ID</label>
                            <input type="text" name="id_service" class="form-control" value="{{ $data->id_service }}" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="no_polisi" class="form-label">No Polisi</label>
                            <select name="no_polisi" class="form-control">
                                @foreach($kendaraan as $datakendaraan)
                                    <option value="{{ $datakendaraan->no_polisi }}" {{ $data->kendaraan->no_polisi == $datakendaraan->no_polisi ? 'selected' : '' }}>{{ $datakendaraan->no_polisi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_customer" class="form-label">ID Customer</label>
                            <select name="id_customer" class="form-control">
                                @foreach($customer as $datacustomer)
                                    <option value="{{ $datacustomer->id_customer }}" {{ $data->id_customer == $datacustomer->id_customer ? 'selected' : '' }}>{{ $datacustomer->nama_customer }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ $data->tanggal }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_service" class="form-label">Jenis Service</label>
                            <input type="text" name="jenis_service" class="form-control" value="{{ $data->jenis_service }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="dikerjakan" {{ $data->status == 'dikerjakan' ? 'selected' : '' }}>Dikerjakan</option>
                                <option value="selesai" {{ $data->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <input type="text" name="catatan" class="form-control" value="{{ $data->catatan }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_karyawan" class="form-label">Karyawan</label>
                            <select name="id_karyawan" class="form-control">
                                @foreach($karyawan as $datakaryawan)
                                    <option value="{{ $datakaryawan->id_karyawan }}" {{ $data->id_karyawan == $datakaryawan->id_karyawan ? 'selected' : '' }}>{{ $datakaryawan->nama_karyawan }}</option>
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

    <!-- Modal Tambah Service -->
    <div class="modal fade" id="modalTambahService" tabindex="-1" aria-labelledby="modalTambahServiceLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahServiceLabel">Tambah Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('service.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_service" class="form-label">ID</label>
                            <input type="text" name="id_service" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_polisi" class="form-label">No Polisi</label>
                            <select name="no_polisi" class="form-control" required>
                                <option value="" selected disabled>Pilih No Polisi</option>
                                @foreach($kendaraan as $datakendaraan)
                                    <option value="{{ $datakendaraan->no_polisi }}">{{ $datakendaraan->no_polisi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_customer" class="form-label">Customer</label>
                            <select name="id_customer" class="form-control" required>
                                <option value="" selected disabled>Pilih Customer</option>
                                @foreach($customer as $datacustomer)
                                    <option value="{{ $datacustomer->id_customer }}">{{ $datacustomer->nama_customer }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_service" class="form-label">Jenis Service</label>
                            <input type="text" name="jenis_service" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="dikerjakan">Sedang Dikerjakan</option>
                                <option value="selesai">Sudah Selesai</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <input type="text" name="catatan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_karyawan" class="form-label">Karyawan</label>
                            <select name="id_karyawan" class="form-control" required>
                                <option value="" selected disabled>Pilih Karyawan</option>
                                @foreach($karyawan as $datakaryawan)
                                    <option value="{{ $datakaryawan->id_karyawan }}">{{ $datakaryawan->nama_karyawan }}</option>
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