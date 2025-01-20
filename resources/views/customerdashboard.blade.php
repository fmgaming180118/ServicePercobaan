@extends('layouts.master')

@section('content')
<div class="container-fluid main-container py-4">
    <div class="row">
        <!-- Card Kendaraan Customer -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Kendaraan Anda</h5>
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
                                    @if($item->service->isNotEmpty())
                                        @foreach($item->service as $service)
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
                </div>
            </div>
        </div>

        <!-- Card Detail Pekerjaan -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2>Detail Pekerjaan</h2>
<ul>
    @foreach ($pekerjaan as $item)
        <li>{{ $item->nama_pekerjaan }} - Status: {{ $item->status_pekerjaan }}</li>
    @endforeach
</ul>
                </div>
            </div>
        </div>

        <!-- Card Catatan -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Catatan Service</h5>
                    <ul class="list-group">
                        @foreach($catatan as $item)
                            <li class="list-group-item">{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
