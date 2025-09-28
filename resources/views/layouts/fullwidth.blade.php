<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Postify' }} - {{ config('app.name', 'Postify') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <!-- Full Width Top Bar -->
        <header class="corporate-navbar sticky top-0 z-40">
            <div class="flex items-center justify-between h-16 px-6">
                <!-- Left: Logo and Title -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <x-application-logo class="h-8 w-auto" />
                    </a>
                    <div class="hidden md:block h-6 w-px bg-gray-300"></div>
                    <h1 class="hidden md:block text-lg font-semibold text-gray-900">{{ $title ?? 'Create Post' }}</h1>
                </div>

                <!-- Center: Quick Actions -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('posts.index') }}" class="text-sm text-gray-600 hover:text-gray-900">All Posts</a>
                    <a href="{{ route('social-accounts.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Accounts</a>
                    <a href="{{ route('calendar') }}" class="text-sm text-gray-600 hover:text-gray-900">Calendar</a>
                </div>

                <!-- Right: User Menu -->
                <div class="flex items-center space-x-4">
                    <!-- User dropdown -->
                    <div class="relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="corporate-profile-trigger" style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; padding: 6px 12px; background: #ffffff; border: 1px solid #d1d5db; border-radius: 0; min-height: 42px; min-width: 140px;">
                                    <div class="corporate-profile-content" style="display: flex; flex-direction: row; align-items: center; flex: 1;">
                                        <div class="corporate-profile-avatar" style="width: 28px; height: 28px; background: #3b82f6; color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; border-radius: 0; margin-right: 8px;">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                        <span class="corporate-profile-name hidden sm:block" style="font-size: 14px; font-weight: 500; color: #374151; white-space: nowrap;">{{ auth()->user()->name }}</span>
                                    </div>
                                    <svg class="corporate-profile-dropdown-icon h-4 w-4" style="color: #6b7280; margin-left: 8px;" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm text-gray-900 font-medium">{{ auth()->user()->name }}</p>
                                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                                </div>

                                <x-dropdown-link :href="route('dashboard')">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v4H8V5z"></path>
                                    </svg>
                                    Dashboard
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('profile.edit')">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profile & Settings
                                </x-dropdown-link>

                                <div class="border-t border-gray-100"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Log Out
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Main content -->
        <main class="p-6">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3" role="alert">
                    <div class="flex">
                        <svg class="flex-shrink-0 h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3" role="alert">
                    <div class="flex">
                        <svg class="flex-shrink-0 h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('warning'))
                <div class="mb-6 bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3" role="alert">
                    <div class="flex">
                        <svg class="flex-shrink-0 h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('warning') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{ $slot }}
        </main>
    </body>
</html>
