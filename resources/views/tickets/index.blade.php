@extends('layouts.app')

@section('title', 'Daftar Tiket Masuk')

@section('content')
<div class="space-y-6">
    {{-- Header dengan Statistik --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">Daftar Tiket</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kelola dan pantau semua ticket support</p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3">
            {{-- Form Pencarian --}}
            <form action="{{ route('tickets.index') }}" method="GET" class="flex">
                <div class="relative flex-grow">
                    <select name="status" onchange="this.form.submit()" 
                            class="appearance-none bg-gray-800 text-white border border-gray-700 rounded-l-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Persetujuan Manager" {{ request('status') == 'Menunggu Persetujuan Manager' ? 'selected' : '' }}>Menunggu Manager</option>
                        <option value="Menunggu Persetujuan IT Head" {{ request('status') == 'Menunggu Persetujuan IT Head' ? 'selected' : '' }}>Menunggu IT Head</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
                <button type="submit" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-r-lg flex items-center gap-2 transition-colors">
                    <i class="fas fa-search"></i>
                    <span class="hidden sm:inline">Cari</span>
                </button>
            </form>
            
            {{-- Tombol Action --}}
            <div class="flex gap-2">
                <a href="{{ route('tickets.exportPdf') }}" 
                   class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-2 shadow-sm hover:shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="hidden sm:inline">Export PDF</span>
                </a>
                
                <a href="{{ route('tickets.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-2 shadow-sm hover:shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden sm:inline">Buat Tiket</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Tiket</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $tickets->total() }}</p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Open</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $tickets->where('status', 'open')->count() }}</p>
                </div>
                <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">In Progress</p>
                    <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $tickets->where('status', 'In Progress')->count() }}</p>
                </div>
                <div class="bg-yellow-100 dark:bg-yellow-900/30 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Resolved</p>
                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $tickets->where('status', 'resolved')->count() }}</p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Notifikasi --}}
    @if(session('success'))
    <div class="bg-green-100 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg shadow-sm" role="alert">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg shadow-sm" role="alert">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    </div>
    @endif
    
    {{-- Tabel Tiket --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 text-gray-600 dark:text-gray-300 text-sm font-semibold uppercase tracking-wider">
                        <th class="py-4 px-6">Ticket ID</th>
                        <th class="py-4 px-6">Subject</th>
                        <th class="py-4 px-6">Category</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6">Date</th>
                        <th class="py-4 px-6 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                    </svg>
                                </div>
                                <span class="font-mono font-bold text-blue-600 dark:text-blue-400">{{ $ticket->ticket_code }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-medium text-gray-900 dark:text-gray-100 max-w-xs truncate">
                                {{ $ticket->subject }}
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $categoryColors = [
                                    'hardware' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300',
                                    'software' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
                                    'network' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300',
                                    'other' => 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300',
                                ];
                                $categoryIcons = [
                                    'hardware' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z',
                                    'software' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
                                    'network' => 'M8 9l3-3 3 3m0 6l-3 3-3-3M3 12h18',
                                    'other' => 'M4 6h16M4 10h16M4 14h16M4 18h16',
                                ];
                                $categoryColor = $categoryColors[strtolower($ticket->category)] ?? 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                                $categoryIcon = $categoryIcons[strtolower($ticket->category)] ?? $categoryIcons['other'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium {{ $categoryColor }}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $categoryIcon }}"></path>
                                </svg>
                                {{ ucfirst($ticket->category) }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $statusConfig = [
                                    'open' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-800',
                                    'in_progress' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-800',
                                    'resolved' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800',
                                    'closed' => 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600',
                                    'rejected' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800',
                                    'menunggu persetujuan manager' => 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 border border-orange-200 dark:border-orange-800',
                                    'menunggu persetujuan it head' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800',
                                ];
                                
                                $statusKey = strtolower(str_replace(' ', '_', $ticket->status));
                                $statusDisplay = str_replace('_', ' ', $ticket->status);
                                
                                if (strtolower($ticket->status) == 'menunggu persetujuan manager') {
                                    $statusKey = 'menunggu persetujuan manager';
                                    $statusDisplay = 'Menunggu Manager';
                                } elseif (strtolower($ticket->status) == 'menunggu persetujuan it head') {
                                    $statusKey = 'menunggu persetujuan it head';
                                    $statusDisplay = 'Menunggu IT Head';
                                }
                                
                                $statusClass = $statusConfig[$statusKey] ?? 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium {{ $statusClass }}">
                                {{ ucfirst($statusDisplay) }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-col">
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $ticket->created_at->format('d M Y') }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $ticket->created_at->format('H:i') }} WIB</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('tickets.show', $ticket->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-lg font-medium transition-all duration-200 border border-blue-200 dark:border-blue-800 group">
                                <span>Detail</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12">
                            <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-full mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-1">Belum ada tiket</p>
                                <p class="text-sm mb-4">Mulai dengan membuat tiket baru</p>
                                <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Buat Tiket Baru
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($tickets->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <span class="font-medium text-gray-900 dark:text-gray-200">{{ $tickets->firstItem() }}</span>
                <span>-</span>
                <span class="font-medium text-gray-900 dark:text-gray-200">{{ $tickets->lastItem() }}</span>
                <span>dari</span>
                <span class="font-medium text-gray-900 dark:text-gray-200">{{ $tickets->total() }}</span>
                <span>data</span>
            </div>
            
            <div class="flex items-center space-x-2">
                {{ $tickets->withQueryString()->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Custom scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #666;
    }
    
    .dark .overflow-x-auto::-webkit-scrollbar-track {
        background: #374151;
    }
    
    .dark .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #4B5563;
    }
    
    .dark .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #6B7280;
    }
    
    /* Table row hover effect */
    tbody tr {
        transition: all 0.2s ease;
    }
    
    /* Status badges animation */
    .inline-flex.items-center.px-3.py-1.rounded-lg {
        transition: all 0.2s ease;
    }
    
    .inline-flex.items-center.px-3.py-1.rounded-lg:hover {
        transform: scale(1.05);
    }
    
    /* Gradient text for headings */
    h1 {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .dark h1 {
        background: linear-gradient(135deg, #a8c0ff 0%, #3f2b96 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-hide notifications after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('[role="alert"]');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove();
                }, 500);
            }, 5000);
        });
    });
</script>
@endpush