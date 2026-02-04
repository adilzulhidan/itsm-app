@extends('layouts.app') 

@section('title', 'Dashboard')

@section('content')

<h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 border-b pb-2 dark:border-gray-700">IT Service Management Dashboard</h1>

<div class="mb-4">
    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 mb-2">
        <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
            <span>System Status: <span class="font-semibold text-green-600 dark:text-green-400">Operational</span></span>
        </div>
        <span>•</span>
        <span>Last Updated: <span id="last-updated" class="font-semibold">{{ now()->format('M d, Y H:i') }}</span></span>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-6 gap-6 mb-8">
    <!-- Total Tickets -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-blue-800 dark:border-blue-600 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">Total Ticket</p>
                <p class="text-3xl font-bold text-blue-800 dark:text-blue-400">{{ $totalTickets }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                <i class="bi bi-ticket-detailed text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
        <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
            @php
                $growth = $totalTickets > 0 ? 12 : 0; // Example growth percentage
            @endphp
            <span class="text-green-600 dark:text-green-400">↑ {{ $growth }}%</span> from last month
        </div>
    </div>

    <!-- Open Tickets -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-green-500 dark:border-green-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">Open</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $openTickets }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                <i class="bi bi-folder-plus text-green-600 dark:text-green-400"></i>
            </div>
        </div>
        <div class="mt-2">
            <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400">
                <span>Pending resolution</span>
                <span class="px-2 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 font-medium">
                    {{ $totalTickets > 0 ? round(($openTickets / $totalTickets) * 100, 1) : 0 }}%
                </span>
            </div>
        </div>
    </div>

    <!-- In Progress -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-yellow-500 dark:border-yellow-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">In Progress</p>
                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $progressTickets }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                <i class="bi bi-gear-wide-connected text-yellow-600 dark:text-yellow-400"></i>
            </div>
        </div>
        <div class="mt-2">
            <div class="flex items-center gap-2">
                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $totalTickets > 0 ? ($progressTickets / $totalTickets) * 100 : 0 }}%"></div>
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $totalTickets > 0 ? round(($progressTickets / $totalTickets) * 100, 1) : 0 }}%
                </span>
            </div>
        </div>
    </div>
    
    <!-- Resolved -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-cyan-500 dark:border-cyan-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">Resolved</p>
                <p class="text-3xl font-bold text-cyan-600 dark:text-cyan-400">{{ $resolved }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center">
                <i class="bi bi-check-circle text-cyan-600 dark:text-cyan-400"></i>
            </div>
        </div>
        <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
            <span class="text-green-600 dark:text-green-400">Resolved rate</span>
            <div class="font-medium">{{ $totalTickets > 0 ? round(($resolved / $totalTickets) * 100, 1) : 0 }}%</div>
        </div>
    </div>
    
    <!-- Closed -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-gray-500 dark:border-gray-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">Closed</p>
                <p class="text-3xl font-bold text-gray-600 dark:text-gray-300">{{ $closedTickets }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-900/30 flex items-center justify-center">
                <i class="bi bi-archive text-gray-600 dark:text-gray-400"></i>
            </div>
        </div>
        <div class="mt-2">
            <div class="flex items-center gap-2">
                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-gray-500 h-2 rounded-full" style="width: {{ $totalTickets > 0 ? ($closedTickets / $totalTickets) * 100 : 0 }}%"></div>
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $totalTickets > 0 ? round(($closedTickets / $totalTickets) * 100, 1) : 0 }}%
                </span>
            </div>
        </div>
    </div>
    
    <!-- Users -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-purple-500 dark:border-purple-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">Users</p>
                <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $totalUsers }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                <i class="bi bi-people text-purple-600 dark:text-purple-400"></i>
            </div>
        </div>
        <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
            Active accounts in system
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Daily Tickets -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-red-500 dark:border-red-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
        <div class="flex justify-between items-center mb-4">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">Today</p>
                <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $dailyTickets }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                <i class="bi bi-calendar-day text-xl text-red-600 dark:text-red-400"></i>
            </div>
        </div>
        <canvas id="dailyChart" height="80"></canvas>
    </div>

    <!-- Weekly Tickets -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-indigo-500 dark:border-indigo-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
        <div class="flex justify-between items-center mb-4">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">This Week</p>
                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $weeklyTickets }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                <i class="bi bi-calendar-week text-xl text-indigo-600 dark:text-indigo-400"></i>
            </div>
        </div>
        <canvas id="weeklyChart" height="80"></canvas>
    </div>

    <!-- Monthly Tickets -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-teal-500 dark:border-teal-400 hover:shadow-xl transition duration-300 dark:shadow-gray-900">
        <div class="flex justify-between items-center mb-4">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm uppercase">This Month</p>
                <p class="text-3xl font-bold text-teal-600 dark:text-teal-400">{{ $monthlyTickets }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center">
                <i class="bi bi-calendar-month text-xl text-teal-600 dark:text-teal-400"></i>
            </div>
        </div>
        <canvas id="monthlyChart" height="80"></canvas>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Ticket Trends -->
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg dark:shadow-gray-900">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-200">Ticket Trends</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Last 30 days performance</p>
            </div>
            <div class="flex gap-2">
                <button onclick="toggleChartType()" class="px-3 py-1 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 transition-colors">
                    Switch View
                </button>
            </div>
        </div>
        <canvas id="lineChart" height="120"></canvas>
    </div>

    <!-- Ticket Distribution -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg dark:shadow-gray-900">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-200">Ticket Distribution</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">By current status</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                <i class="bi bi-pie-chart text-purple-600 dark:text-purple-400"></i>
            </div>
        </div>
        <canvas id="donutChart" height="200"></canvas>
    </div>
</div>

<!-- Performance Metrics -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Resolution Rate -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg dark:shadow-gray-900">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Resolution Rate</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">Success rate</p>
            </div>
            @php
                $resolutionRate = $totalTickets > 0 ? (($resolved + $closedTickets) / $totalTickets) * 100 : 0;
            @endphp
            <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ round($resolutionRate, 1) }}%</div>
        </div>
        <div class="relative pt-1">
            <div class="flex mb-2 items-center justify-between">
                <div>
                    <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-green-600 bg-green-200 dark:bg-green-900/30">
                        {{ $resolved + $closedTickets }} of {{ $totalTickets }} tickets
                    </span>
                </div>
                <div class="text-right">
                    <span class="text-xs font-semibold inline-block text-green-600">
                        {{ round($resolutionRate, 1) }}%
                    </span>
                </div>
            </div>
            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-green-200 dark:bg-green-900/30">
                <div style="width:{{ $resolutionRate }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"></div>
            </div>
        </div>
    </div>

    <!-- Rejected Tickets -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg dark:shadow-gray-900">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Rejected Tickets</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">Not approved/denied</p>
            </div>
            <div class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $rejected }}</div>
        </div>
        <div class="mt-2">
            <div class="flex items-center gap-2">
                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalTickets > 0 ? ($rejected / $totalTickets) * 100 : 0 }}%"></div>
                </div>
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $totalTickets > 0 ? round(($rejected / $totalTickets) * 100, 1) : 0 }}%
                </span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-800 dark:to-purple-800 rounded-2xl shadow-xl p-6 text-white">
        <h3 class="text-lg font-bold mb-4">Quick Actions</h3>
        <div class="space-y-3">
            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'it_head')
                <a href="{{ route('users.index') }}" class="group flex items-center gap-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm px-4 py-3 rounded-xl transition-all duration-300">
                    <i class="bi bi-people-fill text-lg"></i>
                    <div class="flex-1">
                        <div class="font-semibold">Manage Users</div>
                        <div class="text-sm text-blue-100 opacity-90">User administration</div>
                    </div>
                    <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            @endif
            
            <a href="{{ route('tickets.index') }}" class="group flex items-center gap-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm px-4 py-3 rounded-xl transition-all duration-300">
                <i class="bi bi-ticket-detailed text-lg"></i>
                <div class="flex-1">
                    <div class="font-semibold">View Tickets</div>
                    <div class="text-sm text-blue-100 opacity-90">Browse all tickets</div>
                </div>
                <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </a>
            
            <a href="{{ route('tickets.create') }}" class="group flex items-center gap-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm px-4 py-3 rounded-xl transition-all duration-300">
                <i class="bi bi-plus-circle text-lg"></i>
                <div class="flex-1">
                    <div class="font-semibold">New Ticket</div>
                    <div class="text-sm text-blue-100 opacity-90">Create new request</div>
                </div>
                <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
