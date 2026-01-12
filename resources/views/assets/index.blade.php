@extends('layouts.app')

@section('title', 'Asset Management')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            
                <div class="flex justify-between items-center mb-4">
                    <a href="{{ route('assets.import.form') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                      📂 Upload / Update CSV
                    </a>
    
                </div>

            
        <div class="mb-6 bg-white shadow-sm rounded-lg p-4">
                <form action="{{ route('assets.index') }}" method="GET">
                    <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Cari nama aset, kode, atau tipe...">
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            
            <div class="bg-white shadow overflow-hidden border border-gray-200 rounded-lg">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200" style="table-layout: fixed; min-width: 1020px;">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 200px;">NAMA ASET</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 150px;">TIPE</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 180px;">SERIAL NUMBER</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 150px;">LOKASI</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 140px;">STATUS</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 120px;">INVENTORY DATE</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 80px;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($assets as $asset)
                                <tr class="hover:bg-gray-50">
                                
                                    <td class="px-4 py-3 whitespace-nowrap overflow-hidden text-ellipsis" style="max-width: 200px;">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-9 w-9 bg-indigo-100 rounded-md flex items-center justify-center">
                                                <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-3 overflow-hidden">
                                                <div class="text-sm font-medium text-gray-900 truncate">{{ $asset->asset_code }}</div>
                                                <div class="text-xs text-gray-500 truncate">{{ $asset->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    
                                    <td class="px-4 py-3 whitespace-nowrap overflow-hidden text-ellipsis" style="max-width: 150px;">
                                        <div class="text-sm text-gray-900 truncate">{{ $asset->type ?? '-' }}</div>
                                    </td>
                                    
                                    
                                    <td class="px-4 py-3 whitespace-nowrap overflow-hidden text-ellipsis" style="max-width: 180px;">
                                        <div class="text-sm text-gray-900 truncate">{{ $asset->serial_number }}</div>
                                    </td>
                                    
                                    
                                    <td class="px-4 py-3 whitespace-nowrap overflow-hidden text-ellipsis" style="max-width: 150px;">
                                        <div class="text-sm text-gray-900 truncate">{{ $asset->location }}</div>
                                    </td>
                                    
                                    
                                    <td class="px-4 py-3 whitespace-nowrap overflow-hidden text-ellipsis" style="max-width: 140px;">
                                        @php
                                            $badgeClass = match(strtolower($asset->status)) {
                                                'jumps', 'active' => 'bg-green-100 text-green-800',
                                                'quality control' => 'bg-blue-100 text-blue-800',
                                                'pinc', 'broken', 'rusak' => 'bg-red-100 text-red-800',
                                                'maintenance', 'perbaikan' => 'bg-yellow-100 text-yellow-800',
                                                'phasus engineering' => 'bg-purple-100 text-purple-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }} truncate">
                                            {{ strtoupper($asset->status) }}
                                        </span>
                                    </td>
                                    
                                
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500" style="max-width: 120px;">
                                        {{ $asset->purchase_date ? $asset->purchase_date->format('d M / Y') : '-' }}
                                    </td>
                                    
                                    
                                    <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium" style="max-width: 80px;">
                                        <a href="{{ route('assets.show', $asset->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                            </svg>
                                            <p class="text-lg font-medium text-gray-900 mb-1">Belum ada data aset</p>
                                            <p class="text-sm text-gray-500">Silakan klik tombol "Tambah Aset" di atas untuk menambahkan data baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                
                @if($assets->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="mb-2 sm:mb-0">
                                <p class="text-sm text-gray-700">
                                    Showing 
                                    <span class="font-medium">{{ $assets->firstItem() }}</span> 
                                    to 
                                    <span class="font-medium">{{ $assets->lastItem() }}</span> 
                                    of 
                                    <span class="font-medium">{{ $assets->total() }}</span> 
                                    results
                                </p>
                            </div>
                            <div class="flex items-center space-x-1">
                                @if($assets->onFirstPage())
                                    <span class="relative inline-flex items-center px-2 py-1.5 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                        Previous
                                    </span>
                                @else
                                    <a href="{{ $assets->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-1.5 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                        Previous
                                    </a>
                                @endif

                                
                                <div class="hidden sm:flex">
                                    @php
                                        $start = max(1, $assets->currentPage() - 2);
                                        $end = min($assets->lastPage(), $assets->currentPage() + 2);
                                        
                                        if ($start > 1) {
                                            echo '<span class="relative inline-flex items-center px-3 py-1.5 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>';
                                        }
                                        
                                        for ($i = $start; $i <= $end; $i++) {
                                            if ($i == $assets->currentPage()) {
                                                echo '<span class="relative inline-flex items-center px-3 py-1.5 border border-indigo-500 bg-indigo-50 text-sm font-medium text-indigo-600 z-10">'.$i.'</span>';
                                            } else {
                                                echo '<a href="'.$assets->url($i).'" class="relative inline-flex items-center px-3 py-1.5 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">'.$i.'</a>';
                                            }
                                        }
                                        
                                        if ($end < $assets->lastPage()) {
                                            echo '<span class="relative inline-flex items-center px-3 py-1.5 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>';
                                        }
                                    @endphp
                                </div>

                                @if($assets->hasMorePages())
                                    <a href="{{ $assets->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-1.5 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        Next
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @else
                                    <span class="relative inline-flex items-center px-2 py-1.5 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                                        Next
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    
    <style>
        @media (min-width: 1024px) {
            table {
                min-width: 1020px !important;
            }
        }
        
        @media (max-width: 1023px) {
            .overflow-x-auto {
                overflow-x: auto;
            }
        }
        
        
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        
        .bg-green-100 { background-color: #d1fae5; }
        .text-green-800 { color: #065f46; }
        .bg-blue-100 { background-color: #dbeafe; }
        .text-blue-800 { color: #1e40af; }
        .bg-red-100 { background-color: #fee2e2; }
        .text-red-800 { color: #991b1b; }
        .bg-yellow-100 { background-color: #fef3c7; }
        .text-yellow-800 { color: #92400e; }
        .bg-purple-100 { background-color: #f3e8ff; }
        .text-purple-800 { color: #5b21b6; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .text-gray-800 { color: #1f2937; }
    </style>
@endsection