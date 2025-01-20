@extends('layouts.master')

@section('content')
<div class="container-fluid main-container py-4">
    <div class="row">
        <!-- Data Asuransi -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Daftar Asuransi</h5>
                    <!-- Button Tambah Asuransi at the top left -->
                    <div class="mb-3 text-start">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAsuransiModal">Tambah Asuransi</button>
                    </div>

                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID Asuransi</th>
                                <th>Nama Asuransi</th>
                                <th>Kontak</th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asuransi as $key => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->id_asuransi }}</td>
                                <td>{{ $data->nama_asuransi }}</td>
                                <td>{{ $data->kontak }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td>{{ $data->email }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditAsuransi-{{ $data->id_asuransi }}">Edit</button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('asuransi.destroy', $data->id_asuransi) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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

    <!-- Modal Edit Asuransi -->
    @foreach($asuransi as $key => $data)
    <div class="modal fade" id="modalEditAsuransi-{{ $data->id_asuransi }}" tabindex="-1" aria-labelledby="modalEditAsuransiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditAsuransiLabel">Edit Asuransi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('asuransi.update', $data->id_asuransi) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_asuransi" class="form-label">ID Asuransi</label>
                            <input type="text" name="id_asuransi" class="form-control" value="{{ $data->id_asuransi }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nama_asuransi" class="form-label">Nama Asuransi</label>
                            <input type="text" name="nama_asuransi" class="form-control" value="{{ $data->nama_asuransi }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="kontak" class="form-label">Kontak</label>
                            <input type="text" name="kontak" class="form-control" value="{{ $data->kontak }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="{{ $data->alamat }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
 <input type="email" name="email" class="form-control" value="{{ $data->email }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal Tambah Asuransi -->
    <div class="modal fade" id="addAsuransiModal" tabindex="-1" aria-labelledby="addAsuransiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAsuransiModalLabel">Tambah Asuransi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('asuransi.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_asuransi" class="form-label">ID</label>
                            <input type="text" name="id_asuransi" class="form-control" placeholder="ID Asuransi" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_asuransi" class="form-label">Nama Asuransi</label>
                            <input type="text" name="nama_asuransi" class="form-control" placeholder="Nama Asuransi" required>
                        </div>
                        <div class="mb-3">
                            <label for="kontak" class="form-label">Kontak</label>
                            <input type="text" name="kontak" class="form-control" placeholder="Kontak" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" placeholder="Alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Asuransi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection