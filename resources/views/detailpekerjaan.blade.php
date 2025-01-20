@extends('layouts.master')

@section('content')
<div class="container-fluid main-container py-4">
    <div class="row">
        <!-- Card Kendaraan Customer -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Kendaraan Anda</h5>
                    @if($kendaraan->isEmpty())
                        <p>Tidak ada data kendaraan.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Kendaraan</th>
                                    <th>Warna</th>
                                    <th>Jenis Service</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kendaraan as $item)
                                    <tr>
                                        <td>{{ $item->nama_kendaraan }}</td>
                                        <td>{{ $item->warna }}</td>
                                        <td>
                                            @if($item->services->isNotEmpty())
                                                @foreach($item->services as $service)
                                                    {{ $service->jenis_service }}<br>
                                                @endforeach
                                            @else
                                                Belum ada service
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card Detail Pekerjaan -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Detail Pekerjaan</h5>
                    @if($pekerjaan->isEmpty())
                        <p>Tidak ada detail pekerjaan.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Pekerjaan</th>
                                    <th>Status Pekerjaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pekerjaan as $item)
                                    <tr>
                                        <td>{{ $item->nama_pekerjaan }}</td>
                                        <td>{{ $item->status_pekerjaan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card Catatan -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Catatan Service</h5>
                    @if($catatan->isEmpty())
                        <p>Tidak ada catatan service.</p>
                    @else
                        <ul class="list-group">
                            @foreach($catatan as $item)
                                <li class="list-group-item">{{ $item }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
