@extends('layouts.app')

@section('title', 'Edit Aset: ' . $asset->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center mb-2">
                <a href="{{ route('assets.index') }}" 
                   class="text-blue-600 hover:text-blue-800 transition-colors duration-200 mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Data Aset
                </h1>
            </div>
            <p class="text-gray-600">Memperbarui informasi untuk: <span class="font-semibold text-gray-800">{{ $asset->name }}</span></p>
        </div>

        <!-- Asset Summary Card -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-xl flex items-center justify-center mr-4">
                            @switch($asset->type)
                                @case('Laptop')
                                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    @break
                                @case('PC Desktop')
                                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                    </svg>
                                    @break
                                @default
                                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                    </svg>
                            @endswitch
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">{{ $asset->name }}</h3>
                            <div class="flex items-center flex-wrap gap-2 mt-2">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">{{ $asset->type }}</span>
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">SN: {{ $asset->serial_number }}</span>
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">{{ $asset->asset_code }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        @switch($asset->status)
                            @case('Active')
                                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                    Aktif
                                </span>
                                @break
                            @case('Broken')
                                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                    Rusak
                                </span>
                                @break
                            @case('Repair')
                                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                    Servis
                                </span>
                                @break
                            @default
                                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                                    {{ $asset->status }}
                                </span>
                        @endswitch
                    </div>
                </div>
                
                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-sm text-gray-500">Lokasi</div>
                        <div class="font-medium text-gray-900 mt-1">{{ $asset->location ?? 'Belum diatur' }}</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-sm text-gray-500">Pembelian</div>
                        <div class="font-medium text-gray-900 mt-1">{{ $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->format('d M Y') : '-' }}</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-sm text-gray-500">Pengguna</div>
                        <div class="font-medium text-gray-900 mt-1">{{ $asset->user->name ?? 'Stok IT' }}</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-sm text-gray-500">Update Terakhir</div>
                        <div class="font-medium text-gray-900 mt-1">{{ $asset->updated_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-8 py-6 bg-gradient-to-r from-yellow-50 to-orange-100 border-b border-yellow-200">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Form Edit Aset
                </h2>
            </div>

            <form action="{{ route('assets.update', $asset->id) }}" method="POST" class="p-8" id="editAssetForm">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Informasi Dasar</h3>
                            <p class="text-sm text-gray-600">Perbarui data identifikasi aset</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Device Name -->
                        <div class="form-group transition-all duration-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Nama Perangkat
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" name="name" 
                                   value="{{ old('name', $asset->name) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('name') border-red-500 @enderror"
                                   required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Serial Number -->
                        <div class="form-group transition-all duration-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Serial Number
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" name="serial_number" 
                                   value="{{ old('serial_number', $asset->serial_number) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('serial_number') border-red-500 @enderror"
                                   required>
                            @error('serial_number')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Asset Type -->
                        <div class="form-group transition-all duration-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                Tipe Perangkat
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <select name="type" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white @error('type') border-red-500 @enderror"
                                    required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="Laptop" {{ old('type', $asset->type) == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                                <option value="PC Desktop" {{ old('type', $asset->type) == 'PC Desktop' ? 'selected' : '' }}>PC Desktop</option>
                                <option value="Monitor" {{ old('type', $asset->type) == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                                <option value="Printer" {{ old('type', $asset->type) == 'Printer' ? 'selected' : '' }}>Printer</option>
                                <option value="Server" {{ old('type', $asset->type) == 'Server' ? 'selected' : '' }}>Server</option>
                                <option value="Network" {{ old('type', $asset->type) == 'Network' ? 'selected' : '' }}>Network (Switch/Router)</option>
                                <option value="Scanner" {{ old('type', $asset->type) == 'Scanner' ? 'selected' : '' }}>Scanner Barcode</option>
                                <option value="Peripherals" {{ old('type', $asset->type) == 'Peripherals' ? 'selected' : '' }}>Aksesoris (Mouse/Keyboard)</option>
                            </select>
                            @error('type')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Purchase Date -->
                        <div class="form-group transition-all duration-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tanggal Pembelian
                            </label>
                            <input type="date" name="purchase_date" 
                                   value="{{ old('purchase_date', $asset->purchase_date) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>
                    </div>
                </div>

                <!-- Location & Status -->
                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Lokasi & Status</h3>
                            <p class="text-sm text-gray-600">Update lokasi dan kondisi aset</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Location -->
                        <div class="form-group transition-all duration-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Lokasi Aset
                            </label>
                            <select name="location" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 appearance-none bg-white">
                                <option value="">-- Pilih Lokasi --</option>
                                <option value="HO" {{ old('location', $asset->location) == 'HO' ? 'selected' : '' }}>Head Office (HO)</option>
                                <option value="Plant 1" {{ old('location', $asset->location) == 'Plant 1' ? 'selected' : '' }}>Pabrik 1 (Plant 1)</option>
                                <option value="Plant 2" {{ old('location', $asset->location) == 'Plant 2' ? 'selected' : '' }}>Pabrik 2 (Plant 2)</option>
                                <option value="Gudang IT" {{ old('location', $asset->location) == 'Gudang IT' ? 'selected' : '' }}>Gudang IT</option>
                                <option value="Remote Office" {{ old('location', $asset->location) == 'Remote Office' ? 'selected' : '' }}>Remote Office</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="form-group transition-all duration-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Status Aset
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <select name="status" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 appearance-none bg-white @error('status') border-red-500 @enderror"
                                    required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Active" {{ old('status', $asset->status) == 'Active' ? 'selected' : '' }}>Active (Digunakan)</option>
                                <option value="Backup" {{ old('status', $asset->status) == 'Backup' ? 'selected' : '' }}>Backup (Cadangan)</option>
                                <option value="Broken" {{ old('status', $asset->status) == 'Broken' ? 'selected' : '' }}>Broken (Rusak)</option>
                                <option value="Repair" {{ old('status', $asset->status) == 'Repair' ? 'selected' : '' }}>Under Repair (Sedang Servis)</option>
                                <option value="Disposal" {{ old('status', $asset->status) == 'Disposal' ? 'selected' : '' }}>Disposal (Akan Dibuang)</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- User Assignment -->
                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Penugasan Pengguna</h3>
                            <p class="text-sm text-gray-600">Tentukan atau ubah pengguna aset</p>
                        </div>
                    </div>

                    <div class="form-group transition-all duration-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Diberikan Kepada
                        </label>
                        <select name="assigned_to" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 appearance-none bg-white">
                            <option value="">-- Stok Gudang IT --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_to', $asset->assigned_to) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} 
                                    @if($user->department)
                                        ({{ $user->department }})
                                    @endif
                                    - {{ ucfirst($user->role) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-600">
                                        Kosongkan jika ingin mengembalikan aset ke stok IT. Aset yang tidak ditugaskan akan masuk ke inventaris stok.
                                    </p>
                                    @if($asset->user)
                                        <p class="text-sm text-gray-600 mt-2">
                                            <span class="font-medium">Saat ini:</span> {{ $asset->user->name }} ({{ $asset->user->department ?? 'Tidak ada departemen' }})
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Notes -->
                <div class="mb-8 p-6 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl border border-yellow-100">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L6.346 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <h3 class="font-semibold text-gray-800">Catatan Tambahan</h3>
                    </div>
                    
                    <div class="form-group transition-all duration-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan (Opsional)</label>
                        <textarea name="notes" 
                                rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200"
                                placeholder="Masukkan keterangan tambahan seperti perubahan status, perbaikan, atau informasi lain yang relevan...">{{ old('notes', $asset->notes) }}</textarea>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-between items-center pt-8 border-t border-gray-200">
                    <a href="{{ route('assets.index') }}" 
                       class="group flex items-center px-6 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-all duration-200 mb-4 sm:mb-0">
                        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Daftar
                    </a>
                    
                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('assets.show', $asset->id) }}" 
                           class="group flex items-center px-6 py-3 text-blue-700 border border-blue-200 rounded-xl hover:bg-blue-50 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Lihat Detail
                        </a>
                        
                        <button type="submit" 
                                class="group relative flex items-center px-8 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-medium rounded-xl shadow-lg hover:shadow-xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Form validation and interaction
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('editAssetForm');
        const statusSelect = form.querySelector('select[name="status"]');
        
        // Status change visual feedback
        statusSelect.addEventListener('change', function() {
            const selectedValue = this.value;
            let colorClass = 'bg-gray-100';
            let iconClass = 'text-gray-400';
            
            switch(selectedValue) {
                case 'Active':
                    colorClass = 'bg-green-100 text-green-800';
                    iconClass = 'text-green-600';
                    break;
                case 'Broken':
                case 'Disposal':
                    colorClass = 'bg-red-100 text-red-800';
                    iconClass = 'text-red-600';
                    break;
                case 'Repair':
                    colorClass = 'bg-yellow-100 text-yellow-800';
                    iconClass = 'text-yellow-600';
                    break;
                case 'Backup':
                    colorClass = 'bg-blue-100 text-blue-800';
                    iconClass = 'text-blue-600';
                    break;
            }
            
            // Update visual feedback
            this.style.borderColor = colorClass.includes('green') ? '#10B981' : 
                                   colorClass.includes('red') ? '#EF4444' :
                                   colorClass.includes('yellow') ? '#F59E0B' :
                                   colorClass.includes('blue') ? '#3B82F6' : '#D1D5DB';
        });
        
        // Initialize status color
        if (statusSelect.value) {
            statusSelect.dispatchEvent(new Event('change'));
        }
        
        // Real-time form validation
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            field.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.classList.add('border-red-500');
                    this.classList.remove('border-gray-300');
                } else {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-gray-300');
                }
            });
            
            field.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-gray-300');
                }
            });
        });
        
        // Form submission validation
        form.addEventListener('submit', function(e) {
            let isValid = true;
            let firstInvalidField = null;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                    
                    if (!firstInvalidField) {
                        firstInvalidField = field;
                    }
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                if (firstInvalidField) {
                    firstInvalidField.focus();
                    
                    // Show error message
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'fixed top-4 right-4 bg-red-600 text-white px-6 py-3 rounded-xl shadow-lg z-50 animate-fade-in';
                    errorDiv.innerHTML = `
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>Mohon lengkapi semua field yang wajib diisi</span>
                        </div>
                    `;
                    document.body.appendChild(errorDiv);
                    
                    setTimeout(() => {
                        errorDiv.style.opacity = '0';
                        errorDiv.style.transition = 'opacity 0.5s ease';
                        setTimeout(() => errorDiv.remove(), 500);
                    }, 3000);
                }
            }
        });
        
        // Auto-focus first empty field or first field
        const firstEmptyField = form.querySelector('[required]:invalid');
        if (firstEmptyField) {
            firstEmptyField.focus();
        } else {
            form.querySelector('[required]')?.focus();
        }
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
    
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
    
    .form-group:focus-within label {
        color: #3b82f6;
    }
    
    input:focus, select:focus, textarea:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .hover-lift:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease-in-out;
    }
</style>
@endsection