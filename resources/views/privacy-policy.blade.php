<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Privacy Policy - Postify</title>
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

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-sm p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-8">Privacy Policy</h1>
            <p class="text-gray-600 mb-8">Last updated: {{ date('F j, Y') }}</p>

            <div class="prose prose-lg max-w-none">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Introduction</h2>
                <p class="text-gray-700 mb-6">
                    At Postify, we take your privacy seriously. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our social media management platform. We are committed to protecting your personal data and ensuring transparency about our data practices.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Information We Collect</h2>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Personal Information</h3>
                <p class="text-gray-700 mb-4">When you create an account with Postify, we collect:</p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>Name and email address</li>
                    <li>Account credentials for authentication</li>
                    <li>Profile information you choose to provide</li>
                    <li>Billing information (processed securely through third-party payment processors)</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Social Media Account Data</h3>
                <p class="text-gray-700 mb-4">When you connect your social media accounts (YouTube, Facebook, Instagram, TikTok), we collect:</p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li><strong>Access Tokens:</strong> Secure tokens that allow us to post on your behalf</li>
                    <li><strong>Account Information:</strong> Basic profile information (username, profile picture, follower count)</li>
                    <li><strong>Content Data:</strong> Posts, captions, and media you create through our platform</li>
                    <li><strong>Analytics Data:</strong> Performance metrics for your posts (views, likes, comments, shares)</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Usage Information</h3>
                <p class="text-gray-700 mb-4">We automatically collect information about how you use our service:</p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>Log data (IP address, browser type, pages visited)</li>
                    <li>Device information (device type, operating system)</li>
                    <li>Usage patterns and feature interactions</li>
                    <li>Performance and error data</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">How We Use Your Information</h2>
                <p class="text-gray-700 mb-4">We use your information to:</p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li><strong>Provide Our Service:</strong> Schedule and publish your content across social media platforms</li>
                    <li><strong>Account Management:</strong> Create and maintain your account, process payments</li>
                    <li><strong>Analytics:</strong> Provide insights and performance metrics for your content</li>
                    <li><strong>Communication:</strong> Send service updates, security alerts, and support messages</li>
                    <li><strong>Improvement:</strong> Enhance our platform features and user experience</li>
                    <li><strong>Security:</strong> Protect against fraud, abuse, and security threats</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Data Security and Privacy</h2>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Your Social Media Data is Private</h3>
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <p class="text-blue-800 font-medium">
                        🔒 <strong>Important:</strong> We never access, read, or store your personal social media content beyond what you explicitly create through our platform. Your private messages, personal posts, and account data remain completely private to you.
                    </p>
                </div>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">What We Do NOT Do</h3>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>We do not read your private messages or direct messages</li>
                    <li>We do not access your personal photos or videos not shared through our platform</li>
                    <li>We do not collect your friends' or followers' personal information</li>
                    <li>We do not sell your data to third parties</li>
                    <li>We do not use your content for advertising or marketing without permission</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Security Measures</h3>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>All data is encrypted in transit and at rest</li>
                    <li>Access tokens are stored securely and encrypted</li>
                    <li>Regular security audits and monitoring</li>
                    <li>Limited employee access on a need-to-know basis</li>
                    <li>Secure data centers with industry-standard protections</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Platform-Specific Data Handling</h2>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-3">YouTube</h3>
                <p class="text-gray-700 mb-4">
                    We use YouTube's API to upload videos and manage your channel. We only access the specific videos you upload through our platform and basic channel information needed for scheduling and analytics.
                </p>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Facebook & Instagram</h3>
                <p class="text-gray-700 mb-4">
                    We use Facebook's Graph API to post content to your Facebook pages and Instagram accounts. We only access the content you create through our platform and basic page/account information.
                </p>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">TikTok</h3>
                <p class="text-gray-700 mb-4">
                    We use TikTok's API to upload videos to your account. We only access the videos you upload through our platform and basic account information needed for posting.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Data Sharing and Disclosure</h2>
                <p class="text-gray-700 mb-4">We may share your information only in the following circumstances:</p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li><strong>With Your Consent:</strong> When you explicitly authorize us to share information</li>
                    <li><strong>Service Providers:</strong> With trusted third-party services that help us operate our platform (hosting, analytics, payment processing)</li>
                    <li><strong>Legal Requirements:</strong> When required by law, court order, or to protect our rights and safety</li>
                    <li><strong>Business Transfers:</strong> In the event of a merger, acquisition, or sale of assets (with notice to users)</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Your Rights and Controls</h2>
                <p class="text-gray-700 mb-4">You have the following rights regarding your data:</p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li><strong>Access:</strong> Request a copy of your personal data</li>
                    <li><strong>Correction:</strong> Update or correct inaccurate information</li>
                    <li><strong>Deletion:</strong> Request deletion of your account and associated data</li>
                    <li><strong>Portability:</strong> Export your data in a machine-readable format</li>
                    <li><strong>Disconnect:</strong> Remove social media account connections at any time</li>
                    <li><strong>Opt-out:</strong> Unsubscribe from marketing communications</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Data Retention</h2>
                <p class="text-gray-700 mb-6">
                    We retain your data only as long as necessary to provide our services and comply with legal obligations. When you delete your account, we will delete your personal data within 30 days, except for data we are required to retain by law.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">International Data Transfers</h2>
                <p class="text-gray-700 mb-6">
                    Our services are hosted in secure data centers. If you are located outside the country where our servers are located, your information may be transferred internationally. We ensure appropriate safeguards are in place for such transfers.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Children's Privacy</h2>
                <p class="text-gray-700 mb-6">
                    Our service is not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13. If we become aware that we have collected such information, we will take steps to delete it promptly.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Changes to This Privacy Policy</h2>
                <p class="text-gray-700 mb-6">
                    We may update this Privacy Policy from time to time. We will notify you of any material changes by posting the new Privacy Policy on this page and updating the "Last updated" date. We encourage you to review this Privacy Policy periodically.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Contact Us</h2>
                <p class="text-gray-700 mb-4">
                    If you have any questions about this Privacy Policy or our data practices, please contact us:
                </p>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700">
                        <strong>Company:</strong> SSA Technology<br>
                        <strong>Website:</strong> <a href="https://ssatechs.com" class="text-blue-600 hover:underline">ssatechs.com</a><br>
                        <strong>Email:</strong> <a href="mailto:ssatechs1220@gmail.com" class="text-blue-600 hover:underline">ssatechs1220@gmail.com</a><br>
                        <strong>Phone:</strong> <a href="tel:+923409148304" class="text-blue-600 hover:underline">+92 340 9148304</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <img src="{{ asset('images/postify_logo.png') }}" alt="Postify" class="h-8 w-auto">
                </div>
                <div class="flex space-x-6">
                    <a href="{{ url('/') }}" class="text-gray-300 hover:text-white transition-colors">Home</a>
                    <a href="{{ route('privacy-policy') }}" class="text-gray-300 hover:text-white transition-colors">Privacy Policy</a>
                    <a href="{{ route('terms-of-service') }}" class="text-gray-300 hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
