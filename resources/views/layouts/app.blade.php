<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITSM | @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
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

        .transition-all { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        
        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.05); }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(59, 130, 246, 0.5); border-radius: 10px; }
        #sidebar::-webkit-scrollbar-thumb:hover { background: rgba(59, 130, 246, 0.8); }

        .glass-effect {
            background: rgba(30, 41, 59, 0.95); 
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex">
    
    <div class="flex min-h-screen w-full">
    
    <div id="sidebar" class="glass-effect w-64 text-white flex flex-col min-h-screen transition-all duration-300 flex-shrink-0 overflow-y-auto z-20">
            <div id="sidebar-header" class="p-4 border-b border-gray-700/50 flex items-center justify-between sticky top-0 bg-[#1e293b] z-10">
                <div class="flex items-center space-x-3 overflow-hidden">
                    <div>
                        <h1 id="header-text" class="text-lg font-bold text-white whitespace-nowrap transition-opacity duration-300">ITSM</h1>
                        <p id="header-subtext" class="text-xs text-gray-400 whitespace-nowrap transition-opacity duration-300">JTEKT Indonesia</p>
                    </div>
                </div>
                
                <button id="sidebarToggle" class="group flex items-center justify-center w-8 h-8 rounded-lg hover:bg-white/10 transition-colors focus:outline-none">
                    <svg id="toggleIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-hover:text-white transform transition-transform duration-500 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>
            
            <nav class="flex-grow p-3 space-y-1">
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'it_head')
                    <div class="px-3 py-2 menu-label">
                        <p class="text-xs uppercase text-gray-400 font-semibold tracking-wider sidebar-text whitespace-nowrap overflow-hidden">Admin Tools</p>
                    </div>
                    
                    <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center px-3 py-2.5 rounded-lg mx-2 {{ Request::routeIs('dashboard') ? 'active-link' : '' }}">
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect>
                            </svg>
                            <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Dashboard</span>
                        </div>
                    </a>

                    <a href="{{ route('users.index') }}" class="sidebar-item flex items-center px-3 py-2.5 rounded-lg mx-2 {{ Request::routeIs('users.*') ? 'active-link' : '' }}">
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">User Management</span>
                        </div>
                    </a>

                    <a href="{{ route('assets.index') }}" class="sidebar-item flex items-center px-3 py-2.5 rounded-lg mx-2 {{ request()->is('assets*') ? 'active-link' : '' }}">
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line>
                            </svg>
                            <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Asset Management</span>
                        </div>
                    </a>
                @endif
                                
                <div class="px-3 py-2 mt-4 menu-label">
                    <p class="text-xs uppercase text-gray-400 font-semibold tracking-wider sidebar-text whitespace-nowrap overflow-hidden">Request & Tracking</p>
                </div>

                <a href="{{ route('knowledgebase.index') }}" class="sidebar-item flex items-center px-3 py-2.5 rounded-lg mx-2 {{ Request::routeIs('knowledgebase.*') ? 'active-link' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        </svg>
                        <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Knowledge Base</span>
                    </div>
                </a>

                <a href="{{ route('tickets.index') }}" class="sidebar-item flex items-center px-3 py-2.5 rounded-lg mx-2 {{ Request::routeIs('tickets.index') || Request::routeIs('tickets.show') || Request::routeIs('tickets.edit') ? 'active-link' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Ticket List</span>
                    </div>
                </a>

                <a href="{{ route('tickets.create') }}" class="sidebar-item flex items-center px-3 py-2.5 rounded-lg mx-2 {{ Request::routeIs('tickets.create') ? 'active-link' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                        <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Create New Ticket</span>
                    </div>
                </a>
            </nav>
            
        
            <div id="logout-container" class="p-4 mt-auto border-t border-gray-700/50">
                <div class="flex items-center space-x-3 mb-3 px-2 overflow-hidden">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <span class="text-white text-xs font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0 transition-opacity duration-300 sidebar-text">
                        <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                </div>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn flex items-center w-full px-3 py-2.5 rounded-lg text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Log Out</span>
                    </button>
                </form>
            </div>
        </div>

        <div id="main-content" class="flex-1 flex flex-col min-h-screen transition-all duration-300">
            
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

            <main class="flex-1 p-6 bg-gray-50 overflow-y-auto">
                <div class="mb-6">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
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
        const toggleIcon = document.getElementById('toggleIcon'); 
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        
    
        const sidebarTexts = document.querySelectorAll('.sidebar-text');
        const headerText = document.getElementById('header-text');
        const headerSubText = document.getElementById('header-subtext');
        const menuLabels = document.querySelectorAll('.menu-label'); 
        
        let isSidebarOpen = true;

        function toggleSidebar() {
            if (isSidebarOpen) {
            
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                
                
                sidebarTexts.forEach(text => {
                    text.classList.add('opacity-0', 'w-0', 'translate-x-[-10px]');
                    setTimeout(() => text.classList.add('hidden'), 200); 
                });

            
                headerText.classList.add('opacity-0', 'w-0', 'hidden');
                headerSubText.classList.add('opacity-0', 'w-0', 'hidden');

    
                menuLabels.forEach(label => label.classList.add('hidden'));
                
                
                toggleIcon.classList.add('rotate-180');

                isSidebarOpen = false;
            } else {
        
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                
                
                sidebarTexts.forEach(text => {
                    text.classList.remove('hidden');
                    
                    setTimeout(() => text.classList.remove('opacity-0', 'w-0', 'translate-x-[-10px]'), 50);
                });

                
                headerText.classList.remove('hidden', 'opacity-0', 'w-0');
                headerSubText.classList.remove('hidden', 'opacity-0', 'w-0');

            
                menuLabels.forEach(label => label.classList.remove('hidden'));

                
                toggleIcon.classList.remove('rotate-180');

                isSidebarOpen = true;
            }
        }

        function toggleMobileMenu() {
            
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('fixed');
            sidebar.classList.toggle('z-50'); 
        }

        toggleButton.addEventListener('click', toggleSidebar);
        mobileMenuToggle.addEventListener('click', toggleMobileMenu);

        
        document.addEventListener('click', function(event) {
            if (window.innerWidth < 1024) {
                if (!sidebar.contains(event.target) && !mobileMenuToggle.contains(event.target)) {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('fixed', 'z-50');
                }
            }
        });

        
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full', 'fixed', 'z-50');
                
                if(isSidebarOpen) {
                    sidebar.classList.add('w-64');
                    sidebar.classList.remove('w-20');
                } else {
                    sidebar.classList.add('w-20');
                    sidebar.classList.remove('w-64');
                }
            }
        });
    });
</script>
</html>