@extends('layouts.master')

@section('content')
<div class="container-fluid main-container py-4">
    <div class="row">
        <!-- Data Kendaraan -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Daftar Kendaraan</h5>
                    <!-- Button Tambah Kendaraan at the top left -->
                    <div class="mb-3 text-start">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKendaraanModal">Tambah Kendaraan</button>
                    </div>

                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>No Polisi</th>
                                <th>Nama Kendaraan</th>
                                <th>Warna</th>
                                <th>Asuransi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kendaraan as $item)
                            <tr>
                                <td>{{ $item->no_polisi }}</td>
                                <td>{{ $item->nama_kendaraan }}</td>
                                <td>{{ $item->warna }}</td>
                                <td>
                                    @if($item->asuransi)
                                        {{ $item->asuransi->nama_asuransi }}
                                    @else
                                        Asuransi tidak ditemukan
                                    @endif
                                </td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditKendaraan-{{ $item->no_polisi }}">Edit</button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('kendaraan.destroy', $item->no_polisi) }}" method="POST" style="display:inline;">
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

    <!-- Modal Edit Kendaraan -->
    @foreach($kendaraan as $data)
    <div class="modal fade" id="modalEditKendaraan-{{ $data->no_polisi }}" tabindex="-1" aria-labelledby="modalEditKendaraanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditKendaraanLabel">Edit Kendaraan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kendaraan.update', $data->no_polisi) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="no_polisi" class="form-label">No Polisi</label>
                            <input type="text" name="no_polisi" class="form-control" value="{{ $data->no_polisi }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nama_kendaraan" class="form-label">Nama Kendaraan</label>
                            <input type="text" name="nama_kendaraan" class="form-control" value="{{ $data->nama_kendaraan }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="warna" class="form-label">Warna</label>
                            <input type="text" name="warna" class="form-control" value="{{ $data->warna }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_asuransi" class="form-label">Asuransi</label>
                            <select name="id_asuransi" class="form-control" required>
                                @foreach($asuransi as $asuransiitem)
                                    <option value="{{ $asuransiitem->id_asuransi }}" {{ $data->id_asuransi == $asuransiitem->id_asuransi ? 'selected' : '' }}>{{ $asuransiitem->nama_asuransi }}</option>
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

    <!-- Modal Tambah Kendaraan -->
    <div class="modal fade" id="addKendaraanModal" tabindex="-1" aria-labelledby="addKendaraanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addKendaraanModalLabel">Tambah Kendaraan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kendaraan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="no_polisi" class="form-label">No Polisi</label>
                            <input type="text" class="form-control" id="no_polisi" name="no_polisi" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_kendaraan" class="form-label">Nama Kendaraan</label>
                            <input type="text" class="form-control" id="nama_kendaraan" name="nama_kendaraan" required>
                        </div>
                        <div class="mb-3">
                            <label for="warna" class="form-label">Warna</label>
                            <input type="text" class="form-control" id="warna" name="warna" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_asuransi" class="form-label">Asuransi</label>
                            <select name="id_asuransi" class="form-select" required>
                                <option value="">Pilih Asuransi</option>
                                @foreach($asuransi as $asuransi)
                                    <option value="{{ $asuransi->id_asuransi }}">{{ $asuransi->nama_asuransi }}</option>
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