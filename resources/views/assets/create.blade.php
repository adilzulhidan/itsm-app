@extends('layouts.app')

@section('title', 'Registrasi Aset Baru')

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
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Registrasi Aset Baru
                </h1>
            </div>
            <p class="text-gray-600">Tambahkan aset IT baru ke dalam inventaris perusahaan</p>
        </div>

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center mr-3">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Informasi Aset</div>
                                <div class="text-xs text-gray-500">Langkah 1 dari 3</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center mr-3">
                                <span class="text-sm font-medium">2</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Spesifikasi</div>
                                <div class="text-xs text-gray-400">Langkah 2</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center mr-3">
                                <span class="text-sm font-medium">3</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Konfigurasi</div>
                                <div class="text-xs text-gray-400">Langkah 3</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-8 py-6 bg-gradient-to-r from-blue-50 to-indigo-100 border-b border-blue-200">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                    </svg>
                    Form Pendaftaran Aset IT
                </h2>
            </div>

            <form action="{{ route('assets.store') }}" method="POST" class="p-8" id="assetForm" enctype="multipart/form-data">
                @csrf

                <!-- Device Information -->
                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Informasi Perangkat</h3>
                            <p class="text-sm text-gray-600">Data dasar dan identifikasi perangkat</p>
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
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('name') border-red-500 @enderror"
                                   placeholder="Contoh: Laptop ThinkPad X1 Carbon Gen 10"
                                   required
                                   value="{{ old('name') }}">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Device Type -->
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
                                <option value="">-- Pilih Tipe Perangkat --</option>
                                <option value="Laptop" {{ old('type') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                                <option value="PC Desktop" {{ old('type') == 'PC Desktop' ? 'selected' : '' }}>PC Desktop</option>
                                <option value="Monitor" {{ old('type') == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                                <option value="Printer" {{ old('type') == 'Printer' ? 'selected' : '' }}>Printer</option>
                                <option value="Server" {{ old('type') == 'Server' ? 'selected' : '' }}>Server</option>
                                <option value="Network" {{ old('type') == 'Network' ? 'selected' : '' }}>Network (Switch/Router)</option>
                                <option value="Scanner" {{ old('type') == 'Scanner' ? 'selected' : '' }}>Scanner Barcode</option>
                                <option value="Peripherals" {{ old('type') == 'Peripherals' ? 'selected' : '' }}>Aksesoris (Mouse/Keyboard)</option>
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

                        <!-- Serial Number -->
                        <div class="form-group transition-all duration-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Serial Number (SN)
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="serial_number" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('serial_number') border-red-500 @enderror"
                                       placeholder="Contoh: MJCT2LL/A"
                                       required
                                       value="{{ old('serial_number') }}">
                                <button type="button" onclick="generateAssetCode()" 
                                        class="absolute right-3 top-3 text-blue-600 hover:text-blue-800 transition-colors duration-200 text-sm font-medium">
                                    Generate Code
                                </button>
                            </div>
                            @error('serial_number')
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
                            <div class="relative">
                                <input type="date" name="purchase_date" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('purchase_date') border-red-500 @enderror"
                                       value="{{ old('purchase_date') }}">
                                <div class="absolute right-3 top-3 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            @error('purchase_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Asset Configuration -->
                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Konfigurasi Aset</h3>
                            <p class="text-sm text-gray-600">Lokasi dan status penggunaan</p>
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
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 appearance-none bg-white">
                                <option value="">-- Pilih Lokasi --</option>
                                <option value="HO" {{ old('location') == 'HO' ? 'selected' : '' }}>Head Office (HO)</option>
                                <option value="Plant 1" {{ old('location') == 'Plant 1' ? 'selected' : '' }}>Pabrik 1 (Plant 1)</option>
                                <option value="Plant 2" {{ old('location') == 'Plant 2' ? 'selected' : '' }}>Pabrik 2 (Plant 2)</option>
                                <option value="Gudang IT" {{ old('location') == 'Gudang IT' ? 'selected' : '' }}>Gudang IT</option>
                                <option value="Remote Office" {{ old('location') == 'Remote Office' ? 'selected' : '' }}>Remote Office</option>
                            </select>
                            @error('location')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                            <div class="space-y-2">
                                <select name="status" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 appearance-none bg-white @error('status') border-red-500 @enderror"
                                        required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active (Digunakan)</option>
                                    <option value="Backup" {{ old('status') == 'Backup' ? 'selected' : '' }}>Backup (Cadangan)</option>
                                    <option value="Broken" {{ old('status') == 'Broken' ? 'selected' : '' }}>Broken (Rusak)</option>
                                    <option value="Repair" {{ old('status') == 'Repair' ? 'selected' : '' }}>Under Repair (Sedang Servis)</option>
                                    <option value="Disposal" {{ old('status') == 'Disposal' ? 'selected' : '' }}>Disposal (Akan Dibuang)</option>
                                </select>
                                <div class="flex items-center space-x-2 text-xs text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Status menentukan kelayakan penggunaan aset</span>
                                </div>
                            </div>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Assignment Section -->
                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Penugasan Pengguna</h3>
                            <p class="text-sm text-gray-600">Tentukan siapa yang akan menggunakan aset ini</p>
                        </div>
                    </div>

                    <div class="form-group transition-all duration-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Diberikan Kepada
                            <span class="ml-2 px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Opsional</span>
                        </label>
                        <select name="assigned_to" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 appearance-none bg-white">
                            <option value="">-- Tidak Ada / Stok IT --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
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
                                        Kosongkan jika aset ini akan disimpan di stok IT atau belum ditugaskan ke pengguna tertentu.
                                        Aset yang tidak ditugaskan akan masuk ke inventaris stok.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Notes (Optional) -->
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
                                placeholder="Masukkan keterangan tambahan seperti spesifikasi teknis, kondisi fisik, atau informasi lain yang relevan...">{{ old('notes') }}</textarea>
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
                        <button type="reset" 
                                class="group flex items-center px-6 py-3 text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reset Form
                        </button>
                        
                        <button type="submit" 
                                class="group relative flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Simpan Aset
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
        const form = document.getElementById('assetForm');
        const typeSelect = form.querySelector('select[name="type"]');
        const statusSelect = form.querySelector('select[name="status"]');
        
        // Auto-generate asset code based on type and timestamp
        function generateAssetCode() {
            const type = typeSelect.value;
            const date = new Date();
            const year = date.getFullYear().toString().slice(-2);
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
            
            let prefix = 'IT';
            if (type) {
                switch(type) {
                    case 'Laptop': prefix = 'LAP'; break;
                    case 'PC Desktop': prefix = 'PC'; break;
                    case 'Monitor': prefix = 'MON'; break;
                    case 'Printer': prefix = 'PRT'; break;
                    case 'Server': prefix = 'SRV'; break;
                    case 'Network': prefix = 'NET'; break;
                    case 'Scanner': prefix = 'SCN'; break;
                    case 'Peripherals': prefix = 'ACC'; break;
                }
            }
            
            const assetCode = `${prefix}${year}${month}${random}`;
            
            // Show generated code in alert (in real app, this would populate a field)
            alert(`Generated Asset Code: ${assetCode}\n\nNote: This is just a preview. The actual asset code will be generated server-side upon saving.`);
        }
        
        // Attach event listener to generate button
        const generateBtn = form.querySelector('button[onclick="generateAssetCode()"]');
        if (generateBtn) {
            generateBtn.addEventListener('click', generateAssetCode);
        }
        
        // Form validation feedback
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
        
        // Status selection visual feedback
        statusSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const statusValue = selectedOption.value;
            const statusText = selectedOption.textContent;
            
            // You could add visual feedback here if needed
            console.log(`Status changed to: ${statusText}`);
        });
        
        // Real-time form validation
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
    
    input[type="date"]::-webkit-calendar-picker-indicator {
        opacity: 0;
        cursor: pointer;
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
    }
    
    .hover-lift:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease-in-out;
    }
</style>
@endsection