@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <!-- View Card 1 -->
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header">Kendaraan Sedang Dikerjakan</div>
                <div class="card-body overflow-auto" style="max-height: 300px;">
                    <ul>
                        @forelse ($kendaraanSedangDikerjakan as $service)
                            <li>{{ $service->kendaraan->no_polisi ?? 'N/A' }} - {{ $service->kendaraan->nama_kendaraan ?? 'N/A' }}</li>
                        @empty
                            <li>Tidak ada kendaraan yang sedang dikerjakan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- View Card 2 -->
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header">Jumlah User</div>
                <div class="card-body overflow-auto" style="max-height: 300px;">
                    <p>Total Users: {{ $users->count() }}</p>
                    <ul>
                        @foreach ($users as $user)
                            <li>{{ $user->name }} ({{ $user->email }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- View Card 3 -->
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header">Total Service Per Bulan</div>
                <div class="card-body">
                    <canvas id="serviceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- View Card 4 -->
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header">Progress Pengerjaan</div>
                <div class="card-body overflow-auto" style="max-height: 300px;">
                    @foreach ($progresPekerjaan as $data)
                        <p>{{ $data['no_polisi'] }} - {{ $data['nama_kendaraan'] }}</p>
                        <div class="progress mb-2">
                            <div class="progress-bar" role="progressbar" style="width: {{ $data['progress'] }}%;" aria-valuenow="{{ $data['progress'] }}" aria-valuemin="0" aria-valuemax="100">{{ round($data['progress']) }}%</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('serviceChart').getContext('2d');
    var serviceChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($servicePerBulan->pluck('month')->map(function ($month) {
                // Validasi bulan sebelum memformat
                if ($month >= 1 && $month <= 12) {
                    return DateTime::createFromFormat('!m', $month)->format('F');
                } else {
                    return 'Invalid Month';
                }
            })) !!},
            datasets: [{
                label: 'Total Service',
                data: {!! json_encode($servicePerBulan->pluck('total')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Pastikan bilangan bulat
                    },
                    title: {
                        display: true,
                        text: 'Total Service'
                    }
                }
            }
        }
    });
</script>
@endsection
