@extends('layouts.app') 

@section('title', 'Daftar Tiket Masuk')

@section('content')

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">Ticket List</h1>
        
        <div class="flex flex-col sm:flex-row gap-4">
            <form action="{{ route('tickets.index') }}" method="GET" class="flex gap-2">
    

    <select name="status" onchange="this.form.submit()" 
            class="bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-2 focus:ring-blue-500">
        <option value="">-- Semua Status --</option>
        <option value="Menunggu Persetujuan Manager" {{ request('status') == 'Menunggu Persetujuan Manager' ? 'selected' : '' }}>Menunggu Manager</option>
        <option value="Menunggu Persetujuan IT Head" {{ request('status') == 'Menunggu Persetujuan IT Head' ? 'selected' : '' }}>Menunggu IT Head</option>
        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
        <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
    </select>

    <button type="submit" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
        <i class="fas fa-search"></i> Cari
    </button>
</form>
            
            <div class="flex gap-2">
                <a href="{{ route('tickets.exportPdf') }}" class="bg-red-600 dark:bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-700 dark:hover:bg-red-800 
                                                                  transition-colors duration-200 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export PDF
                </a>
                
                <a href="{{ route('tickets.create') }}" class="bg-blue-600 dark:bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-700 dark:hover:bg-blue-800 
                                                                transition-colors duration-200 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create New Ticket
                </a>
            </div>
        </div>
    </div>
    
    @if(session('success'))
    <div class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            {{ session('error') }}
        </div>
    </div>
    @endif
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow dark:shadow-gray-900 overflow-x-auto border border-gray-200 dark:border-gray-700">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-sm leading-normal">
                    <th class="py-4 px-6 border-b dark:border-gray-600">Ticket ID</th>
                    <th class="py-4 px-6 border-b dark:border-gray-600">Subject</th>
                    <th class="py-4 px-6 border-b dark:border-gray-600">Category</th>
                    <th class="py-4 px-6 border-b dark:border-gray-600">Status</th>
                    <th class="py-4 px-6 border-b dark:border-gray-600">Date</th>
                    <th class="py-4 px-6 border-b dark:border-gray-600 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 dark:text-gray-300 text-sm">
                @forelse($tickets as $ticket)
                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                    <td class="py-4 px-6">
                        <div class="font-bold text-blue-600 dark:text-blue-400 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                            {{ $ticket->ticket_code }}
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="font-medium text-gray-800 dark:text-gray-200 truncate max-w-xs">
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
                            $categoryColor = $categoryColors[strtolower($ticket->category)] ?? 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $categoryColor }}">
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
                            ];
                            $statusClass = $statusConfig[strtolower($ticket->status)] ?? 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col">
                            <span class="font-medium">{{ $ticket->created_at->format('d M Y') }}</span>
                            <span class="text-xs">{{ $ticket->created_at->format('H:i') }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <a href="{{ route('tickets.show', $ticket->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 
                                  hover:bg-blue-100 dark:hover:bg-blue-900/40 rounded-lg font-medium 
                                  transition-colors duration-200 border border-blue-100 dark:border-blue-800">
                            <span>Detail</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8">
                        <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-1">Belum ada tiket</p>
                            <p class="text-sm">Mulai dengan membuat tiket baru</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tickets->count() > 0)
    <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-600 dark:text-gray-400">
        <div class="mb-2 sm:mb-0">
            Showing {{ $tickets->firstItem() }} to {{ $tickets->lastItem() }} of {{ $tickets->total() }} results
        </div>
        <div class="mt-4">
            {{ $tickets->withQueryString()->links() }}
        </div>
    </div>
    @endif

@endsection

@push('styles')
<style>
    /* Custom pagination for dark mode */
    .dark .pagination .page-link {
        background-color: #374151;
        border-color: #4B5563;
        color: #D1D5DB;
    }
    
    .dark .pagination .page-link:hover {
        background-color: #4B5563;
    }
    
    .dark .pagination .active .page-link {
        background-color: #3B82F6;
        border-color: #3B82F6;
        color: white;
    }
    
    .dark .pagination .disabled .page-link {
        background-color: #1F2937;
        color: #6B7280;
    }
</style>
@endpush