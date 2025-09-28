<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terms of Service - Postify</title>
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
            <h1 class="text-4xl font-bold text-gray-900 mb-8">Terms of Service</h1>
            <p class="text-gray-600 mb-8">Last updated: {{ date('F j, Y') }}</p>

            <div class="prose prose-lg max-w-none">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Agreement to Terms</h2>
                <p class="text-gray-700 mb-6">
                    By accessing and using Postify ("Service"), you agree to be bound by these Terms of Service ("Terms"). If you disagree with any part of these terms, then you may not access the Service. These Terms apply to all visitors, users, and others who access or use the Service.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Description of Service</h2>
                <p class="text-gray-700 mb-6">
                    Postify is a social media management platform that allows users to schedule, publish, and manage content across multiple social media platforms including YouTube, Facebook, Instagram, and TikTok. Our Service helps content creators, businesses, and agencies streamline their social media workflow.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">User Accounts and Registration</h2>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Account Creation</h3>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>You must provide accurate and complete information when creating an account</li>
                    <li>You are responsible for maintaining the security of your account credentials</li>
                    <li>You must be at least 13 years old to use our Service</li>
                    <li>One person or legal entity may maintain only one account</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Account Responsibilities</h3>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>You are responsible for all activities that occur under your account</li>
                    <li>You must notify us immediately of any unauthorized use of your account</li>
                    <li>You must keep your contact information up to date</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Social Media Account Connections</h2>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Authorization and Permissions</h3>
                <p class="text-gray-700 mb-4">When you connect your social media accounts to Postify:</p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>You grant us permission to post content on your behalf</li>
                    <li>You authorize us to access basic account information needed for our Service</li>
                    <li>You can revoke these permissions at any time through your account settings</li>
                    <li>We will only access the minimum data necessary to provide our Service</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Platform-Specific Terms</h3>
                
                <h4 class="text-lg font-semibold text-gray-800 mb-2">YouTube</h4>
                <ul class="list-disc pl-6 mb-4 text-gray-700">
                    <li>You must comply with YouTube's Terms of Service and Community Guidelines</li>
                    <li>You are responsible for ensuring your content meets YouTube's policies</li>
                    <li>We use YouTube API Services subject to YouTube's API Terms of Service</li>
                </ul>

                <h4 class="text-lg font-semibold text-gray-800 mb-2">Facebook & Instagram</h4>
                <ul class="list-disc pl-6 mb-4 text-gray-700">
                    <li>You must comply with Facebook's Terms of Service and Community Standards</li>
                    <li>You must have appropriate permissions to post to Facebook pages or Instagram accounts</li>
                    <li>Business accounts may have additional requirements</li>
                </ul>

                <h4 class="text-lg font-semibold text-gray-800 mb-2">TikTok</h4>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>You must comply with TikTok's Terms of Service and Community Guidelines</li>
                    <li>You are responsible for ensuring your content meets TikTok's policies</li>
                    <li>Age restrictions may apply based on your location</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Acceptable Use Policy</h2>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Permitted Uses</h3>
                <p class="text-gray-700 mb-4">You may use our Service to:</p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>Schedule and publish your original content</li>
                    <li>Manage your social media accounts</li>
                    <li>Analyze your content performance</li>
                    <li>Collaborate with team members (where applicable)</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Prohibited Uses</h3>
                <p class="text-gray-700 mb-4">You may NOT use our Service to:</p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>Post illegal, harmful, or offensive content</li>
                    <li>Violate any platform's terms of service or community guidelines</li>
                    <li>Infringe on intellectual property rights</li>
                    <li>Spam or engage in deceptive practices</li>
                    <li>Harass, abuse, or harm others</li>
                    <li>Distribute malware or viruses</li>
                    <li>Attempt to gain unauthorized access to our systems</li>
                    <li>Use our Service for any unlawful purpose</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Content and Intellectual Property</h2>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Your Content</h3>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>You retain all rights to your original content</li>
                    <li>You are responsible for ensuring you have rights to all content you upload</li>
                    <li>You grant us a limited license to process and distribute your content as necessary to provide our Service</li>
                    <li>You represent that your content does not violate any third-party rights</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Our Intellectual Property</h3>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>Postify and our logo are our trademarks</li>
                    <li>Our software, design, and content are protected by intellectual property laws</li>
                    <li>You may not copy, modify, or distribute our proprietary materials</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Privacy and Data Protection</h2>
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <p class="text-blue-800">
                        <strong>Your Privacy Matters:</strong> We are committed to protecting your privacy and personal data. Please review our <a href="{{ route('privacy-policy') }}" class="underline">Privacy Policy</a> to understand how we collect, use, and protect your information.
                    </p>
                </div>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Key Privacy Commitments</h3>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>We never access your private social media content</li>
                    <li>We don't read your personal messages or private posts</li>
                    <li>We only collect data necessary to provide our Service</li>
                    <li>We use industry-standard security measures to protect your data</li>
                    <li>You can delete your account and data at any time</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Payment Terms</h2>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Subscription Plans</h3>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>We offer various subscription plans with different features and limits</li>
                    <li>Pricing is clearly displayed on our website and in your account</li>
                    <li>Subscriptions automatically renew unless cancelled</li>
                    <li>We may change pricing with 30 days' notice to existing subscribers</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Billing and Refunds</h3>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>Payments are processed securely through third-party payment processors</li>
                    <li>You can cancel your subscription at any time</li>
                    <li>Refunds are provided according to our refund policy</li>
                    <li>Failed payments may result in service suspension</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Service Availability and Limitations</h2>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Service Availability</h3>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>We strive to maintain high service availability but cannot guarantee 100% uptime</li>
                    <li>We may perform maintenance that temporarily affects service availability</li>
                    <li>Third-party platform changes may affect our Service functionality</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Usage Limits</h3>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>Different subscription plans have different usage limits</li>
                    <li>We may implement fair usage policies to ensure service quality</li>
                    <li>Excessive usage may result in service limitations or suspension</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Disclaimers and Limitation of Liability</h2>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Service Disclaimers</h3>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>Our Service is provided "as is" without warranties of any kind</li>
                    <li>We do not guarantee that posting will always be successful</li>
                    <li>Social media platforms may change their policies or APIs at any time</li>
                    <li>We are not responsible for content that violates platform policies</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Limitation of Liability</h3>
                <p class="text-gray-700 mb-6">
                    To the maximum extent permitted by law, Postify shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including but not limited to loss of profits, data, or business opportunities, arising from your use of our Service.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Account Termination</h2>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Termination by You</h3>
                <ul class="list-disc pl-6 mb-4 text-gray-700">
                    <li>You may terminate your account at any time through your account settings</li>
                    <li>Upon termination, your data will be deleted according to our data retention policy</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Termination by Us</h3>
                <p class="text-gray-700 mb-4">We may terminate or suspend your account if you:</p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>Violate these Terms of Service</li>
                    <li>Engage in prohibited activities</li>
                    <li>Fail to pay subscription fees</li>
                    <li>Pose a security risk to our Service or other users</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Changes to Terms</h2>
                <p class="text-gray-700 mb-6">
                    We reserve the right to modify these Terms at any time. We will notify users of material changes by email or through our Service. Your continued use of the Service after changes become effective constitutes acceptance of the new Terms.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Governing Law and Disputes</h2>
                <p class="text-gray-700 mb-6">
                    These Terms shall be governed by and construed in accordance with the laws of Pakistan. Any disputes arising from these Terms or your use of our Service shall be resolved through binding arbitration or in the courts of Pakistan.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Contact Information</h2>
                <p class="text-gray-700 mb-4">
                    If you have any questions about these Terms of Service, please contact us:
                </p>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700">
                        <strong>Company:</strong> SSA Technology<br>
                        <strong>Website:</strong> <a href="https://ssatechs.com" class="text-blue-600 hover:underline">ssatechs.com</a><br>
                        <strong>Email:</strong> <a href="mailto:ssatechs1220@gmail.com" class="text-blue-600 hover:underline">ssatechs1220@gmail.com</a><br>
                        <strong>Phone:</strong> <a href="tel:+923409148304" class="text-blue-600 hover:underline">+92 340 9148304</a>
                    </p>
                </div>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4 mt-8">Acknowledgment</h2>
                <p class="text-gray-700 mb-6">
                    By using Postify, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service and our Privacy Policy.
                </p>
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
