<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pricing - Postify</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/postify_logo.png') }}" alt="Postify" class="h-8 w-auto">
                    </a>
                </div>
                
                <!-- Navigation Links -->
                <div class="flex items-center space-x-4">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Home
                    </a>
                    <a href="{{ route('pricing') }}" class="text-blue-600 font-medium px-3 py-2 rounded-md text-sm">
                        Pricing
                    </a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                Sign in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-bold text-gray-900 mb-6">
                Simple, Transparent Pricing
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Choose the perfect plan for your social media management needs. All plans include our core features with no hidden fees.
            </p>
            
            <!-- Billing Toggle -->
            <div class="flex items-center justify-center mb-12">
                <span class="text-gray-700 mr-3">Monthly</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" id="billingToggle">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
                <span class="text-gray-700 ml-3">Yearly</span>
                <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Save 20%</span>
            </div>
        </div>
    </div>

    <!-- Pricing Plans -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Starter Plan -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 relative">
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Starter</h3>
                    <p class="text-gray-600 mb-6">Perfect for individuals getting started</p>
                    
                    <div class="mb-8">
                        <span class="text-4xl font-bold text-gray-900" id="starter-price">$9</span>
                        <span class="text-gray-600">/month</span>
                        <p class="text-sm text-gray-500 mt-1" id="starter-yearly" style="display: none;">$86.40 billed yearly</p>
                    </div>
                    
                    <a href="{{ route('register') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold transition-colors mb-8 inline-block">
                        Start Free Trial
                    </a>
                </div>
                
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 mb-3">What's included:</h4>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">3 social accounts</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">30 scheduled posts/month</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Basic analytics</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Content calendar</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Email support</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Mobile app access</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Plan (Most Popular) -->
            <div class="bg-white rounded-2xl shadow-xl border-2 border-blue-500 p-8 relative transform scale-105">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm font-medium">Most Popular</span>
                </div>
                
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Professional</h3>
                    <p class="text-gray-600 mb-6">Best for growing businesses and creators</p>
                    
                    <div class="mb-8">
                        <span class="text-4xl font-bold text-gray-900" id="pro-price">$29</span>
                        <span class="text-gray-600">/month</span>
                        <p class="text-sm text-gray-500 mt-1" id="pro-yearly" style="display: none;">$278.40 billed yearly</p>
                    </div>
                    
                    <a href="{{ route('register') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold transition-colors mb-8 inline-block">
                        Start Free Trial
                    </a>
                </div>
                
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 mb-3">Everything in Starter, plus:</h4>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">10 social accounts</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">100 scheduled posts/month</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Advanced analytics & insights</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Team collaboration (3 users)</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Auto-posting with optimal timing</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Priority support</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Content templates</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agency Plan -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 relative">
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Agency</h3>
                    <p class="text-gray-600 mb-6">For agencies and large teams</p>
                    
                    <div class="mb-8">
                        <span class="text-4xl font-bold text-gray-900" id="agency-price">$79</span>
                        <span class="text-gray-600">/month</span>
                        <p class="text-sm text-gray-500 mt-1" id="agency-yearly" style="display: none;">$758.40 billed yearly</p>
                    </div>
                    
                    <a href="{{ route('register') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold transition-colors mb-8 inline-block">
                        Start Free Trial
                    </a>
                </div>
                
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 mb-3">Everything in Professional, plus:</h4>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Unlimited social accounts</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Unlimited scheduled posts</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">White-label reporting</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Unlimited team members</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Client management dashboard</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">API access</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Dedicated account manager</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Comparison -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Compare All Features</h2>
                <p class="text-xl text-gray-600">See exactly what's included in each plan</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="border border-gray-200 px-6 py-4 text-left font-semibold text-gray-900">Features</th>
                            <th class="border border-gray-200 px-6 py-4 text-center font-semibold text-gray-900">Starter</th>
                            <th class="border border-gray-200 px-6 py-4 text-center font-semibold text-gray-900 bg-blue-50">Professional</th>
                            <th class="border border-gray-200 px-6 py-4 text-center font-semibold text-gray-900">Agency</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-200 px-6 py-4 font-medium">Social Accounts</td>
                            <td class="border border-gray-200 px-6 py-4 text-center">3</td>
                            <td class="border border-gray-200 px-6 py-4 text-center bg-blue-50">10</td>
                            <td class="border border-gray-200 px-6 py-4 text-center">Unlimited</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-4 font-medium">Monthly Posts</td>
                            <td class="border border-gray-200 px-6 py-4 text-center">30</td>
                            <td class="border border-gray-200 px-6 py-4 text-center bg-blue-50">100</td>
                            <td class="border border-gray-200 px-6 py-4 text-center">Unlimited</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-4 font-medium">Team Members</td>
                            <td class="border border-gray-200 px-6 py-4 text-center">1</td>
                            <td class="border border-gray-200 px-6 py-4 text-center bg-blue-50">3</td>
                            <td class="border border-gray-200 px-6 py-4 text-center">Unlimited</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-4 font-medium">Analytics</td>
                            <td class="border border-gray-200 px-6 py-4 text-center">Basic</td>
                            <td class="border border-gray-200 px-6 py-4 text-center bg-blue-50">Advanced</td>
                            <td class="border border-gray-200 px-6 py-4 text-center">Advanced + White-label</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-4 font-medium">Auto-posting</td>
                            <td class="border border-gray-200 px-6 py-4 text-center">❌</td>
                            <td class="border border-gray-200 px-6 py-4 text-center bg-blue-50">✅</td>
                            <td class="border border-gray-200 px-6 py-4 text-center">✅</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-4 font-medium">API Access</td>
                            <td class="border border-gray-200 px-6 py-4 text-center">❌</td>
                            <td class="border border-gray-200 px-6 py-4 text-center bg-blue-50">❌</td>
                            <td class="border border-gray-200 px-6 py-4 text-center">✅</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-4 font-medium">Support</td>
                            <td class="border border-gray-200 px-6 py-4 text-center">Email</td>
                            <td class="border border-gray-200 px-6 py-4 text-center bg-blue-50">Priority</td>
                            <td class="border border-gray-200 px-6 py-4 text-center">Dedicated Manager</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-xl text-gray-600">Everything you need to know about our pricing</p>
            </div>
            
            <div class="space-y-6">
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Is there a free trial?</h3>
                    <p class="text-gray-700">Yes! All plans come with a 14-day free trial. No credit card required to start.</p>
                </div>
                
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I change plans anytime?</h3>
                    <p class="text-gray-700">Absolutely! You can upgrade or downgrade your plan at any time. Changes take effect immediately.</p>
                </div>
                
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">What payment methods do you accept?</h3>
                    <p class="text-gray-700">We accept all major credit cards (Visa, MasterCard, American Express) and PayPal.</p>
                </div>
                
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Is my data secure?</h3>
                    <p class="text-gray-700">Yes! We use enterprise-grade security and never access your private social media content. Your data is encrypted and secure.</p>
                </div>
                
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I cancel anytime?</h3>
                    <p class="text-gray-700">Yes, you can cancel your subscription at any time. You'll continue to have access until the end of your billing period.</p>
                </div>
                
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Do you offer refunds?</h3>
                    <p class="text-gray-700">We offer a 30-day money-back guarantee. If you're not satisfied, we'll refund your payment.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-br from-blue-600 to-purple-700 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Ready to Get Started?</h2>
            <p class="text-xl text-blue-100 mb-8">Join thousands of creators and businesses using Postify to grow their social media presence.</p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('register') }}" class="bg-white hover:bg-gray-100 text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold transition-colors shadow-lg">
                    Start Your Free Trial
                </a>
                <a href="#" class="border-2 border-white hover:bg-white hover:text-blue-600 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                    Schedule a Demo
                </a>
            </div>
            
            <p class="text-blue-200 text-sm mt-6">✓ 14-day free trial ✓ No credit card required ✓ Cancel anytime</p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/postify_logo.png') }}" alt="Postify" class="h-8 w-auto">
                    </div>
                    <p class="text-gray-300 mb-6 max-w-md">
                        Postify by SSA Technology is the ultimate social media management platform for content creators, businesses, and agencies.
                    </p>
                    <div class="text-gray-300 text-sm">
                        <p><strong>Contact:</strong> <a href="tel:+923409148304" class="hover:text-white">+92 340 9148304</a></p>
                        <p><strong>Email:</strong> <a href="mailto:ssatechs1220@gmail.com" class="hover:text-white">ssatechs1220@gmail.com</a></p>
                        <p><strong>Website:</strong> <a href="https://ssatechs.com" class="hover:text-white">ssatechs.com</a></p>
                    </div>
                </div>
                
                <!-- Product Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Product</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}#features" class="text-gray-300 hover:text-white transition-colors">Features</a></li>
                        <li><a href="{{ route('pricing') }}" class="text-gray-300 hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">API</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Integrations</a></li>
                    </ul>
                </div>
                
                <!-- Legal Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Legal</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('privacy-policy') }}" class="text-gray-300 hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('terms-of-service') }}" class="text-gray-300 hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="{{ route('cookie-policy') }}" class="text-gray-300 hover:text-white transition-colors">Cookie Policy</a></li>
                        <li><a href="{{ route('gdpr') }}" class="text-gray-300 hover:text-white transition-colors">GDPR</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Footer -->
            <div class="border-t border-gray-800 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">© {{ date('Y') }} Postify by SSA Technology. All rights reserved.</p>
                    <div class="flex items-center space-x-6 mt-4 md:mt-0">
                        <span class="text-gray-400 text-sm">🔒 Your data is secure and private</span>
                        <span class="text-gray-400 text-sm">📞 <a href="tel:+923409148304" class="hover:text-white">+92 340 9148304</a></span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Billing toggle functionality
        const billingToggle = document.getElementById('billingToggle');
        const starterPrice = document.getElementById('starter-price');
        const starterYearly = document.getElementById('starter-yearly');
        const proPrice = document.getElementById('pro-price');
        const proYearly = document.getElementById('pro-yearly');
        const agencyPrice = document.getElementById('agency-price');
        const agencyYearly = document.getElementById('agency-yearly');

        billingToggle.addEventListener('change', function() {
            if (this.checked) {
                // Yearly pricing (20% discount)
                starterPrice.textContent = '$7.20';
                starterYearly.style.display = 'block';
                proPrice.textContent = '$23.20';
                proYearly.style.display = 'block';
                agencyPrice.textContent = '$63.20';
                agencyYearly.style.display = 'block';
            } else {
                // Monthly pricing
                starterPrice.textContent = '$9';
                starterYearly.style.display = 'none';
                proPrice.textContent = '$29';
                proYearly.style.display = 'none';
                agencyPrice.textContent = '$79';
                agencyYearly.style.display = 'none';
            }
        });
    </script>
</body>
</html>
