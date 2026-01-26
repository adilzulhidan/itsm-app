@extends('layouts.app')

@section('title', 'User Management')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">System User List</h1>
        <a href="{{ route('users.create') }}" class="bg-green-600 dark:bg-green-700 text-white px-4 py-2 rounded hover:bg-green-700 dark:hover:bg-green-800 transition-colors duration-200">
            + create new user
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow dark:shadow-gray-900 overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 border-b dark:border-gray-600">ID</th>
                    <th class="py-3 px-6 border-b dark:border-gray-600">Username</th>
                    <th class="py-3 px-6 border-b dark:border-gray-600">Email</th>
                    <th class="py-3 px-6 border-b dark:border-gray-600">Role</th>
                    <th class="py-3 px-6 border-b dark:border-gray-600 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 dark:text-gray-300 text-sm">
                @foreach($users as $user)
                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                    <td class="py-3 px-6">{{ $user->id }}</td>
                    <td class="py-3 px-6 font-bold text-gray-800 dark:text-gray-200">{{ $user->name }}</td>
                    <td class="py-3 px-6">{{ $user->email }}</td>
                    <td class="py-3 px-6">
                        @php
                            $roleColors = [
                                'admin' => 'bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300',
                                'it_head' => 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300',
                                'user' => 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300',
                                'staff' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300',
                            ];
                            $roleColor = $roleColors[$user->role] ?? 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                        @endphp
                        <span class="{{ $roleColor }} py-1 px-3 rounded-full text-xs font-semibold">
                            {{ strtoupper($user->role) }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('users.show', $user->id) }}" class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Info
                            </a>
                            <a href="{{ route('users.edit', $user->id) }}" class="bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Edit
                            </a>
                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $users->links('pagination::tailwind') }}
    </div>

@endsection

@push('styles')
<style>
    /* Custom pagination styles for dark mode */
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
    }
    
    .dark .pagination .disabled .page-link {
        background-color: #1F2937;
        color: #6B7280;
    }
</style>
@endpush