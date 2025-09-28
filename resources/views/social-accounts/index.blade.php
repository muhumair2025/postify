<x-app-layout>
    <x-slot name="title">Connect Accounts</x-slot>

    <div class="max-w-6xl mx-auto space-y-8">
        <!-- Header -->
        <div class="bg-white shadow-sm border border-gray-200">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-900">Connect Your Social Accounts</h1>
                <p class="mt-2 text-gray-600">Connect your social media accounts to start posting and scheduling content across multiple platforms.</p>
            </div>
        </div>

        <!-- Platforms Grid -->
        <div class="space-y-8">
            @foreach($platforms as $platform => $info)
                @php
                    $platformAccounts = $socialAccounts[$platform] ?? collect();
                    $isConnected = $platformAccounts->count() > 0;
                @endphp
                
                <!-- Platform Section -->
                <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
                    <!-- Platform Header -->
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <!-- Platform Icon -->
                                <div class="flex-shrink-0">
                                    @if($platform === 'youtube')
                                        <div class="w-16 h-16 bg-red-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-10 h-10 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                            </svg>
                                        </div>
                                    @elseif($platform === 'facebook')
                                        <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-10 h-10 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                            </svg>
                                        </div>
                                    @elseif($platform === 'instagram')
                                        <div class="w-16 h-16 bg-pink-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-10 h-10 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                            </svg>
                                        </div>
                                    @elseif($platform === 'tiktok')
                                        <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-10 h-10 text-black" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Platform Info -->
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">{{ $info['name'] }}</h2>
                                    <p class="text-gray-600 mt-1">{{ $info['description'] }}</p>
                                    @if($isConnected)
                                        <div class="flex items-center space-x-2 mt-2">
                                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                            <span class="text-sm text-green-600 font-medium">
                                                {{ $platformAccounts->count() }} {{ $platformAccounts->count() === 1 ? 'account' : 'accounts' }} connected
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Primary Action Button -->
                            <div class="flex items-center space-x-3">
                                @if($isConnected && $platform === 'youtube')
                                    <a href="{{ route('social-accounts.connect', $platform) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-200 text-sm font-medium text-red-700 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add Another Channel
                                    </a>
                                @endif
                                
                                @if(!$isConnected)
                                    @if($platform === 'youtube')
                                        <a href="{{ route('social-accounts.connect', $platform) }}" class="inline-flex items-center px-6 py-3 bg-red-600 border border-transparent text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                            Connect {{ $info['name'] }}
                                        </a>
                                    @elseif($platform === 'facebook')
                                        <a href="{{ route('social-accounts.connect', $platform) }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                            Connect {{ $info['name'] }}
                                        </a>
                                    @elseif($platform === 'instagram')
                                        <a href="{{ route('social-accounts.connect', $platform) }}" class="inline-flex items-center px-6 py-3 bg-pink-600 border border-transparent text-sm font-medium text-white hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                            Connect {{ $info['name'] }}
                                        </a>
                                    @elseif($platform === 'tiktok')
                                        <a href="{{ route('social-accounts.connect', $platform) }}" class="inline-flex items-center px-6 py-3 bg-gray-600 border border-transparent text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                            Connect {{ $info['name'] }}
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Connected Accounts -->
                    @if($isConnected)
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($platformAccounts as $account)
                                    <!-- Account Card -->
                                    <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl p-5 hover:shadow-md transition-shadow">
                                        <div class="flex items-start justify-between mb-4">
                                            <!-- Avatar and Status -->
                                            <div class="flex items-center space-x-3">
                                                <div class="relative">
                                                    @if($account->account_data && isset($account->account_data['avatar']))
                                                        <img src="{{ $account->account_data['avatar'] }}" 
                                                             alt="Profile" 
                                                             class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                                                    @else
                                                        @if($platform === 'youtube')
                                                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                                                <span class="text-red-600 font-bold text-lg">{{ substr($account->account_name, 0, 1) }}</span>
                                                            </div>
                                                        @elseif($platform === 'facebook')
                                                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                                                <span class="text-blue-600 font-bold text-lg">{{ substr($account->account_name, 0, 1) }}</span>
                                                            </div>
                                                        @elseif($platform === 'instagram')
                                                            <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                                                <span class="text-pink-600 font-bold text-lg">{{ substr($account->account_name, 0, 1) }}</span>
                                                            </div>
                                                        @else
                                                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                                                <span class="text-gray-600 font-bold text-lg">{{ substr($account->account_name, 0, 1) }}</span>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    
                                                    <!-- Status Indicator -->
                                                    @if($account->isTokenExpired())
                                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-yellow-400 rounded-full border-2 border-white" title="Token expired - refresh needed">
                                                            <div class="absolute inset-0 w-4 h-4 bg-yellow-400 rounded-full animate-ping"></div>
                                                        </div>
                                                    @else
                                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white" title="Connected"></div>
                                                    @endif
                                                </div>
                                                
                                                <div class="min-w-0 flex-1">
                                                    <h3 class="font-semibold text-gray-900 truncate text-sm">{{ $account->account_name }}</h3>
                                                    @if($platform === 'youtube' && $account->account_data && isset($account->account_data['channel_handle']))
                                                        <p class="text-gray-500 text-xs">{{ $account->account_data['channel_handle'] }}</p>
                                                    @else
                                                        <p class="text-gray-500 text-xs truncate">{{ $account->account_email }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Actions Dropdown -->
                                            <div class="relative" x-data="{ open: false }">
                                                <button @click="open = !open" 
                                                        class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                                    </svg>
                                                </button>
                                                
                                                <div x-show="open" 
                                                     @click.away="open = false"
                                                     x-transition:enter="transition ease-out duration-100"
                                                     x-transition:enter-start="transform opacity-0 scale-95"
                                                     x-transition:enter-end="transform opacity-100 scale-100"
                                                     x-transition:leave="transition ease-in duration-75"
                                                     x-transition:leave-start="transform opacity-100 scale-100"
                                                     x-transition:leave-end="transform opacity-0 scale-95"
                                                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                                    <div class="py-1">
                                                        @if($account->isTokenExpired())
                                                            <form action="{{ route('social-accounts.refresh', $account->id) }}" method="POST" class="inline w-full">
                                                                @csrf
                                                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-yellow-700 hover:bg-yellow-50">
                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                                    </svg>
                                                                    Refresh Connection
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('social-accounts.refresh', $account->id) }}" method="POST" class="inline w-full">
                                                                @csrf
                                                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                                    </svg>
                                                                    Refresh Data
                                                                </button>
                                                            </form>
                                                        @endif
                                                        
                                                        <a href="{{ route('posts.create') }}" 
                                                           class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                            </svg>
                                                            Create Post
                                                        </a>
                                                        
                                                        @if($account->isTokenExpired())
                                                            <a href="{{ route('social-accounts.connect', $platform) }}" 
                                                               class="flex items-center px-4 py-2 text-sm text-blue-700 hover:bg-blue-50">
                                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                                </svg>
                                                                Reconnect Account
                                                            </a>
                                                        @endif
                                                        
                                                        <div class="border-t border-gray-100"></div>
                                                        
                                                        <form action="{{ route('social-accounts.disconnect', $account->id) }}" method="POST" class="inline w-full">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    onclick="return confirm('Are you sure you want to disconnect this account?')"
                                                                    class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50">
                                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                                Disconnect
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Token Status Alert -->
                                        @if($account->isTokenExpired())
                                            <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.96-.833-2.73 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                    </svg>
                                                    <span class="text-sm text-yellow-800">Connection expired - refresh needed</span>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Account Stats -->
                                        @if($platform === 'youtube' && $account->account_data)
                                            <div class="space-y-3">
                                                @if(isset($account->account_data['subscriber_count']))
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-sm text-gray-600">Subscribers</span>
                                                        <span class="text-sm font-semibold text-gray-900">
                                                            {{ number_format($account->account_data['subscriber_count']) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                
                                                @if(isset($account->account_data['video_count']))
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-sm text-gray-600">Videos</span>
                                                        <span class="text-sm font-semibold text-gray-900">
                                                            {{ number_format($account->account_data['video_count']) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                
                                                @if(isset($account->account_data['view_count']))
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-sm text-gray-600">Total Views</span>
                                                        <span class="text-sm font-semibold text-gray-900">
                                                            {{ number_format($account->account_data['view_count']) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                
                                                @if(isset($account->account_data['published_at']))
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-sm text-gray-600">Channel Created</span>
                                                        <span class="text-sm font-semibold text-gray-900">
                                                            {{ \Carbon\Carbon::parse($account->account_data['published_at'])->format('M Y') }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        <!-- Quick Action -->
                                        <div class="mt-4 pt-4 border-t border-gray-100">
                                            @if($platform === 'youtube')
                                                <a href="{{ route('posts.create') }}" 
                                                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                    </svg>
                                                    Create Video Post
                                                </a>
                                            @elseif($platform === 'facebook')
                                                <a href="{{ route('posts.create') }}" 
                                                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Create Post
                                                </a>
                                            @elseif($platform === 'instagram')
                                                <a href="{{ route('posts.create') }}" 
                                                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-pink-600 text-white text-sm font-medium rounded-lg hover:bg-pink-700 transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    Create Post
                                                </a>
                                            @else
                                                <a href="{{ route('posts.create') }}" 
                                                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Create Post
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Help Section -->
        <div class="bg-blue-50 border border-blue-200 p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Need Help?</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>Once you connect your accounts, you'll be able to:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>Create and schedule posts across multiple platforms</li>
                            <li>Manage all your content from one dashboard</li>
                            <li>Track engagement and performance</li>
                            <li>Save time with automated posting</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
