@extends('layouts.app')

@section('title', 'Detail Aset: ' . $asset->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header with Actions -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div class="flex items-center">
                    <a href="{{ route('assets.index') }}" 
                       class="text-blue-600 hover:text-blue-800 transition-colors duration-200 mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Detail Aset</h1>
                        <div class="flex items-center mt-1">
                            <span class="text-gray-600">ID: </span>
                            <span class="ml-2 font-mono font-bold text-blue-700">{{ $asset->asset_code }}</span>
                            <span class="mx-2 text-gray-400">•</span>
                            <span class="text-gray-600">Terdaftar: {{ $asset->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    @switch($asset->status)
                        @case('Active')
                            <span class="px-4 py-2 inline-flex items-center text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Active
                            </span>
                            @break
                        @case('Broken')
                            <span class="px-4 py-2 inline-flex items-center text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                Rusak
                            </span>
                            @break
                        @case('Repair')
                            <span class="px-4 py-2 inline-flex items-center text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                Servis
                            </span>
                            @break
                        @default
                            <span class="px-4 py-2 inline-flex items-center text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                                {{ $asset->status }}
                            </span>
                    @endswitch
                    
                    <div class="relative group">
                        <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="{{ route('assets.edit', $asset->id) }}" 
                               class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50 transition-colors duration-150">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Aset
                            </a>
                            <a href="#" 
                               class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50 transition-colors duration-150">
                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Cetak Label
                            </a>
                            <a href="#" 
                               class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50 transition-colors duration-150">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Riwayat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Asset Overview -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Asset Header Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                    <div class="p-8">
                        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                            <div class="relative">
                                <div class="w-32 h-32 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    @switch($asset->type)
                                        @case('Laptop')
                                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            @break
                                        @case('PC Desktop')
                                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                            </svg>
                                            @break
                                        @case('Monitor')
                                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                                            </svg>
                                            @break
                                        @case('Printer')
                                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                            </svg>
                                            @break
                                        @case('Server')
                                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                            </svg>
                                            @break
                                        @default
                                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                    @endswitch
                                </div>
                                <div class="absolute -top-2 -right-2 w-10 h-10 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-full border-4 border-white flex items-center justify-center shadow-lg">
                                    <span class="text-white font-bold text-sm">{{ substr($asset->type, 0, 2) }}</span>
                                </div>
                            </div>
                            
                            <div class="flex-1 text-center md:text-left">
                                <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $asset->name }}</h2>
                                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-4">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">{{ $asset->type }}</span>
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                        </svg>
                                        <span class="font-mono text-sm">{{ $asset->asset_code }}</span>
                                    </div>
                                </div>
                                <p class="text-gray-600">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    Serial: <span class="font-mono font-bold text-gray-800">{{ $asset->serial_number }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specification & Details Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Specification Card -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">Spesifikasi Teknis</h3>
                                    <p class="text-sm text-gray-600">Detail perangkat</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                        <span class="text-gray-600">Tipe Perangkat</span>
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $asset->type }}</span>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        <span class="text-gray-600">Serial Number</span>
                                    </div>
                                    <span class="font-mono font-semibold text-gray-900">{{ $asset->serial_number }}</span>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-gray-600">Tanggal Pembelian</span>
                                    </div>
                                    <span class="font-semibold text-gray-900">
                                        {{ $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->format('d M Y') : 'Tidak tersedia' }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-gray-600">Update Terakhir</span>
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $asset->updated_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location & Assignment Card -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">Lokasi & Penugasan</h3>
                                    <p class="text-sm text-gray-600">Informasi penggunaan</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span class="text-gray-600">Lokasi Saat Ini</span>
                                    </div>
                                    <span class="font-semibold text-gray-900 text-lg">{{ $asset->location ?? 'Belum ditentukan' }}</span>
                                </div>
                                
                                @if($asset->user)
                                <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                    <div class="flex items-center mb-3">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span class="text-gray-600">Dipegang Oleh</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4">
                                            <span class="text-white font-bold text-lg">{{ substr($asset->user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">{{ $asset->user->name }}</div>
                                            <div class="text-sm text-gray-600 flex items-center mt-1">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                {{ $asset->user->department ?? 'Tidak ada departemen' }}
                                            </div>
                                            <div class="text-sm text-gray-600 flex items-center mt-1">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $asset->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                    <div class="flex items-center mb-3">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <span class="text-gray-600">Status Penyimpanan</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br from-gray-400 to-gray-500 rounded-xl flex items-center justify-center mr-4">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">Stok Gudang IT</div>
                                            <div class="text-sm text-gray-600">Aset tersedia untuk penugasan</div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Section (if exists) -->
                @if($asset->notes)
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl shadow-lg border border-yellow-200">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <svg class="w-6 h-6 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L6.346 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <h3 class="font-bold text-gray-900">Catatan Khusus</h3>
                        </div>
                        <div class="bg-white/50 rounded-xl p-4 border border-yellow-100">
                            <p class="text-gray-700">{{ $asset->notes }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Actions & History -->
            <div class="space-y-8">
                <!-- Status Timeline -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
                    <div class="p-6">
                        <h3 class="font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Timeline Status
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">Registrasi Aset</div>
                                    <div class="text-sm text-gray-600">{{ $asset->created_at->format('d M Y H:i') }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Aset terdaftar ke sistem</div>
                                </div>
                            </div>
                            
                            @if($asset->purchase_date)
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">Pembelian</div>
                                    <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($asset->purchase_date)->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Tanggal akuisisi perangkat</div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">Update Terakhir</div>
                                    <div class="text-sm text-gray-600">{{ $asset->updated_at->format('d M Y H:i') }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Perubahan terakhir data aset</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
                    <div class="p-6">
                        <h3 class="font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Aksi Cepat
                        </h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('assets.edit', $asset->id) }}" 
                               class="group flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-200">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-200 transition-colors duration-200">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Edit Aset</div>
                                        <div class="text-sm text-gray-600">Perbarui informasi</div>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            
                            <a href="#" 
                               class="group flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-200">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-200 transition-colors duration-200">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Cetak Label</div>
                                        <div class="text-sm text-gray-600">QR/Barcode sticker</div>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            
                            <a href="#" 
                               class="group flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-200 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-200">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-purple-200 transition-colors duration-200">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Riwayat Service</div>
                                        <div class="text-sm text-gray-600">Log perbaikan</div>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Asset Health -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-lg border border-blue-200">
                    <div class="p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Kesehatan Aset</h3>
                        
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Kondisi Fisik</span>
                                <span class="text-sm font-semibold text-green-600">90%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 90%"></div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Usia Pakai</span>
                                <span class="text-sm font-semibold text-yellow-600">65%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: 65%"></div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Garansi</span>
                                <span class="text-sm font-semibold text-blue-600">30%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 30%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Action Bar -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row justify-between items-center">
                <div class="mb-4 sm:mb-0">
                    <p class="text-sm text-gray-600">
                        Aset terakhir diperbarui {{ $asset->updated_at->diffForHumans() }}
                    </p>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('assets.index') }}" 
                       class="group flex items-center px-6 py-3 text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Daftar
                    </a>
                    
                    <a href="{{ route('assets.edit', $asset->id) }}" 
                       class="group flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-medium rounded-xl shadow-lg hover:shadow-xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Aset Ini
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Add interactive features
    document.addEventListener('DOMContentLoaded', function() {
        // Copy serial number on click
        const serialNumber = document.querySelector('span.font-mono');
        if (serialNumber) {
            serialNumber.addEventListener('click', function() {
                const text = this.textContent;
                navigator.clipboard.writeText(text).then(() => {
                    // Show copied notification
                    const notification = document.createElement('div');
                    notification.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
                    notification.innerHTML = `
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Serial number copied!
                        </div>
                    `;
                    document.body.appendChild(notification);
                    
                    setTimeout(() => {
                        notification.style.opacity = '0';
                        notification.style.transition = 'opacity 0.5s ease';
                        setTimeout(() => notification.remove(), 500);
                    }, 2000);
                });
            });
            
            // Add tooltip
            serialNumber.title = 'Click to copy serial number';
            serialNumber.style.cursor = 'pointer';
        }
        
        // Status timeline animation
        const timelineItems = document.querySelectorAll('.flex.items-start');
        timelineItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-20px)';
            
            setTimeout(() => {
                item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, 100 * (index + 1));
        });
        
        // Progress bar animation
        const progressBars = document.querySelectorAll('.bg-green-500, .bg-yellow-500, .bg-blue-500');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            
            setTimeout(() => {
                bar.style.transition = 'width 1s ease-in-out';
                bar.style.width = width;
            }, 500);
        });
    });
</script>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
    
    .hover-lift:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease-in-out;
    }
    
    .group:hover .group-hover\:scale-110 {
        transform: scale(1.1);
    }
</style>
@endsection