@extends('layouts.app')

@section('title', 'User Management : ' . $user->name)

@section('content')
    <div class="min-h-screen bg-gray-900 py-8 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="flex items-center mb-2">
                    <a href="{{ route('users.index') }}" class="text-blue-400 hover:text-blue-300 transition-colors duration-200 mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-gray-100 dark:text-gray-100">Edit User</h1>
                </div>
            </div>

            <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-700 dark:bg-gray-800 dark:border-gray-700">
                <div class="px-8 py-6 bg-gradient-to-r from-yellow-900/30 to-yellow-800/30 border-b border-yellow-800/50 dark:from-yellow-900/30 dark:to-yellow-800/30 dark:border-yellow-800/50">
                    <h2 class="text-xl font-bold text-gray-100 dark:text-gray-100 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-yellow-500 dark:text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Form User Edit
                    </h2>
                </div>

                <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        
                        <div class="space-y-6">
                            <div class="form-group transition-all duration-200">
                                <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Full Name
                                </label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                    class="w-full px-4 py-3 border border-gray-600 bg-gray-700 text-gray-100 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 @error('name') border-red-500 @enderror dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                    required
                                    placeholder="Masukkan nama lengkap">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-400 flex items-center dark:text-red-400">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="form-group transition-all duration-200">
                                <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Email (Login ID)
                                </label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                    class="w-full px-4 py-3 border border-gray-600 bg-gray-700 text-gray-100 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 @error('email') border-red-500 @enderror dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                    required
                                    placeholder="contoh@email.com">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-400 flex items-center dark:text-red-400">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="space-y-6">
                            <div class="form-group transition-all duration-200">
                                <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    Departement
                                </label>
                                <select name="department" 
                                    class="w-full px-4 py-3 border border-gray-600 bg-gray-700 text-gray-100 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 appearance-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                    required>
                                    <option value="" class="bg-gray-700 text-gray-100">-- Choice Departemen --</option>
                                    <option value="IT" class="bg-gray-700 text-gray-100" {{ (old('department', $user->department ?? '') == 'IT') ? 'selected' : '' }}>IT (Information Technology)</option>
                                    <option value="Engineering" class="bg-gray-700 text-gray-100" {{ (old('department', $user->department ?? '') == 'Engineering') ? 'selected' : '' }}>Engineering</option>
                                    <option value="HRGA" class="bg-gray-700 text-gray-100" {{ (old('department', $user->department ?? '') == 'HRGA') ? 'selected' : '' }}>HRGA</option>
                                    <option value="Finance" class="bg-gray-700 text-gray-100" {{ (old('department', $user->department ?? '') == 'Finance & Accounting') ? 'selected' : '' }}>Finance & Accounting</option>
                                    <option value="Purchasing/Exim" class="bg-gray-700 text-gray-100" {{ (old('department', $user->department ?? '') == 'Purchasing/Exim') ? 'selected' : '' }}>Purchasing/Exim</option>
                                    <option value="Sales" class="bg-gray-700 text-gray-100" {{ (old('department', $user->department ?? '') == 'Sales') ? 'selected' : '' }}>Sales</option>
                                    <option value="PPIC" class="bg-gray-700 text-gray-100" {{ (old('department', $user->department ?? '') == 'PPIC') ? 'selected' : '' }}>PPIC</option>
                                    <option value="QC" class="bg-gray-700 text-gray-100" {{ (old('department', $user->department ?? '') == 'QC') ? 'selected' : '' }}>QC</option>
                                </select>
                                <p class="mt-2 text-xs text-gray-400 flex items-center dark:text-gray-400">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                   This field must be filled in so that the approval workflow runs according to the department.
                                </p>
                            </div>

                            <div class="form-group transition-all duration-200">
                                <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    Role
                                </label>
                                <select name="role" 
                                    class="w-full px-4 py-3 border border-gray-600 bg-gray-700 text-gray-100 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 appearance-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 @error('role') border-red-500 @enderror"
                                    required>
                                    <option value="user" class="bg-gray-700 text-gray-100" {{ $user->role == 'user' ? 'selected' : '' }}>User Biasa (Requester)</option>
                                    <option value="manager" class="bg-gray-700 text-gray-100" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager (Function Head)</option>
                                    <option value="it_head" class="bg-gray-700 text-gray-100" {{ $user->role == 'it_head' ? 'selected' : '' }}>IT Dept Head</option>
                                    <option value="admin" class="bg-gray-700 text-gray-100" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator (Super User)</option>
                                </select>
                                @error('role')
                                    <p class="mt-2 text-sm text-red-400 flex items-center dark:text-red-400">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    
                    <div class="mb-8 p-6 bg-blue-900/30 rounded-2xl border border-blue-800/50 transition-all duration-200 hover:bg-blue-800/30 dark:bg-blue-900/30 dark:border-blue-800/50">
                        <div class="flex items-center mb-4">
                            <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <h3 class="font-semibold text-gray-200 dark:text-gray-200">change Password</h3>
                            <span class="ml-2 px-2 py-1 text-xs bg-blue-800 text-blue-200 rounded-full">Opsional</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-6 dark:text-gray-400">leave the column blank if you don't want to change</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-300 mb-2 dark:text-gray-300">New Password</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password"
                                        class="w-full px-4 py-3 border border-gray-600 bg-gray-700 text-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('password') border-red-500 @enderror dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                        placeholder="enter new password">
                                    <button type="button" onclick="togglePassword('password')" 
                                        class="absolute right-3 top-3 text-gray-400 hover:text-gray-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-300 mb-2 dark:text-gray-300">Confirm Password</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="w-full px-4 py-3 border border-gray-600 bg-gray-700 text-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                        placeholder="confirm new password">
                                    <button type="button" onclick="togglePassword('password_confirmation')" 
                                        class="absolute right-3 top-3 text-gray-400 hover:text-gray-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                
                    <div class="flex flex-col sm:flex-row justify-between items-center pt-6 border-t border-gray-700 dark:border-gray-700">
                        <a href="{{ route('users.index') }}" 
                           class="flex items-center px-6 py-3 text-gray-400 hover:text-gray-200 hover:bg-gray-700 rounded-xl transition-all duration-200 mb-4 sm:mb-0 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancel
                        </a>
                        
                        <button type="submit" 
                                class="group relative flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
        }
    </script>

    <style>
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
        
        .form-group:focus-within label {
            color: #f59e0b;
        }
        
        input:focus, select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
        }
        
        /* Dark mode scrollbar styling */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #1f2937;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #4b5563;
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
    </style>
@endsection