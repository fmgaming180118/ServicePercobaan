@extends('layouts.master')

@section('content')

<div class="container mt-5">
    <div class="row">
        <!-- Card 1: Total Service -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Total Service Tahun {{ $currentYear }}</h5>
                </div>
                <div class="card-body">
                    <p>Total service yang terjadi pada tahun {{ $currentYear }} adalah: <strong>{{ $totalServices }}</strong></p>
                </div>
            </div>
        </div>

        <!-- Card 2: Service List -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>List Service Tahun {{ $currentYear }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Service</th>
                                <th>Nama Customer</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($serviceDetails as $service)
                                <tr>
                                    <td>{{ $service->id_service }}</td>
                                    <td>{{ $service->customer->nama_customer }}</td> <!-- Asumsikan relasi sudah ada -->
                                    <td>{{ \Carbon\Carbon::parse($service->created_at)->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Card 3: User List -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Total Users: {{ $totalUsers }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
