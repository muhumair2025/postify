<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Welcome' }} - Postify</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen flex">
            <!-- Left side - Brand & Marketing -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 via-blue-700 to-purple-700 relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" fill="none">
                        <defs>
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                            </pattern>
                        </defs>
                        <rect width="100" height="100" fill="url(#grid)" />
                    </svg>
                </div>
                
                <div class="relative z-10 flex flex-col justify-center px-12 py-8">
                    <!-- Logo -->
                    <div class="mb-8">
                        <x-application-logo class="h-16 w-auto" />
                    </div>
                    
                    <!-- Marketing Content -->
                    <div class="text-white">
                        <h1 class="text-4xl font-bold mb-6">
                            Manage All Your Social Media in One Place
                        </h1>
                        <p class="text-xl text-blue-100 mb-8 leading-relaxed">
                            Schedule posts, track performance, and grow your audience across YouTube, Facebook, Instagram, and TikTok.
                        </p>
                        
                        <!-- Features List -->
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-blue-100">Schedule posts across multiple platforms</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-blue-100">Visual calendar for content planning</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-blue-100">Automated posting and analytics</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right side - Auth Form -->
            <div class="flex-1 flex flex-col justify-center px-6 py-12 lg:px-8">
                <div class="mx-auto w-full max-w-md">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden text-center mb-8">
                        <x-application-logo class="h-12 w-auto mx-auto" />
                    </div>

                    <!-- Auth Card -->
                    <div class="bg-white py-8 px-6 shadow-lg rounded-xl border border-gray-200">
                        {{ $slot }}
                    </div>

                    <!-- Footer Links -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500">
                            © {{ date('Y') }} Postify. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
