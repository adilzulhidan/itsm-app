@extends('layouts.app')

@section('content')
<div class="p-6">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Laporan & Analitik</h1>
        
        <form action="{{ route('analytics.index') }}" method="GET" class="flex gap-4 bg-white p-2 rounded shadow-sm">
            <div>
                <input type="date" name="start_date" value="{{ $startDate }}" 
                       class="border-gray-300 rounded text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <span class="self-center text-gray-500">-</span>
            <div>
                <input type="date" name="end_date" value="{{ $endDate }}" 
                       class="border-gray-300 rounded text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded text-sm hover:bg-blue-700">
                Filter
            </button>
            <form action="{{ route('analytics.index') }}" method="GET" class="...">
    <button type="submit" class="...">Filter</button>
    
    <a href="{{ route('analytics.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
       target="_blank"
       class="bg-red-600 text-white px-4 py-1 rounded text-sm hover:bg-red-700 flex items-center gap-2 ml-2">
       <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
       </svg>
       Download PDF
    </a>
</form>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-xs font-semibold uppercase">Total Tiket Masuk</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalTickets }}</h3>
            <p class="text-xs text-gray-400 mt-1">Dalam periode yang dipilih</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-xs font-semibold uppercase">Tingkat Penyelesaian</p>
            <h3 class="text-3xl font-bold text-green-600 mt-2">{{ $completionRate }}%</h3>
            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                <div class="bg-green-600 h-1.5 rounded-full" style="width: {{ $completionRate }}%"></div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-xs font-semibold uppercase">Rata-rata Waktu Fix (MTTR)</p>
            <h3 class="text-3xl font-bold text-blue-600 mt-2">{{ $mttr }} <span class="text-lg text-gray-500">Jam</span></h3>
            <p class="text-xs text-gray-400 mt-1">Kecepatan rata-rata tim</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white p-6 rounded-xl shadow-sm lg:col-span-2">
            <h3 class="font-bold text-gray-700 mb-4">Tren Volume Tiket</h3>
            <div id="trendChart" class="h-80"></div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h3 class="font-bold text-gray-700 mb-4">Top Teknisi (Tiket Ditangani)</h3>
            <div id="agentChart" class="h-64"></div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h3 class="font-bold text-gray-700 mb-4">Distribusi Kategori</h3>
            <div id="categoryChart" class="h-64 flex justify-center"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // 1. CONFIG TREND CHART
    const trendOptions = {
        series: [{
            name: 'Tiket',
            data: {!! json_encode($trendData->pluck('total')) !!}
        }],
        chart: { type: 'area', height: 320, toolbar: {show: false} },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        xaxis: { 
            categories: {!! json_encode($trendData->pluck('date')) !!},
            type: 'datetime'
        },
        colors: ['#4F46E5'], // Indigo
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.3 } }
    };
    new ApexCharts(document.querySelector("#trendChart"), trendOptions).render();

    // 2. CONFIG AGENT CHART (Bar)
    const agentOptions = {
        series: [{
            name: 'Tiket Ditangani',
            data: {!! json_encode($agentPerformance->pluck('total')) !!}
        }],
        chart: { type: 'bar', height: 250, toolbar: {show: false} },
        plotOptions: { bar: { borderRadius: 4, horizontal: true } },
        xaxis: { categories: {!! json_encode($agentPerformance->pluck('assignee.name')) !!} },
        colors: ['#0EA5E9'] // Sky Blue
    };
    new ApexCharts(document.querySelector("#agentChart"), agentOptions).render();

    // 3. CONFIG CATEGORY CHART (Donut)
    const catOptions = {
        series: {!! json_encode($categoryData->pluck('total')) !!},
        labels: {!! json_encode($categoryData->pluck('category.name')) !!},
        chart: { type: 'donut', height: 250 },
        colors: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'],
        legend: { position: 'bottom' }
    };
    new ApexCharts(document.querySelector("#categoryChart"), catOptions).render();
</script>
@endsection