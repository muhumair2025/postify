<!-- Sidebar -->
<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg border-r border-gray-200 transform transition-transform duration-300 ease-in-out lg:translate-x-0 {{ $isOpen ?? false ? 'translate-x-0' : '-translate-x-full' }}" id="sidebar">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-center h-20 px-6 border-b border-gray-200">
            <x-application-logo class="h-12 w-auto" />
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 overflow-y-auto">
            <div class="space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v4H8V5z"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- Calendar -->
                <a href="{{ route('calendar') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('calendar') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v16a2 2 0 002 2z"></path>
                    </svg>
                    Calendar
                </a>

                <!-- Posts -->
                <div class="space-y-1">
                    <div class="flex items-center px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Content Management
                    </div>
                    <a href="{{ route('posts.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('posts.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        All Posts
                    </a>
                    
                    <a href="{{ route('posts.create') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Post
                    </a>
                </div>

                <!-- Social Accounts -->
                <div class="space-y-1 mt-6">
                    <div class="flex items-center px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Social Accounts
                    </div>
                    <a href="{{ route('social-accounts.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('social-accounts.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        Connect Accounts
                    </a>
                </div>

                <!-- Settings -->
                <div class="space-y-1 mt-6">
                    <div class="flex items-center px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Settings
                    </div>
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile & Settings
                    </a>
                </div>
            </div>
        </nav>

        <!-- User Profile Section -->
        <div class="px-4 py-4 border-t border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                </div>
                <div class="ml-3 flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-gray-500 truncate">
                        {{ auth()->user()->email }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Sidebar overlay for mobile -->
<div class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 transition-opacity lg:hidden {{ $isOpen ?? false ? 'opacity-100' : 'opacity-0 pointer-events-none' }}" id="sidebar-overlay"></div>