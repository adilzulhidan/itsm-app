@extends('layouts.app')

@section('title', 'Manajemen Aset IT')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                        </svg>
                        Manajemen Aset IT
                    </h1>
                    <p class="text-gray-600 mt-2">Kelola semua perangkat dan inventaris teknologi perusahaan</p>
                </div>
                <a href="{{ route('assets.create') }}" 
                   class="group flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Aset Baru
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl flex items-center shadow-sm animate-fade-in">
                    <svg class="w-6 h-6 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-medium text-green-800">{{ session('success') }}</p>
                        <p class="text-sm text-green-600">Aset berhasil diperbarui</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Search & Filter Section -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <form action="{{ route('assets.index') }}" method="GET" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Search Input -->
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Aset</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input type="text" name="search" 
                                       value="{{ request('search') }}"
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                       placeholder="Kode, Nama, SN...">
                            </div>
                        </div>

                        <!-- Type Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Perangkat</label>
                            <select name="type" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                <option value="">Semua Tipe</option>
                                <option value="Laptop" {{ request('type') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                                <option value="PC" {{ request('type') == 'PC' ? 'selected' : '' }}>PC Desktop</option>
                                <option value="Monitor" {{ request('type') == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                                <option value="Printer" {{ request('type') == 'Printer' ? 'selected' : '' }}>Printer</option>
                                <option value="Network" {{ request('type') == 'Network' ? 'selected' : '' }}>Network Device</option>
                                <option value="Other" {{ request('type') == 'Other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                <option value="">Semua Status</option>
                                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Aktif</option>
                                <option value="Broken" {{ request('status') == 'Broken' ? 'selected' : '' }}>Rusak</option>
                                <option value="Repair" {{ request('status') == 'Repair' ? 'selected' : '' }}>Servis</option>
                                <option value="Disposal" {{ request('status') == 'Disposal' ? 'selected' : '' }}>Disposal</option>
                            </select>
                        </div>

                        <!-- User Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pengguna</label>
                            <select name="user_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                <option value="">Semua Pengguna</option>
                                <option value="unassigned" {{ request('user_id') == 'unassigned' ? 'selected' : '' }}>Belum Ditugaskan</option>
                                <!-- Add users dynamically if available -->
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between items-center pt-4 border-t border-gray-200">
                        <button type="submit" 
                                class="w-full sm:w-auto flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 mb-4 sm:mb-0">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Terapkan Filter
                        </button>
                        
                        @if(request()->hasAny(['search', 'type', 'status', 'user_id']))
                            <a href="{{ route('assets.index') }}" 
                               class="w-full sm:w-auto flex items-center justify-center px-6 py-3 text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reset Filter
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="mb-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Aset</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $assets->total() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $assets->where('status', 'Active')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Dalam Servis</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $assets->where('status', 'Repair')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Rusak</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $assets->where('status', 'Broken')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop Table View (Hidden on Mobile) -->
        <div class="hidden lg:block mb-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Daftar Aset IT
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Aset</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Perangkat</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($assets as $asset)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-blue-700">{{ $asset->asset_code }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $asset->name }}</div>
                                    <div class="text-sm text-gray-500 mt-1">{{ $asset->location ?? 'Lokasi belum ditentukan' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $asset->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-sm font-mono">{{ $asset->serial_number }}</code>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($asset->user)
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $asset->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $asset->user->department ?? '' }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">-- Stok Gudang --</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($asset->status)
                                        @case('Active')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                                Aktif
                                            </span>
                                            @break
                                        @case('Broken')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                                Rusak
                                            </span>
                                            @break
                                        @case('Repair')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                                Servis
                                            </span>
                                            @break
                                        @default
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                                                Disposal
                                            </span>
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('assets.edit', $asset->id) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition-colors duration-200 p-2 hover:bg-blue-50 rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus aset ini?')"
                                              class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 transition-colors duration-200 p-2 hover:bg-red-50 rounded-lg">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="text-gray-500 text-lg">Belum ada data aset</p>
                                    <p class="text-gray-400 mt-2">Mulai dengan menambahkan aset pertama Anda</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Mobile Card View (Hidden on Desktop) -->
        <div class="lg:hidden mb-8">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 text-lg">Daftar Aset</h3>
                <span class="text-sm text-gray-500">{{ $assets->count() }} dari {{ $assets->total() }} aset</span>
            </div>
            
            @forelse($assets as $asset)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 mb-6 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <!-- Header with Status -->
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">{{ $asset->name }}</h4>
                            <p class="text-blue-700 font-semibold">{{ $asset->asset_code }}</p>
                        </div>
                        @switch($asset->status)
                            @case('Active')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                    Aktif
                                </span>
                                @break
                            @case('Broken')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                    Rusak
                                </span>
                                @break
                            @case('Repair')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                    Servis
                                </span>
                                @break
                            @default
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                                    Disposal
                                </span>
                        @endswitch
                    </div>

                    <!-- Asset Details -->
                    <div class="space-y-4 mb-6">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                            </svg>
                            <span class="font-medium mr-2">Tipe:</span>
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $asset->type }}</span>
                        </div>
                        
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <div class="flex-1">
                                <span class="font-medium mr-2">SN:</span>
                                <code class="bg-gray-100 px-2 py-1 rounded text-sm font-mono">{{ $asset->serial_number }}</code>
                            </div>
                        </div>
                        
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div class="flex-1">
                                <span class="font-medium mr-2">Pengguna:</span>
                                @if($asset->user)
                                    <div class="mt-1 p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $asset->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $asset->user->department ?? '' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">Stok Gudang</span>
                                @endif
                            </div>
                        </div>
                        
                        @if($asset->location)
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div class="flex-1">
                                <span class="font-medium mr-2">Lokasi:</span>
                                <span>{{ $asset->location }}</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between pt-4 border-t border-gray-200">
                        <a href="{{ route('assets.edit', $asset->id) }}" 
                           class="flex-1 mr-2 flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 font-medium rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" 
                              onsubmit="return confirm('Hapus aset ini?')"
                              class="flex-1 ml-2">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                    class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-50 to-red-100 text-red-700 font-medium rounded-xl hover:from-red-100 hover:to-red-200 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-gray-500 text-lg mb-2">Belum ada data aset</p>
                <p class="text-gray-400 mb-6">Mulai dengan menambahkan aset pertama Anda</p>
                <a href="{{ route('assets.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Aset Pertama
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($assets->hasPages())
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
            <div class="flex flex-col sm:flex-row items-center justify-between">
                <div class="mb-4 sm:mb-0">
                    <p class="text-sm text-gray-700">
                        Menampilkan 
                        <span class="font-medium">{{ $assets->firstItem() }}</span>
                        sampai
                        <span class="font-medium">{{ $assets->lastItem() }}</span>
                        dari
                        <span class="font-medium">{{ $assets->total() }}</span>
                        aset
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    {{ $assets->withQueryString()->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
    
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
    
    table th, table td {
        transition: background-color 0.15s ease-in-out;
    }
    
    .hover-lift:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease-in-out;
    }
</style>

<script>
    // Add filter reset confirmation
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide success message after 5 seconds
        const successMessage = document.querySelector('.alert-success');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.opacity = '0';
                successMessage.style.transition = 'opacity 0.5s ease';
                setTimeout(() => successMessage.remove(), 500);
            }, 5000);
        }
        
        // Initialize tooltips
        const tooltips = document.querySelectorAll('[data-tooltip]');
        tooltips.forEach(tooltip => {
            tooltip.addEventListener('mouseenter', function(e) {
                const text = this.getAttribute('data-tooltip');
                const tooltipEl = document.createElement('div');
                tooltipEl.className = 'fixed z-50 px-3 py-2 text-sm text-white bg-gray-900 rounded-lg shadow-lg';
                tooltipEl.textContent = text;
                document.body.appendChild(tooltipEl);
                
                const rect = this.getBoundingClientRect();
                tooltipEl.style.left = rect.left + 'px';
                tooltipEl.style.top = (rect.top - tooltipEl.offsetHeight - 10) + 'px';
                
                this._tooltip = tooltipEl;
            });
            
            tooltip.addEventListener('mouseleave', function() {
                if (this._tooltip) {
                    this._tooltip.remove();
                }
            });
        });
    });
</script>
@endsection