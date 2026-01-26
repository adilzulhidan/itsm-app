@extends('layouts.app') 

@section('title', 'Dashboard')

@section('content')

    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 border-b pb-2 dark:border-gray-700">IT Service Management</h1>

    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4"></h2>
    <div class="grid grid-cols-1 md:grid-cols-6 gap-6 mb-8">
        
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-blue-800 dark:border-blue-600 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
            <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">Total Ticket</p>
            <p class="text-3xl font-bold text-blue-800 dark:text-blue-400">{{ $totalTickets }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-green-500 dark:border-green-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
            <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">Open</p>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $openTickets }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-yellow-500 dark:border-yellow-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
            <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">In Progress</p>
            <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $progressTickets }}</p>
        </div>
        
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-blue-300 dark:border-blue-300 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
            <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">Resolved</p>
            <p class="text-3xl font-bold text-blue-300 dark:text-blue-300">{{ $resolved }}</p>
        </div>
        
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-gray-500 dark:border-gray-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
            <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">Closed</p>
            <p class="text-3xl font-bold text-gray-600 dark:text-gray-300">{{ $closedTickets }}</p>
        </div>
        
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-purple-500 dark:border-purple-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
            <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">Account</p>
            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-red-500 dark:border-red-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
            <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">Rejected</p>
            <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $rejected }}</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
       
        <div class="md:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg dark:shadow-gray-900">
            <h3 class="font-bold text-lg mb-4 text-gray-800 dark:text-gray-200 border-b pb-2 dark:border-gray-700">Ticket Trends (Last 7 Days)</h3>
            <canvas id="lineChart" height="120"></canvas>
        </div>

        <div class="md:col-span-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg dark:shadow-gray-900">
            <h3 class="font-bold text-lg mb-4 text-gray-800 dark:text-gray-200 border-b pb-2 dark:border-gray-700">Ticket Status</h3>
            <canvas id="donutChart"></canvas>
        </div>

    </div>
    
    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4 mt-8"></h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
        
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-red-500 dark:border-red-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
            <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">Daily Tickets</p>
            <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $dailyTickets }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-indigo-500 dark:border-indigo-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
            <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">Weekly Tickets</p>
            <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $weeklyTickets }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-teal-500 dark:border-teal-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
            <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">Monthly Tickets</p>
            <p class="text-3xl font-bold text-teal-600 dark:text-teal-400">{{ $monthlyTickets }}</p>
        </div>
        
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg dark:shadow-gray-900">
            <h3 class="font-bold text-lg mb-4 text-gray-800 dark:text-gray-200 border-b pb-2 dark:border-gray-700">Daily Trend (Last 7 Days)</h3>
            <canvas id="dailyChart" height="120"></canvas>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg dark:shadow-gray-900">
            <h3 class="font-bold text-lg mb-4 text-gray-800 dark:text-gray-200 border-b pb-2 dark:border-gray-700">Weekly Trend (Last 4 Weeks)</h3>
            <canvas id="weeklyChart" height="120"></canvas>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg dark:shadow-gray-900">
            <h3 class="font-bold text-lg mb-4 text-gray-800 dark:text-gray-200 border-b pb-2 dark:border-gray-700">Monthly Trend (Last 6 Months)</h3>
            <canvas id="monthlyChart" height="120"></canvas>
        </div>

    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center mt-4 dark:shadow-gray-900">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">Quick Action</h2>
        <div class="flex justify-center gap-4">
             @if(Auth::user()->role == 'admin' || Auth::user()->role == 'it_head')
                <a href="{{ route('users.index') }}" class="bg-purple-600 dark:bg-purple-700 text-white px-6 py-2 rounded-lg hover:bg-purple-700 dark:hover:bg-purple-800">
                     Manage Users
                </a>
            @endif
            <a href="{{ route('tickets.index') }}" class="bg-blue-600 dark:bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-700 dark:hover:bg-blue-800">
               See More Tickets
            </a>
        </div>
    </div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fungsi untuk mendapatkan warna berdasarkan tema
        function getChartColors() {
            const isDarkMode = document.documentElement.classList.contains('dark');
            
            if (isDarkMode) {
                return {
                    gridColor: 'rgba(75, 85, 99, 0.3)',
                    tickColor: 'rgba(209, 213, 219, 0.8)',
                    textColor: 'rgba(209, 213, 219, 0.9)'
                };
            } else {
                return {
                    gridColor: 'rgba(0, 0, 0, 0.1)',
                    tickColor: 'rgba(75, 85, 99, 0.8)',
                    textColor: 'rgba(55, 65, 81, 0.9)'
                };
            }
        }

        // Fungsi untuk mengaplikasikan tema ke chart
        function applyDarkModeToChart(chart) {
            const colors = getChartColors();
            
            if (chart.options.scales) {
                // Apply to all axes
                Object.keys(chart.options.scales).forEach(scaleKey => {
                    if (chart.options.scales[scaleKey].grid) {
                        chart.options.scales[scaleKey].grid.color = colors.gridColor;
                    }
                    if (chart.options.scales[scaleKey].ticks) {
                        chart.options.scales[scaleKey].ticks.color = colors.tickColor;
                    }
                });
            }
            
            chart.update();
        }

        // Fungsi untuk menginisialisasi chart dengan tema yang benar
        function initializeChartWithTheme(ctx, config) {
            const colors = getChartColors();
            
            // Apply theme to scales if they exist
            if (config.options && config.options.scales) {
                Object.keys(config.options.scales).forEach(scaleKey => {
                    if (!config.options.scales[scaleKey].grid) {
                        config.options.scales[scaleKey].grid = {};
                    }
                    config.options.scales[scaleKey].grid.color = colors.gridColor;
                    
                    if (!config.options.scales[scaleKey].ticks) {
                        config.options.scales[scaleKey].ticks = {};
                    }
                    config.options.scales[scaleKey].ticks.color = colors.tickColor;
                });
            }
            
            return new Chart(ctx, config);
        }

        const donutCtx = document.getElementById('donutChart').getContext('2d');
        const donutData = @json($donutData);
        
        const donutChart = new Chart(donutCtx, {
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
                    hoverOffset: 4,
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: getChartColors().textColor
                        }
                    },
                    title: {
                        display: false,
                    }
                }
            }
        });

        const lineCtx = document.getElementById('lineChart').getContext('2d');
        const lineChartData = @json($lineChartData);

        const lineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: lineChartData.labels,
                datasets: [{
                    label: 'Tiket Baru Dibuat',
                    data: lineChartData.data,
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
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
                            callback: function(value) { if (value % 1 === 0) { return value; } },
                            color: getChartColors().tickColor
                        },
                        grid: {
                            color: getChartColors().gridColor
                        }
                    },
                    x: {
                        ticks: {
                            color: getChartColors().tickColor
                        },
                        grid: {
                            color: getChartColors().gridColor
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
            const dailyChart = new Chart(dailyCtx, {
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
                                text: 'Number of Tickets',
                                color: getChartColors().textColor
                            },
                            ticks: {
                                stepSize: 1,
                                color: getChartColors().tickColor
                            },
                            grid: {
                                color: getChartColors().gridColor
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Days',
                                color: getChartColors().textColor
                            },
                            ticks: {
                                color: getChartColors().tickColor
                            },
                            grid: {
                                color: getChartColors().gridColor
                            }
                        }
                    }
                }
            });
        } else {
            dailyCtx.fillStyle = document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#6B7280';
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
            const weeklyChart = new Chart(weeklyCtx, {
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
                                text: 'Number of Tickets',
                                color: getChartColors().textColor
                            },
                            ticks: {
                                color: getChartColors().tickColor
                            },
                            grid: {
                                color: getChartColors().gridColor
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Weeks',
                                color: getChartColors().textColor
                            },
                            ticks: {
                                color: getChartColors().tickColor
                            },
                            grid: {
                                color: getChartColors().gridColor
                            }
                        }
                    }
                }
            });
        } else {
            weeklyCtx.fillStyle = document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#6B7280';
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
            const monthlyChart = new Chart(monthlyCtx, {
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
                                text: 'Number of Tickets',
                                color: getChartColors().textColor
                            },
                            ticks: {
                                color: getChartColors().tickColor
                            },
                            grid: {
                                color: getChartColors().gridColor
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Months',
                                color: getChartColors().textColor
                            },
                            ticks: {
                                color: getChartColors().tickColor
                            },
                            grid: {
                                color: getChartColors().gridColor
                            }
                        }
                    }
                }
            });
        } else {
            monthlyCtx.fillStyle = document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#6B7280';
            monthlyCtx.font = '16px Arial';
            monthlyCtx.textAlign = 'center';
            monthlyCtx.fillText('No data available', monthlyCtx.canvas.width / 2, monthlyCtx.canvas.height / 2);
        }

        // Fungsi untuk mendeteksi perubahan tema dan memperbarui chart
        function updateChartsForTheme() {
            const colors = getChartColors();
            
            // Update donut chart legend
            donutChart.options.plugins.legend.labels.color = colors.textColor;
            donutChart.update();
            
            // Update line chart
            if (lineChart.options.scales) {
                Object.keys(lineChart.options.scales).forEach(scaleKey => {
                    if (lineChart.options.scales[scaleKey].grid) {
                        lineChart.options.scales[scaleKey].grid.color = colors.gridColor;
                    }
                    if (lineChart.options.scales[scaleKey].ticks) {
                        lineChart.options.scales[scaleKey].ticks.color = colors.tickColor;
                    }
                });
                lineChart.update();
            }
            
            // Update other charts similarly if they exist
            // Note: You might need to store references to all charts
        }

        // Observasi perubahan class dark pada html
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    updateChartsForTheme();
                }
            });
        });

        // Mulai observasi
        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });
    });
</script>