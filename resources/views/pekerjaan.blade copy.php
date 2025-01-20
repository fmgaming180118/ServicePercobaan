@extends('layouts.master')

@section('content')
<div class="container-fluid main-container py-4">
    <div class="row">
        <!-- Data Pekerjaan -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Daftar Pekerjaan</h5>
                    <!-- Button Tambah Pekerjaan at the top left -->
                    <div class="mb-3 text-start">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPekerjaanModal">Tambah Pekerjaan</button>
                    </div>

                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID Pekerjaan</th>
                                <th>Nama Pekerjaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pekerjaan as $key => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->id_pekerjaan }}</td>
                                <td>{{ $data->nama_pekerjaan }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditPekerjaan-{{ $data->id_pekerjaan }}">Edit</button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('pekerjaan.destroy', $data->id_pekerjaan) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pekerjaan ini?')">Hapus</button>
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

    <!-- Modal Edit Pekerjaan -->
    @foreach($pekerjaan as $data)
    <div class="modal fade" id="modalEditPekerjaan-{{ $data->id_pekerjaan }}" tabindex="-1" aria-labelledby="modalEditPekerjaanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditPekerjaanLabel">Edit Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('pekerjaan.update', $data->id_pekerjaan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                            <input type="text" name="nama_pekerjaan" class="form-control" value="{{ $data->nama_pekerjaan }}" required>
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

    <!-- Modal Tambah Pekerjaan -->
    <div class="modal fade" id="addPekerjaanModal" tabindex="-1" aria-labelledby="addPekerjaanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPekerjaanModalLabel">Tambah Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('pekerjaan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_pekerjaan" class="form-label">ID Pekerjaan</label>
                            <input type="text" name="id_pekerjaan " class="form-control" placeholder="ID Pekerjaan" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                            <input type="text" name="nama_pekerjaan" class="form-control" placeholder="Nama Pekerjaan" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Pekerjaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection