<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITSM | @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        /* Gaya sidebar yang diperbarui */
        .sidebar-item { 
            color: #e5e7eb; 
            transition: all 0.2s ease;
        }
        .sidebar-item:hover { 
            background-color: rgba(59, 130, 246, 0.1); 
            color: #ffffff;
            transform: translateX(5px);
        }
        .sidebar-item:hover svg { 
            color: #3b82f6 !important; 
        }
        .active-link { 
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.2), transparent);
            color: #ffffff !important; 
            border-left: 4px solid #3b82f6;
            font-weight: 600;
        }
        .active-link svg { 
            color: #3b82f6 !important; 
        }
        .logout-btn { 
            color: #fca5a5; 
            transition: all 0.2s ease;
        } 
        .logout-btn:hover { 
            background-color: rgba(239, 68, 68, 0.2); 
            color: #f87171 !important; 
            transform: translateX(5px);
        }
        .logout-btn:hover svg { 
            color: #f87171 !important; 
        }

        /* Animasi dan transisi */
        .transition-all { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .text-gradient {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Custom scrollbar */
        #sidebar::-webkit-scrollbar {
            width: 4px;
        }
        #sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.5);
            border-radius: 10px;
        }
        #sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.8);
        }

        /* Glass morphism effect */
        .glass-effect {
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex">
    
    <div class="flex min-h-screen w-full">

        <!-- Sidebar dengan glass effect -->
        <div id="sidebar" class="glass-effect w-64 text-white flex flex-col min-h-screen transition-all duration-300 flex-shrink-0 overflow-y-auto">
            
            <!-- Sidebar Header dengan logo -->
            <div id="sidebar-header" class="p-4 border-b border-gray-700/50 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    
                    <div>
                        <h1 id="header-text" class="text-lg font-bold text-white">ITSM</h1>
                        <p class="text-xs text-gray-400">JTEKT Indonesia</p>
                    </div>
                </div>
                
                <button id="sidebarToggle" class="text-gray-400 hover:text-white p-1 rounded-md hover:bg-gray-700/50 transition-colors">
                    <svg id="toggleIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="flex-grow p-3 space-y-1">
                <!-- Admin Tools Section -->
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'it_head')
                    <div class="px-3 py-2">
                        <p class="text-xs uppercase text-gray-400 font-semibold tracking-wider sidebar-text">Admin Tools</p>
                    </div>
                    
                    <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center px-3 py-2.5 rounded-lg mx-2
                        {{ Request::routeIs('dashboard') ? 'active-link' : '' }}">
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                            </svg>
                            <span class="sidebar-text whitespace-nowrap">Dashboard</span>
                        </div>
                    </a>

                    <a href="{{ route('users.index') }}" class="sidebar-item flex items-center px-3 py-2.5 rounded-lg mx-2
                        {{ Request::routeIs('users.*') ? 'active-link' : '' }}">
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span class="sidebar-text whitespace-nowrap">Kelola User</span>
                        </div>
                    </a>

                    <a href="{{ route('assets.index') }}" class="sidebar-item flex items-center px-3 py-2.5 rounded-lg mx-2
                        {{ request()->is('assets*') ? 'active-link' : '' }}">
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                <line x1="12" y1="17" x2="12" y2="21"></line>
                            </svg>
                            <span class="sidebar-text whitespace-nowrap">Asset Management</span>
                        </div>
                    </a>
                @endif
                
                <!-- Request & Tracking Section -->
                <div class="px-3 py-2 mt-4">
                    <p class="text-xs uppercase text-gray-400 font-semibold tracking-wider sidebar-text">Request & Tracking</p>
                </div>

                <a href="{{ route('tickets.index') }}" class="sidebar-item flex items-center px-3 py-2.5 rounded-lg mx-2
                    {{ Request::routeIs('tickets.index') || Request::routeIs('tickets.show') || Request::routeIs('tickets.edit') ? 'active-link' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Daftar Tiket</span>
                    </div>
                </a>

                <a href="{{ route('tickets.create') }}" class="sidebar-item flex items-center px-3 py-2.5 rounded-lg mx-2
                    {{ Request::routeIs('tickets.create') ? 'active-link' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Buat Tiket Baru</span>
                    </div>
                </a>
            </nav>
            
            <!-- User Profile & Logout -->
            <div id="logout-container" class="p-4 mt-auto border-t border-gray-700/50">
                <div class="flex items-center space-x-3 mb-3 px-2">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <span class="text-white text-xs font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate sidebar-text">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate sidebar-text">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                </div>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn flex items-center w-full px-3 py-2.5 rounded-lg text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Keluar</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content Area -->
        <div id="main-content" class="flex-1 flex flex-col min-h-screen">
            
            <!-- Top Navigation Bar -->
            <header class="bg-white border-b border-gray-200 px-6 py-4 shadow-sm sticky top-0 z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <button id="mobileMenuToggle" class="lg:hidden text-gray-600 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800">@yield('title')</h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button id="notificationBtn" class="p-2 text-gray-600 hover:text-blue-600 relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="absolute -top-1 -right-1 h-3 w-3 bg-red-500 rounded-full border border-white"></span>
                            </button>
                        </div>
                        
                        <div class="hidden md:flex items-center space-x-2 bg-gray-50 px-4 py-2 rounded-lg">
                            <i class="bi bi-calendar-check text-blue-600"></i>
                            <span class="text-sm text-gray-600">{{ date('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-6 bg-gray-50 overflow-y-auto">
                <!-- Breadcrumb -->
                <div class="mb-6">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-gray-700 hover:text-blue-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            @if(isset($breadcrumb))
                                <li>
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="ml-1 text-sm font-medium text-gray-700 md:ml-2">{{ $breadcrumb }}</span>
                                    </div>
                                </li>
                            @endif
                        </ol>
                    </nav>
                </div>

                <!-- Page Content -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const toggleButton = document.getElementById('sidebarToggle');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');
        const headerText = document.getElementById('header-text');
        const logoutContainer = document.getElementById('logout-container');
        const mainContent = document.getElementById('main-content');
        
        let isSidebarOpen = true;

        // Toggle sidebar function
        function toggleSidebar() {
            if (isSidebarOpen) {
                // Collapse sidebar
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                
                // Hide text elements
                sidebarTexts.forEach(text => {
                    text.classList.add('opacity-0', 'w-0', 'overflow-hidden', 'invisible');
                });
                
                // Update toggle icon
                toggleButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                `;

                isSidebarOpen = false;
            } else {
                // Expand sidebar
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                
                // Show text elements
                sidebarTexts.forEach(text => {
                    text.classList.remove('opacity-0', 'w-0', 'overflow-hidden', 'invisible');
                });
                
                // Update toggle icon
                toggleButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                `;

                isSidebarOpen = true;
            }
        }

        // Mobile menu toggle
        function toggleMobileMenu() {
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('fixed');
            sidebar.classList.toggle('z-20');
        }

        // Event listeners
        toggleButton.addEventListener('click', toggleSidebar);
        mobileMenuToggle.addEventListener('click', toggleMobileMenu);

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(event) {
            if (window.innerWidth < 1024) {
                if (!sidebar.contains(event.target) && !mobileMenuToggle.contains(event.target)) {
                    sidebar.classList.add('-translate-x-full');
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full', 'fixed', 'z-20');
            }
        });
    });
</script>
</html>