@extends('layouts.app') 

@section('title', 'Dashboard Ringkasan')

@section('content')

    <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Ringkasan Sistem ITSM JTEKT</h1>

    <h2 class="text-xl font-semibold text-gray-700 mb-4">Status Tiket & Pengguna</h2>
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Total Tiket</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalTickets }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Open / Baru</p>
            <p class="text-3xl font-bold text-green-600">{{ $openTickets }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Sedang Diproses</p>
            <p class="text-3xl font-bold text-yellow-600">{{ $progressTickets }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-gray-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Selesai/Closed</p>
            <p class="text-3xl font-bold text-gray-600">{{ $closedTickets }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Total Akun</p>
            <p class="text-3xl font-bold text-purple-600">{{ $totalUsers }}</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-lg">
            <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Trend Tiket (7 Hari Terakhir)</h3>
            <canvas id="lineChart" height="120"></canvas>
        </div>

        <div class="md:col-span-1 bg-white p-6 rounded-lg shadow-lg">
            <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Distribusi Status Tiket</h3>
            <canvas id="donutChart"></canvas>
        </div>

    </div>
    
    <h2 class="text-xl font-semibold text-gray-700 mb-4 mt-8">Metrik Waktu</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Tiket Hari Ini</p>
            <p class="text-3xl font-bold text-red-600">{{ $dailyTickets }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-indigo-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Tiket 7 Hari Terakhir</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $weeklyTickets }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-teal-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Tiket Bulan Ini</p>
            <p class="text-3xl font-bold text-teal-600">{{ $monthlyTickets }}</p>
        </div>
        
    </div>

    <div class="bg-white rounded-lg shadow p-8 text-center mt-4">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Tindakan Cepat</h2>
        <div class="flex justify-center gap-4">
             @if(Auth::user()->role == 'admin' || Auth::user()->role == 'it_head')
                <a href="{{ route('users.index') }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                    Kelola Akun Karyawan
                </a>
            @endif
            <a href="{{ route('tickets.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Lihat Semua Tiket
            </a>
        </div>
    </div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
       
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        const donutData = @json($donutData);
        
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: donutData.labels,
                datasets: [{
                    data: donutData.data,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)', // Open (Hijau Muda)
                        'rgba(255, 206, 86, 0.8)', // In Progress (Kuning)
                        'rgba(54, 162, 235, 0.8)', // Resolved (Biru)
                        'rgba(153, 102, 255, 0.8)', // Closed (Ungu)
                        'rgba(201, 203, 207, 0.8)' // Default
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: false,
                    }
                }
            }
        });

        // --- 2. LINE CHART (Trend Mingguan) ---
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        const lineChartData = @json($lineChartData);

        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: lineChartData.labels,
                datasets: [{
                    label: 'Tiket Baru Dibuat',
                    data: lineChartData.data,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4 
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) { if (value % 1 === 0) { return value; } } // Hanya angka bulat
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>