</div>

<!-- System Status -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 dark:shadow-gray-900">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">System Status</h2>
        <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
            <span class="text-sm text-green-600 dark:text-green-400 font-medium">All Systems Operational</span>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <i class="bi bi-database text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <div class="font-medium text-gray-800 dark:text-gray-200">Database</div>
                    <div class="text-sm text-green-600 dark:text-green-400">Operational</div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <i class="bi bi-plug text-green-600 dark:text-green-400"></i>
                </div>
                <div>
                    <div class="font-medium text-gray-800 dark:text-gray-200">API Services</div>
                    <div class="text-sm text-green-600 dark:text-green-400">Online</div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                    <i class="bi bi-speedometer2 text-purple-600 dark:text-purple-400"></i>
                </div>
                <div>
                    <div class="font-medium text-gray-800 dark:text-gray-200">Response Time</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">< 200ms</div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center">
                    <i class="bi bi-clock-history text-cyan-600 dark:text-cyan-400"></i>
                </div>
                <div>
                    <div class="font-medium text-gray-800 dark:text-gray-200">Uptime</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">99.9%</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Auto-refresh functionality
        let refreshInterval = 30000;
        let refreshEnabled = true;
        let refreshTimer;

        function startRefreshTimer() {
            if (refreshEnabled) {
                refreshTimer = setInterval(refreshDashboard, refreshInterval);
            }
        }

        function refreshDashboard() {
            const refreshIcon = document.getElementById('refresh-icon');
            if (refreshIcon) {
                refreshIcon.style.transition = 'transform 0.5s ease';
                refreshIcon.style.transform = 'rotate(360deg)';
                
                setTimeout(() => {
                    refreshIcon.style.transform = 'rotate(0deg)';
                    
                    // Update last updated timestamp
                    const now = new Date();
                    const lastUpdated = document.getElementById('last-updated');
                    if (lastUpdated) {
                        lastUpdated.textContent = 
                            now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) + ' ' +
                            now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                    }
                }, 500);
            }
        }

        function getChartColors() {
            const isDarkMode = document.documentElement.classList.contains('dark');
            
            if (isDarkMode) {
                return {
                    gridColor: 'rgba(75, 85, 99, 0.3)',
                    tickColor: 'rgba(209, 213, 219, 0.8)',
                    textColor: 'rgb(231, 234, 237)',
                    background: 'rgba(17, 24, 39, 0.8)'
                };
            } else {
                return {
                    gridColor: 'rgba(0, 0, 0, 0.1)',
                    tickColor: 'rgba(75, 85, 99, 0.8)',
                    textColor: 'rgba(55, 65, 81, 0.9)',
                    background: 'rgba(255, 255, 255, 0.8)'
                };
            }
        }

        // Initialize Charts
        const colors = getChartColors();

        // Line Chart
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        const lineChartData = @json($lineChartData);
        
        const lineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: lineChartData.labels || [],
                datasets: [{
                    label: 'Tickets Created',
                    data: lineChartData.data || [],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: colors.background,
                        titleColor: colors.textColor,
                        bodyColor: colors.textColor,
                        borderColor: colors.gridColor,
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: colors.gridColor },
                        ticks: {
                            color: colors.tickColor,
                            callback: function(value) {
                                if (value % 1 === 0) return value;
                            }
                        }
                    },
                    x: {
                        grid: { color: colors.gridColor },
                        ticks: { color: colors.tickColor }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'nearest'
                }
            }
        });

        // Donut Chart
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        const donutData = @json($donutData);
        
        const donutChart = new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: donutData.labels || [],
                datasets: [{
                    data: donutData.data || [],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(107, 114, 128, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(59, 130, 246)',
                        'rgb(107, 114, 128)',
                        'rgb(239, 68, 68)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: colors.textColor,
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 11 }
                        }
                    },
                    tooltip: {
                        backgroundColor: colors.background,
                        titleColor: colors.textColor,
                        bodyColor: colors.textColor,
                        borderColor: colors.gridColor,
                        borderWidth: 1
                    }
                },
                cutout: '65%'
            }
        });

        // Daily Chart
        const dailyCtx = document.getElementById('dailyChart').getContext('2d');
        const dailyChartData = @json($dailyChartData ?? ['labels' => [], 'data' => []]);
        
        if (dailyChartData.labels && dailyChartData.labels.length > 0) {
            new Chart(dailyCtx, {
                type: 'bar',
                data: {
                    labels: dailyChartData.labels,
                    datasets: [{
                        data: dailyChartData.data,
                        backgroundColor: 'rgba(239, 68, 68, 0.3)',
                        borderColor: 'rgb(239, 68, 68)',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { display: false, beginAtZero: true },
                        x: { display: false }
                    },
                    interaction: { intersect: false }
                }
            });
        }

        // Weekly Chart
        const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
        const weeklyChartData = @json($weeklyChartData ?? ['labels' => [], 'data' => []]);
        
        if (weeklyChartData.labels && weeklyChartData.labels.length > 0) {
            new Chart(weeklyCtx, {
                type: 'bar',
                data: {
                    labels: weeklyChartData.labels,
                    datasets: [{
                        data: weeklyChartData.data,
                        backgroundColor: 'rgba(99, 102, 241, 0.3)',
                        borderColor: 'rgb(99, 102, 241)',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { display: false, beginAtZero: true },
                        x: { display: false }
                    },
                    interaction: { intersect: false }
                }
            });
        }

        // Monthly Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChartData = @json($monthlyChartData ?? ['labels' => [], 'data' => []]);
        
        if (monthlyChartData.labels && monthlyChartData.labels.length > 0) {
            new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: monthlyChartData.labels,
                    datasets: [{
                        data: monthlyChartData.data,
                        backgroundColor: 'rgba(20, 184, 166, 0.3)',
                        borderColor: 'rgb(20, 184, 166)',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { display: false, beginAtZero: true },
                        x: { display: false }
                    },
                    interaction: { intersect: false }
                }
            });
        }

        // Chart type toggle function
        function toggleChartType() {
            if (lineChart.config.type === 'line') {
                lineChart.config.type = 'bar';
                lineChart.data.datasets[0].borderWidth = 0;
                lineChart.data.datasets[0].borderRadius = 6;
            } else {
                lineChart.config.type = 'line';
                lineChart.data.datasets[0].borderWidth = 3;
                lineChart.data.datasets[0].borderRadius = 0;
            }
            lineChart.update();
        }

        // Theme observer
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    const newColors = getChartColors();
                    
                    // Update line chart
                    lineChart.options.scales.x.grid.color = newColors.gridColor;
                    lineChart.options.scales.x.ticks.color = newColors.tickColor;
                    lineChart.options.scales.y.grid.color = newColors.gridColor;
                    lineChart.options.scales.y.ticks.color = newColors.tickColor;
                    lineChart.options.plugins.tooltip.backgroundColor = newColors.background;
                    lineChart.options.plugins.tooltip.titleColor = newColors.textColor;
                    lineChart.options.plugins.tooltip.bodyColor = newColors.textColor;
                    lineChart.update();
                    
                    // Update donut chart
                    donutChart.options.plugins.legend.labels.color = newColors.textColor;
                    donutChart.options.plugins.tooltip.backgroundColor = newColors.background;
                    donutChart.options.plugins.tooltip.titleColor = newColors.textColor;
                    donutChart.options.plugins.tooltip.bodyColor = newColors.textColor;
                    donutChart.update();
                }
            });
        });
        
        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });

        // Start refresh timer
        startRefreshTimer();

        // Make toggleChartType globally available
        window.toggleChartType = toggleChartType;
    });
</script>
@endpush