@extends('layouts.app') 

@section('title', 'Dashboard')

@section('content')

    <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">IT Service Management</h1>

    <h2 class="text-xl font-semibold text-gray-700 mb-4"></h2>
    <div class="grid grid-cols-1 md:grid-cols-6 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-800 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Total Ticket</p>
            <p class="text-3xl font-bold text-blue-800">{{ $totalTickets }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Open</p>
            <p class="text-3xl font-bold text-green-600">{{ $openTickets }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">In Progress</p>
            <p class="text-3xl font-bold text-yellow-600">{{ $progressTickets }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-300 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Resolved</p>
            <p class="text-3xl font-bold text-blue-300">{{ $resolved }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-gray-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Closed</p>
            <p class="text-3xl font-bold text-gray-600">{{ $closedTickets }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Account</p>
            <p class="text-3xl font-bold text-purple-600">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Rejected</p>
            <p class="text-3xl font-bold text-red-600">{{ $rejected }}</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
       
        
        <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-lg">
            <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Ticket Trends (Last 7 Days)</h3>
            <canvas id="lineChart" height="120"></canvas>
        </div>

        <div class="md:col-span-1 bg-white p-6 rounded-lg shadow-lg">
            <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Ticket Status</h3>
            <canvas id="donutChart"></canvas>
        </div>

    </div>
    
    <h2 class="text-xl font-semibold text-gray-700 mb-4 mt-8"></h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
        
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Daily Tickets</p>
            <p class="text-3xl font-bold text-red-600">{{ $dailyTickets }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-indigo-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Weekly Tickets</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $weeklyTickets }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-teal-500 hover:shadow-xl transition duration-300">
            <p class="text-gray-500 text-sm uppercase">Monthly Tickets</p>
            <p class="text-3xl font-bold text-teal-600">{{ $monthlyTickets }}</p>
        </div>
        
    </div>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Daily Trend (Last 7 Days)</h3>
            <canvas id="dailyChart" height="120"></canvas>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Weekly Trend (Last 4 Weeks)</h3>
            <canvas id="weeklyChart" height="120"></canvas>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Monthly Trend (Last 6 Months)</h3>
            <canvas id="monthlyChart" height="120"></canvas>
        </div>

    </div>

    <div class="bg-white rounded-lg shadow p-8 text-center mt-4">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Quick Action</h2>
        <div class="flex justify-center gap-4">
             @if(Auth::user()->role == 'admin' || Auth::user()->role == 'it_head')
                <a href="{{ route('users.index') }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                     Manage Users
                </a>
            @endif
            <a href="{{ route('tickets.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
               See More Tickets
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
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(255, 206, 86, 0.8)', 
                        'rgba(54, 162, 235, 0.8)', 
                        'rgba(153, 102, 255, 0.8)', 
                        'rgba(201, 203, 207, 0.8)' 
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
                            callback: function(value) { if (value % 1 === 0) { return value; } }
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

        
        const dailyCtx = document.getElementById('dailyChart').getContext('2d');
        @php
            
            $dailyChartData = $dailyChartData ?? ['labels' => [], 'data' => []];
        @endphp
        const dailyChartData = @json($dailyChartData);

        if (dailyChartData.labels && dailyChartData.labels.length > 0) {
            new Chart(dailyCtx, {
                type: 'line',
                data: {
                    labels: dailyChartData.labels,
                    datasets: [{
                        label: 'Daily Tickets',
                        data: dailyChartData.data,
                        borderColor: 'rgba(239, 68, 68, 1)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: 'rgba(239, 68, 68, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Tickets'
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Days'
                            }
                        }
                    }
                }
            });
        } else {
            
            dailyCtx.fillStyle = '#9CA3AF';
            dailyCtx.font = '16px Arial';
            dailyCtx.textAlign = 'center';
            dailyCtx.fillText('No data available', dailyCtx.canvas.width / 2, dailyCtx.canvas.height / 2);
        }

        
        const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
        @php

            $weeklyChartData = $weeklyChartData ?? ['labels' => [], 'data' => []];
        @endphp
        const weeklyChartData = @json($weeklyChartData);

        if (weeklyChartData.labels && weeklyChartData.labels.length > 0) {
            new Chart(weeklyCtx, {
                type: 'line',
                data: {
                    labels: weeklyChartData.labels,
                    datasets: [{
                        label: 'Weekly Tickets',
                        data: weeklyChartData.data,
                        borderColor: 'rgba(99, 102, 241, 1)',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Tickets'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Weeks'
                            }
                        }
                    }
                }
            });
        } else {
            weeklyCtx.fillStyle = '#9CA3AF';
            weeklyCtx.font = '16px Arial';
            weeklyCtx.textAlign = 'center';
            weeklyCtx.fillText('No data available', weeklyCtx.canvas.width / 2, weeklyCtx.canvas.height / 2);
        }

        
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        @php
            
            $monthlyChartData = $monthlyChartData ?? ['labels' => [], 'data' => []];
        @endphp
        const monthlyChartData = @json($monthlyChartData);

        if (monthlyChartData.labels && monthlyChartData.labels.length > 0) {
            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: monthlyChartData.labels,
                    datasets: [{
                        label: 'Monthly Tickets',
                        data: monthlyChartData.data,
                        borderColor: 'rgba(20, 184, 166, 1)',
                        backgroundColor: 'rgba(20, 184, 166, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: 'rgba(20, 184, 166, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Tickets'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Months'
                            }
                        }
                    }
                }
            });
        } else {
            monthlyCtx.fillStyle = '#9CA3AF';
            monthlyCtx.font = '16px Arial';
            monthlyCtx.textAlign = 'center';
            monthlyCtx.fillText('No data available', monthlyCtx.canvas.width / 2, monthlyCtx.canvas.height / 2);
        }
    });
</script>