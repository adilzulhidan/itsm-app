@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #020617;
        color: #e2e8f0;
        overflow-x: hidden;
    }

    .noc-header {
        background: linear-gradient(to right, #38bdf8, #4ade80);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .noc-card {
        background-color: #0f172a;
        border: 1px solid #1e293b;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .noc-card:hover {
        border-color: #38bdf8;
        box-shadow: 0 10px 15px -3px rgba(14, 165, 233, 0.1);
    }

    .noc-input {
        background-color: #1e293b;
        border: 1px solid #334155;
        color: white;
        transition: border-color 0.2s;
    }
    .noc-input:focus {
        border-color: #38bdf8;
        outline: none;
    }

    ::-webkit-scrollbar {
        width: 8px;
    }
    ::-webkit-scrollbar-track {
        background: #020617;
    }
    ::-webkit-scrollbar-thumb {
        background: #334155;
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #475569;
    }

    /* Ticker Styles */
    .ticker-wrap {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        height: 3rem;
        background-color: #0f172a;
        border-top: 1px solid #1e293b;
        z-index: 50;
        display: flex;
        align-items: center;
    }

    .ticker-track {
        display: flex;
        width: fit-content;
        animation: scroll-left 40s linear infinite;
    }

    .ticker-item {
        white-space: nowrap;
        padding-right: 4rem;
        color: #94a3b8;
        font-size: 0.875rem;
        font-weight: 500;
        font-family: 'Inter', monospace;
        display: flex;
        align-items: center;
    }

    @keyframes scroll-left {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    .ticker-wrap:hover .ticker-track {
        animation-play-state: paused;
    }

    /* Network Topology Specific Styles */
    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        position: relative;
    }
    
    .pulse-dot::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(2.5);
            opacity: 0;
        }
    }

    .viz-container {
        position: relative;
        width: 100%;
        height: 400px;
        overflow: hidden;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    }

    .node {
        position: absolute;
        border-radius: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
        z-index: 10;
    }

    .node:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(56, 189, 248, 0.4);
    }

    .node-content {
        padding: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .node-icon {
        font-size: 20px;
        margin-bottom: 4px;
    }

    .node-label {
        font-size: 11px;
        font-weight: 600;
        text-align: center;
        white-space: nowrap;
    }

    .node-stats {
        font-size: 9px;
        opacity: 0.8;
        display: flex;
        gap: 4px;
    }

    .connection {
        position: absolute;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        height: 2px;
        transform-origin: 0 0;
        z-index: 5;
    }

    .data-flow {
        position: absolute;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #38bdf8;
        filter: drop-shadow(0 0 4px #38bdf8);
        z-index: 6;
        animation: dataFlow 3s linear infinite;
    }

    @keyframes dataFlow {
        0% { transform: translateX(0); opacity: 1; }
        100% { transform: translateX(100%); opacity: 0; }
    }

    .status-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid #0f172a;
    }

    .status-online {
        background-color: #10b981;
        box-shadow: 0 0 8px rgba(16, 185, 129, 0.6);
    }

    .status-warning {
        background-color: #f59e0b;
        box-shadow: 0 0 8px rgba(245, 158, 11, 0.6);
    }

    .network-stats {
        position: absolute;
        bottom: 16px;
        left: 16px;
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(10px);
        padding: 12px;
        border-radius: 8px;
        border: 1px solid rgba(56, 189, 248, 0.2);
        z-index: 20;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 4px 0;
    }

    .stat-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .stat-label {
        font-size: 11px;
        color: #94a3b8;
    }

    .stat-value {
        font-size: 12px;
        font-weight: 600;
        color: #e2e8f0;
    }
</style>

<div class="w-full min-h-screen pb-16">

    <div class="flex flex-col lg:flex-row justify-between items-end gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">NETWORK OPERATIONS CENTER</h1>
            <div class="flex items-center gap-3 text-xs font-mono text-slate-400 mt-1">
                <span id="live-clock" class="text-emerald-400 font-bold">00:00:00</span>
                <span>|</span>
                <span>SYSTEM STATUS: <span class="text-emerald-400">NOMINAL</span></span>
            </div>
        </div>

        <form action="{{ route('analytics.index') }}" method="GET" class="flex gap-2">
            <input type="date" name="start_date" value="{{ $startDate }}" 
                   class="bg-slate-800 border border-slate-700 text-white text-xs rounded px-2 py-1.5 focus:ring-1 focus:ring-sky-500 outline-none">
            <span class="text-slate-500 self-center">-</span>
            <input type="date" name="end_date" value="{{ $endDate }}" 
                   class="bg-slate-800 border border-slate-700 text-white text-xs rounded px-2 py-1.5 focus:ring-1 focus:ring-sky-500 outline-none">
            
            <button type="submit" class="bg-sky-600 hover:bg-sky-500 text-white px-3 py-1.5 rounded text-xs font-bold transition-colors">
                FILTER
            </button>
            <a href="{{ route('analytics.export', ['start_date' => request('start_date', $startDate), 'end_date' => request('end_date', $endDate)]) }}" target="_blank"
               class="bg-rose-600 hover:bg-rose-500 text-white px-3 py-1.5 rounded text-xs font-bold transition-colors flex items-center gap-1">
               <i class="bi bi-file-pdf"></i> PDF
            </a>
        </form>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
        <div class="noc-card p-4 flex flex-col justify-between h-24">
            <div class="flex justify-between items-start">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Tiket</span>
                <i class="bi bi-ticket-perforated text-sky-500"></i>
            </div>
            <div class="text-2xl font-bold text-white">{{ $totalTickets }}</div>
        </div>

        <div class="noc-card p-4 flex flex-col justify-between h-24">
            <div class="flex justify-between items-start">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Penyelesaian</span>
                <i class="bi bi-check-circle text-emerald-500"></i>
            </div>
            <div class="flex items-end gap-2">
                <div class="text-2xl font-bold text-white">{{ $completionRate }}%</div>
                <div class="w-full bg-slate-700 h-1 mb-2 rounded-full flex-1">
                    <div class="bg-emerald-500 h-1 rounded-full" style="width: {{ $completionRate }}%"></div>
                </div>
            </div>
        </div>

        <div class="noc-card p-4 flex flex-col justify-between h-24">
            <div class="flex justify-between items-start">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">MTTR (Rata-rata)</span>
                <i class="bi bi-stopwatch text-amber-500"></i>
            </div>
            <div class="text-2xl font-bold text-white">{{ $mttr }} <span class="text-xs font-normal text-slate-500">Jam</span></div>
        </div>

        <div class="noc-card p-4 flex flex-col justify-between h-24 border-l-4 border-l-emerald-500">
            <div class="flex justify-between items-start">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Network Health</span>
                <span class="pulse-dot bg-emerald-500"></span>
            </div>
            <div class="text-2xl font-bold text-white">99.9% <span class="text-xs font-normal text-emerald-400">UP</span></div>
        </div>
    </div>

    <div class="noc-card mb-4">
        <div class="p-3 border-b border-slate-800 flex justify-between items-center bg-slate-900/50 rounded-t-lg">
            <h3 class="text-xs font-bold text-slate-300 flex items-center gap-2">
                <i class="bi bi-diagram-3 text-sky-400"></i> LIVE NETWORK TOPOLOGY
            </h3>
            <div class="flex gap-2">
                <span class="flex items-center gap-1 text-[10px] text-slate-500"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Online</span>
                <span class="flex items-center gap-1 text-[10px] text-slate-500"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Warning</span>
                <span class="flex items-center gap-1 text-[10px] text-slate-500"><span class="w-2 h-2 rounded-full bg-rose-500"></span> Critical</span>
            </div>
        </div>
        <div class="viz-container relative" id="networkTopology">
            <div class="network-stats">
                <div class="stat-item">
                    <span class="stat-dot bg-emerald-500"></span>
                    <span class="stat-label">Online:</span>
                    <span class="stat-value">8/10</span>
                </div>
                <div class="stat-item">
                    <span class="stat-dot bg-amber-500"></span>
                    <span class="stat-label">Warning:</span>
                    <span class="stat-value">1/10</span>
                </div>
                <div class="stat-item">
                    <span class="stat-dot bg-rose-500"></span>
                    <span class="stat-label">Critical:</span>
                    <span class="stat-value">1/10</span>
                </div>
                <div class="stat-item">
                    <span class="stat-dot bg-sky-500"></span>
                    <span class="stat-label">Bandwidth:</span>
                    <span class="stat-value">72%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
        <div class="noc-card p-4 lg:col-span-2">
            <h3 class="text-xs font-bold text-slate-400 mb-2 uppercase">Tren Volume Tiket</h3>
            <div id="trendChart" class="w-full h-[250px]"></div>
        </div>
    </div>

</div>

<!-- Ticker Footer -->
<div class="ticker-wrap">
    <div class="ticker-track">
        @php
            $tickerContent = '
                <span class="text-emerald-500 mx-2">●</span> SYSTEM STATUS: <span class="text-emerald-400 font-bold">ONLINE</span>
                <span class="text-slate-600 mx-4">|</span>
                <span class="text-sky-500 mx-2">●</span> LAST UPDATE: <span class="text-sky-400 font-bold">' . now()->format('H:i:s') . '</span>
                <span class="text-slate-600 mx-4">|</span>
                <span class="text-amber-500 mx-2">●</span> TOTAL TICKETS: <span class="text-white font-bold">' . $totalTickets . '</span>
                <span class="text-slate-600 mx-4">|</span>
                <span class="text-violet-500 mx-2">●</span> MTTR: <span class="text-white font-bold">' . $mttr . ' JAM</span>
                <span class="text-slate-600 mx-4">|</span>
                <span class="text-rose-500 mx-2">●</span> COMPLETION RATE: <span class="text-white font-bold">' . $completionRate . '%</span>
                <span class="text-slate-600 mx-4">|</span>
                <span class="text-slate-500 mx-2">●</span> DATABASE: STABLE
                <span class="text-slate-600 mx-4">|</span>
                MONITORING ACTIVE
            ';
        @endphp

        <div class="ticker-item">
            {!! $tickerContent !!}
        </div>

        <div class="ticker-item">
            {!! $tickerContent !!}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Clock Logic
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { 
            hour12: false,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('live-clock').textContent = timeString;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Network Topology
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('networkTopology');
        if (!container) return;

        // Define network nodes
        const nodes = [
            { 
                id: 1, 
                name: 'Internet Gateway',
                type: 'cloud',
                icon: '🌐',
                status: 'online',
                x: 15, y: 50,
                stats: '1 Gbps'
            },
            { 
                id: 2, 
                name: 'Firewall',
                type: 'security',
                icon: '🛡️',
                status: 'online',
                x: 25, y: 50,
                stats: '98% CPU'
            },
            { 
                id: 3, 
                name: 'Core Switch',
                type: 'network',
                icon: '🔀',
                status: 'online',
                x: 40, y: 50,
                stats: '720 Mbps'
            },
            { 
                id: 4, 
                name: 'Web Server',
                type: 'server',
                icon: '💻',
                status: 'warning',
                x: 55, y: 30,
                stats: '85% Load'
            },
            { 
                id: 5, 
                name: 'Database',
                type: 'database',
                icon: '🗄️',
                status: 'online',
                x: 55, y: 50,
                stats: '64% CPU'
            },
            { 
                id: 6, 
                name: 'Backup Server',
                type: 'storage',
                icon: '💾',
                status: 'online',
                x: 55, y: 70,
                stats: '2.4 TB'
            },
            { 
                id: 7, 
                name: 'Office LAN',
                type: 'network',
                icon: '🏢',
                status: 'online',
                x: 70, y: 30,
                stats: '48 Clients'
            },
            { 
                id: 8, 
                name: 'Production',
                type: 'server',
                icon: '🏭',
                status: 'critical',
                x: 70, y: 50,
                stats: '95% Load'
            },
            { 
                id: 9, 
                name: 'Backup NAS',
                type: 'storage',
                icon: '📀',
                status: 'online',
                x: 70, y: 70,
                stats: '4.8 TB'
            },
            { 
                id: 10, 
                name: 'Monitoring',
                type: 'monitor',
                icon: '📊',
                status: 'online',
                x: 85, y: 50,
                stats: 'Active'
            }
        ];

        // Define connections
        const connections = [
            { from: 1, to: 2, label: '1 Gbps' },
            { from: 2, to: 3, label: '10 Gbps' },
            { from: 3, to: 4, label: '1 Gbps' },
            { from: 3, to: 5, label: '10 Gbps' },
            { from: 3, to: 6, label: '1 Gbps' },
            { from: 4, to: 7, label: '100 Mbps' },
            { from: 5, to: 8, label: '10 Gbps' },
            { from: 6, to: 9, label: '1 Gbps' },
            { from: 3, to: 10, label: '100 Mbps' }
        ];

        // Create nodes
        nodes.forEach(node => {
            const nodeEl = document.createElement('div');
            nodeEl.className = 'node';
            nodeEl.style.left = `${node.x}%`;
            nodeEl.style.top = `${node.y}%`;
            
            // Determine colors based on status
            let bgColor, borderColor;
            switch(node.status) {
                case 'online':
                    bgColor = 'rgba(16, 185, 129, 0.1)';
                    borderColor = '#10b981';
                    break;
                case 'warning':
                    bgColor = 'rgba(245, 158, 11, 0.1)';
                    borderColor = '#f59e0b';
                    break;
                case 'critical':
                    bgColor = 'rgba(239, 68, 68, 0.1)';
                    borderColor = '#ef4444';
                    break;
                default:
                    bgColor = 'rgba(100, 116, 139, 0.1)';
                    borderColor = '#64748b';
            }
            
            nodeEl.style.background = bgColor;
            nodeEl.style.border = `1px solid ${borderColor}`;
            nodeEl.style.boxShadow = `0 0 15px ${borderColor}40`;
            
            nodeEl.innerHTML = `
                <div class="node-content">
                    <div class="node-icon">${node.icon}</div>
                    <div class="node-label">${node.name}</div>
                    <div class="node-stats">${node.stats}</div>
                </div>
                <div class="status-badge status-${node.status}"></div>
            `;
            
            // Add hover effect
            nodeEl.addEventListener('mouseenter', () => {
                nodeEl.style.transform = 'scale(1.05)';
                nodeEl.style.zIndex = '100';
                nodeEl.style.boxShadow = `0 0 25px ${borderColor}80`;
            });
            
            nodeEl.addEventListener('mouseleave', () => {
                nodeEl.style.transform = 'scale(1)';
                nodeEl.style.zIndex = '10';
                nodeEl.style.boxShadow = `0 0 15px ${borderColor}40`;
            });
            
            container.appendChild(nodeEl);
        });

        // Create connections
        connections.forEach(conn => {
            const fromNode = nodes.find(n => n.id === conn.from);
            const toNode = nodes.find(n => n.id === conn.to);
            
            if (!fromNode || !toNode) return;
            
            // Create connection line
            const line = document.createElement('div');
            line.className = 'connection';
            
            const containerWidth = container.offsetWidth;
            const containerHeight = container.offsetHeight;
            
            const x1 = (fromNode.x / 100) * containerWidth;
            const y1 = (fromNode.y / 100) * containerHeight;
            const x2 = (toNode.x / 100) * containerWidth;
            const y2 = (toNode.y / 100) * containerHeight;
            
            const length = Math.sqrt(Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2));
            const angle = Math.atan2(y2 - y1, x2 - x1) * 180 / Math.PI;
            
            line.style.width = `${length}px`;
            line.style.left = `${x1}px`;
            line.style.top = `${y1}px`;
            line.style.transform = `rotate(${angle}deg)`;
            
            container.appendChild(line);
            
            // Create data flow animation
            createDataFlow(line, fromNode, toNode);
        });

        function createDataFlow(line, fromNode, toNode) {
            const flow = document.createElement('div');
            flow.className = 'data-flow';
            
            // Randomize animation delay
            flow.style.animationDelay = `${Math.random() * 2}s`;
            
            // Position at start of line
            flow.style.left = '0px';
            flow.style.top = '-2px';
            
            line.appendChild(flow);
            
            // Create multiple data flows
            setInterval(() => {
                if (Math.random() > 0.5) {
                    const newFlow = flow.cloneNode();
                    newFlow.style.animationDelay = '0s';
                    line.appendChild(newFlow);
                    
                    // Remove after animation completes
                    setTimeout(() => {
                        if (newFlow.parentNode === line) {
                            line.removeChild(newFlow);
                        }
                    }, 3000);
                }
            }, 1000);
        }

        // Update stats periodically
        function updateNetworkStats() {
            const onlineCount = nodes.filter(n => n.status === 'online').length;
            const warningCount = nodes.filter(n => n.status === 'warning').length;
            const criticalCount = nodes.filter(n => n.status === 'critical').length;
            
            // Randomly change some statuses for realism
            if (Math.random() < 0.1) {
                const randomNode = nodes[Math.floor(Math.random() * nodes.length)];
                const statuses = ['online', 'warning', 'critical'];
                randomNode.status = statuses[Math.floor(Math.random() * statuses.length)];
                
                // Update the node display
                const nodeEl = container.querySelector(`.node:nth-child(${nodes.indexOf(randomNode) + 1})`);
                if (nodeEl) {
                    const badge = nodeEl.querySelector('.status-badge');
                    if (badge) {
                        badge.className = 'status-badge';
                        badge.classList.add(`status-${randomNode.status}`);
                    }
                }
            }
            
            // Update bandwidth usage
            const bandwidth = Math.floor(60 + Math.random() * 20);
            
            // Update stats display
            const stats = container.querySelector('.network-stats');
            if (stats) {
                stats.innerHTML = `
                    <div class="stat-item">
                        <span class="stat-dot bg-emerald-500"></span>
                        <span class="stat-label">Online:</span>
                        <span class="stat-value">${onlineCount}/${nodes.length}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-dot bg-amber-500"></span>
                        <span class="stat-label">Warning:</span>
                        <span class="stat-value">${warningCount}/${nodes.length}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-dot bg-rose-500"></span>
                        <span class="stat-label">Critical:</span>
                        <span class="stat-value">${criticalCount}/${nodes.length}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-dot bg-sky-500"></span>
                        <span class="stat-label">Bandwidth:</span>
                        <span class="stat-value">${bandwidth}%</span>
                    </div>
                `;
            }
        }
        
        // Update stats every 5 seconds
        setInterval(updateNetworkStats, 5000);
        updateNetworkStats(); // Initial call
    });

    // Charts Configuration
    const commonOptions = {
        chart: {
            background: 'transparent',
            foreColor: '#94a3b8',
            fontFamily: 'Inter, sans-serif',
            toolbar: { show: false },
            zoom: { enabled: false }
        },
        theme: { mode: 'dark' },
        grid: {
            borderColor: '#1e293b',
            strokeDashArray: 4,
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { height: 300 },
                legend: { position: 'bottom', offsetY: 0 }
            }
        }]
    };

    // Trend Chart
    new ApexCharts(document.querySelector("#trendChart"), {
        ...commonOptions,
        series: [{
            name: 'Tiket',
            data: {!! json_encode($trendData->pluck('total')) !!}
        }],
        chart: {
            ...commonOptions.chart,
            type: 'area',
            height: 250
        },
        stroke: { 
            curve: 'smooth', 
            width: 3, 
            colors: ['#0ea5e9'] 
        },
        xaxis: {
            categories: {!! json_encode($trendData->pluck('date')) !!},
            type: 'datetime',
            tooltip: { enabled: false },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.6,
                opacityTo: 0.1,
                stops: [0, 90, 100]
            }
        },
        colors: ['#0ea5e9']
    }).render();

    // Category Chart
    new ApexCharts(document.querySelector("#categoryChart"), {
        ...commonOptions,
        series: {!! json_encode($categoryData->pluck('total')) !!},
        labels: {!! json_encode($categoryData->pluck('category.name')) !!},
        chart: {
            ...commonOptions.chart,
            type: 'donut',
            height: 250
        },
        stroke: { 
            show: true, 
            colors: ['#0f172a'], 
            width: 3 
        },
        colors: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '11px'
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        name: { 
                            color: '#94a3b8',
                            fontSize: '11px'
                        },
                        value: { 
                            color: '#ffffff', 
                            fontSize: '18px', 
                            fontWeight: 700 
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            color: '#94a3b8',
                            fontSize: '12px'
                        }
                    }
                }
            }
        }
    }).render();
</script>
@endsection