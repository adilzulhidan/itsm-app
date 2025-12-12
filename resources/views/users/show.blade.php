@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Detail Pengguna</h1>
                    <p class="text-gray-600 mt-1">Informasi lengkap pengguna sistem</p>
                </div>
                <a href="{{ route('users.index') }}" 
                   class="group flex items-center px-5 py-2.5 bg-white text-gray-700 rounded-xl shadow-sm hover:shadow-md hover:bg-gray-50 transition-all duration-200 border border-gray-200">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Profile Card -->
            <div class="lg:w-2/5">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 hover:shadow-2xl transition-shadow duration-300">
                    <!-- Profile Header -->
                    <div class="relative h-32 bg-gradient-to-r from-blue-500 to-purple-600">
                        <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                            <div class="relative">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" 
                                         class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
                                @else
                                    <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                        <span class="text-4xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-green-500 rounded-full border-4 border-white flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Info -->
                    <div class="pt-20 px-8 pb-8">
                        <div class="text-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-gray-600 mt-1">{{ $user->email }}</p>
                            
                            <div class="mt-4 inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-blue-100 to-blue-50 text-blue-700 border border-blue-200">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                                </svg>
                                <span class="font-semibold capitalize">{{ $user->role }}</span>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="bg-gray-50 rounded-xl p-4 text-center hover:bg-gray-100 transition-colors duration-200">
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $user->created_at->format('d') }}
                                </div>
                                <div class="text-sm text-gray-600">Bergabung</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $user->created_at->format('M Y') }}</div>
                            </div>
                            <div class="bg-green-50 rounded-xl p-4 text-center hover:bg-green-100 transition-colors duration-200">
                                <div class="text-2xl font-bold text-green-700">
                                    <svg class="w-6 h-6 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="text-sm font-semibold text-green-800 mt-1">Status</div>
                                <div class="text-xs text-green-600">Aktif</div>
                            </div>
                        </div>

                        <!-- Edit Button -->
                        <a href="{{ route('users.edit', $user->id) }}" 
                           class="group w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-medium rounded-xl shadow-lg hover:shadow-xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Data Pengguna
                        </a>
                    </div>
                </div>
            </div>

            <!-- Detail Information -->
            <div class="lg:w-3/5">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                    <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Informasi Detail
                        </h2>
                    </div>

                    <div class="p-8">
                        <!-- Detail Items -->
                        <div class="space-y-6">
                            <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 group">
                                <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-lg mr-4 group-hover:scale-110 transition-transform duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm text-gray-500">Departemen</div>
                                    <div class="font-semibold text-gray-900">{{ $user->department ?? 'Belum diatur' }}</div>
                                </div>
                                @if($user->department)
                                    <span class="px-3 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Terisi</span>
                                @else
                                    <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Kosong</span>
                                @endif
                            </div>

                            <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 group">
                                <div class="w-10 h-10 flex items-center justify-center bg-green-100 text-green-600 rounded-lg mr-4 group-hover:scale-110 transition-transform duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm text-gray-500">Bergabung Sejak</div>
                                    <div class="font-semibold text-gray-900">{{ $user->created_at->format('d F Y') }}</div>
                                </div>
                                <div class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                            </div>

                            <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 group">
                                <div class="w-10 h-10 flex items-center justify-center bg-purple-100 text-purple-600 rounded-lg mr-4 group-hover:scale-110 transition-transform duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm text-gray-500">Status Akun</div>
                                    <div class="font-semibold text-green-700 flex items-center">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                        Aktif
                                    </div>
                                </div>
                                <div class="text-xs text-green-600 bg-green-50 px-3 py-1 rounded-full">Verified</div>
                            </div>
                        </div>

                        <!-- Role Description -->
                        <div class="mt-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-100">
                            <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Deskripsi Role
                            </h3>
                            <p class="text-sm text-gray-700">
                                @switch($user->role)
                                    @case('admin')
                                        Administrator memiliki akses penuh ke sistem, dapat mengelola semua pengguna, dan mengatur konfigurasi sistem.
                                        @break
                                    @case('manager')
                                        Manager dapat menyetujui permintaan dari departemennya dan melihat laporan terkait.
                                        @break
                                    @case('it_head')
                                        IT Dept Head bertanggung jawab untuk menyetujui permintaan teknis dan mengelola aset IT.
                                        @break
                                    @default
                                        User biasa dapat membuat permintaan dan melacak status permintaannya.
                                @endswitch
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection