@extends('layouts.app')

@section('title', 'Edit Asset')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('assets.index') }}" class="inline-flex items-center text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Edit Asset</h1>
                        <p class="text-gray-600 mt-1">Edit informasi aset IT</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('assets.show', $asset->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    Batal
                </a>
            </div>
        </div>

        
        <div class="bg-white shadow overflow-hidden border border-gray-200 rounded-lg">
            <form action="{{ route('assets.update', $asset->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="px-6 py-6 space-y-6">
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Aset</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label for="asset_code" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kode Asset <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="asset_code" id="asset_code" 
                                       value="{{ old('asset_code', $asset->asset_code) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       required>
                                @error('asset_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Asset <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" 
                                       value="{{ old('name', $asset->name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tipe
                                </label>
                                <select name="type" id="type" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Pilih Tipe</option>
                                    <option value="Desktop" {{ old('type', $asset->type) == 'Desktop' ? 'selected' : '' }}>Desktop</option>
                                    <option value="Notebook" {{ old('type', $asset->type) == 'Notebook' ? 'selected' : '' }}>Notebook</option>
                                    <option value="Server" {{ old('type', $asset->type) == 'Server' ? 'selected' : '' }}>Server</option>
                                    <option value="VMware" {{ old('type', $asset->type) == 'VMware' ? 'selected' : '' }}>VMware</option>
                                    <option value="Rack Mount Chassis" {{ old('type', $asset->type) == 'Rack Mount Chassis' ? 'selected' : '' }}>Rack Mount Chassis</option>
                                    <option value="All in One" {{ old('type', $asset->type) == 'All in One' ? 'selected' : '' }}>All in One</option>
                                </select>
                            </div>

                            
                            <div>
                                <label for="serial_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    Serial Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="serial_number" id="serial_number" 
                                       value="{{ old('serial_number', $asset->serial_number) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       required>
                                @error('serial_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Lokasi & Status</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                    Lokasi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="location" id="location" 
                                       value="{{ old('location', $asset->location) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       required>
                                @error('location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" id="status" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        required>
                                    <option value="">Pilih Status</option>
                                    <option value="ACTIVE" {{ old('status', $asset->status) == 'ACTIVE' ? 'selected' : '' }}>ACTIVE</option>
                                    <option value="JUMPS" {{ old('status', $asset->status) == 'JUMPS' ? 'selected' : '' }}>JUMPS</option>
                                    <option value="Quality Control" {{ old('status', $asset->status) == 'Quality Control' ? 'selected' : '' }}>Quality Control</option>
                                    <option value="PINC" {{ old('status', $asset->status) == 'PINC' ? 'selected' : '' }}>PINC</option>
                                    <option value="Maintenance" {{ old('status', $asset->status) == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="Phasus Engineering" {{ old('status', $asset->status) == 'Phasus Engineering' ? 'selected' : '' }}>Phasus Engineering</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            
                            <div>
                                <label for="purchase_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Pembelian
                                </label>
                                <input type="date" name="purchase_date" id="purchase_date" 
                                       value="{{ old('purchase_date', $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->format('Y-m-d') : '') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>

            
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('assets.show', $asset->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection