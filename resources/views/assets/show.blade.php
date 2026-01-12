@extends('layouts.app')

@section('title', 'Detail Asset')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('assets.index') }}" class="inline-flex items-center text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Detail Asset</h1>
                        <p class="text-gray-600 mt-1">Informasi lengkap aset IT</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('assets.edit', $asset->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aset ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white shadow overflow-hidden border border-gray-200 rounded-lg">
            <!-- Asset Header -->
            <div class="px-6 py-5 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="h-7 w-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-semibold text-gray-900">{{ $asset->asset_code }}</h2>
                        <p class="text-sm text-gray-600">{{ $asset->name }}</p>
                    </div>
                    <div class="ml-auto">
                        @php
                            $badgeClass = match(strtolower($asset->status)) {
                                'active', 'jumps' => 'bg-green-100 text-green-800',
                                'quality control' => 'bg-blue-100 text-blue-800',
                                'pinc', 'broken', 'rusak' => 'bg-red-100 text-red-800',
                                'maintenance', 'perbaikan' => 'bg-yellow-100 text-yellow-800',
                                'phasus engineering' => 'bg-purple-100 text-purple-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $badgeClass }}">
                            {{ strtoupper($asset->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Asset Details -->
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Asset Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Aset</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <dl class="space-y-4">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Kode Asset</dt>
                                        <dd class="text-sm text-gray-900">{{ $asset->asset_code }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Nama Asset</dt>
                                        <dd class="text-sm text-gray-900">{{ $asset->name }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Tipe</dt>
                                        <dd class="text-sm text-gray-900">{{ $asset->type ?? '-' }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Serial Number</dt>
                                        <dd class="text-sm text-gray-900 font-mono">{{ $asset->serial_number }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Location Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Lokasi</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-900">{{ $asset->location }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Lokasi saat ini</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Status & Dates -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Status & Tanggal</h3>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                                <div class="flex justify-between items-center">
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd>
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                            {{ strtoupper($asset->status) }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Pembelian</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->format('d M / Y') : '-' }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Inventory</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $asset->created_at->format('d M / Y') }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Terakhir Diupdate</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $asset->updated_at->format('d M / Y') }}
                                    </dd>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 mb-1">ID Database</dt>
                                        <dd class="text-sm text-gray-900 font-mono">{{ $asset->id }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 mb-1">Dibuat Pada</dt>
                                        <dd class="text-sm text-gray-900">{{ $asset->created_at->format('d F Y, H:i') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 mb-1">Diupdate Pada</dt>
                                        <dd class="text-sm text-gray-900">{{ $asset->updated_at->format('d F Y, H:i') }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('assets.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                        Kembali
                    </a>
                    <a href="{{ route('assets.edit', $asset->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Edit Asset
                    </a>
                </div>
            </div>
        </div>

        <!-- Related Information (Placeholder for future features) -->
        <div class="mt-8">
            <div class="bg-white shadow border border-gray-200 rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Riwayat Maintenance</h3>
                </div>
                <div class="px-6 py-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="mt-2 text-sm">Fitur riwayat maintenance akan tersedia segera</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .font-mono {
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', 'Consolas', monospace;
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