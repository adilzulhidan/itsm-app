@extends('layouts.app') 

@section('title', 'Daftar Tiket Masuk')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Tiket</h1>
        
        <form action="{{ route('tickets.index') }}" method="GET" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" 
                class="border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Cari Kode / Subjek...">
            <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800">
                Cari
            </button>
        </form>
        <div class="flex gap-2">
            <a href="{{ route('tickets.exportPdf') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 flex items-center gap-2">
                📄 Export PDF
            </a>
            
            <a href="{{ route('tickets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Buat Tiket Baru
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                    <th class="py-3 px-6">ID Tiket</th>
                    <th class="py-3 px-6">Subjek</th>
                    <th class="py-3 px-6">Kategori</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6">Tanggal</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($tickets as $ticket)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6 font-bold text-blue-600">{{ $ticket->ticket_code }}</td>
                    <td class="py-3 px-6">{{ $ticket->subject }}</td>
                    <td class="py-3 px-6">
                        <span class="bg-purple-100 text-purple-700 py-1 px-3 rounded-full text-xs">
                            {{ ucfirst($ticket->category) }}
                        </span>
                    </td>
                    <td class="py-3 px-6">
                        @if($ticket->status == 'open')
                            <span class="bg-green-100 text-green-700 py-1 px-3 rounded-full text-xs">Open</span>
                        @else
                            <span class="bg-gray-100 text-gray-700 py-1 px-3 rounded-full text-xs">{{ $ticket->status }}</span>
                        @endif
                    </td>
                    <td class="py-3 px-6">{{ $ticket->created_at->format('d M Y, H:i') }}</td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-500 hover:text-blue-700 font-bold">Detail &rarr;</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">Belum ada tiket.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tickets->withQueryString()->links() }}
    </div>

@endsection