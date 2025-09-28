<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cookie Policy - Postify</title>
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
            <h1 class="text-4xl font-bold text-gray-900 mb-8">Cookie Policy</h1>
            <p class="text-gray-600 mb-8">Last updated: {{ date('F j, Y') }}</p>

            <div class="prose prose-lg max-w-none">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">What Are Cookies?</h2>
                <p class="text-gray-700 mb-6">
                    Cookies are small text files that are stored on your device (computer, tablet, or mobile) when you visit our website. They help us provide you with a better experience by remembering your preferences, keeping you logged in, and analyzing how you use our service.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">How We Use Cookies</h2>
                <p class="text-gray-700 mb-6">
                    Postify uses cookies to enhance your experience, provide essential functionality, and improve our service. We are committed to being transparent about our cookie usage and giving you control over your preferences.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Types of Cookies We Use</h2>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">1. Essential Cookies</h3>
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <p class="text-blue-800 font-medium mb-2">🔧 <strong>Required for Basic Functionality</strong></p>
                    <p class="text-blue-700">These cookies are necessary for our website to function properly and cannot be disabled.</p>
                </div>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li><strong>Authentication Cookies:</strong> Keep you logged in to your account</li>
                    <li><strong>Security Cookies:</strong> Protect against fraud and security threats</li>
                    <li><strong>Session Cookies:</strong> Remember your actions during a browsing session</li>
                    <li><strong>CSRF Protection:</strong> Prevent cross-site request forgery attacks</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">2. Functional Cookies</h3>
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                    <p class="text-green-800 font-medium mb-2">⚙️ <strong>Enhance Your Experience</strong></p>
                    <p class="text-green-700">These cookies remember your preferences and settings to provide a personalized experience.</p>
                </div>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li><strong>Language Preferences:</strong> Remember your preferred language</li>
                    <li><strong>Theme Settings:</strong> Save your dark/light mode preference</li>
                    <li><strong>Dashboard Layout:</strong> Remember your customized dashboard settings</li>
                    <li><strong>Timezone Settings:</strong> Store your timezone for accurate scheduling</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">3. Analytics Cookies</h3>
                <div class="bg-purple-50 border-l-4 border-purple-400 p-4 mb-6">
                    <p class="text-purple-800 font-medium mb-2">📊 <strong>Help Us Improve</strong></p>
                    <p class="text-purple-700">These cookies help us understand how you use our service so we can make improvements.</p>
                </div>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li><strong>Usage Analytics:</strong> Track which features are most popular</li>
                    <li><strong>Performance Monitoring:</strong> Identify and fix technical issues</li>
                    <li><strong>User Journey:</strong> Understand how users navigate our platform</li>
                    <li><strong>Error Tracking:</strong> Monitor and resolve bugs and errors</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">4. Marketing Cookies (Optional)</h3>
                <div class="bg-orange-50 border-l-4 border-orange-400 p-4 mb-6">
                    <p class="text-orange-800 font-medium mb-2">🎯 <strong>Personalized Content</strong></p>
                    <p class="text-orange-700">These cookies help us show you relevant content and measure the effectiveness of our marketing.</p>
                </div>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li><strong>Advertising Cookies:</strong> Show relevant ads on other websites</li>
                    <li><strong>Social Media Integration:</strong> Enable sharing and social media features</li>
                    <li><strong>Campaign Tracking:</strong> Measure the success of marketing campaigns</li>
                    <li><strong>Personalization:</strong> Customize content based on your interests</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Third-Party Cookies</h2>
                <p class="text-gray-700 mb-4">We may use third-party services that set their own cookies. These include:</p>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Analytics Services</h3>
                <ul class="list-disc pl-6 mb-4 text-gray-700">
                    <li><strong>Google Analytics:</strong> Website traffic and user behavior analysis</li>
                    <li><strong>Mixpanel:</strong> Product analytics and user engagement tracking</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Support Services</h3>
                <ul class="list-disc pl-6 mb-4 text-gray-700">
                    <li><strong>Intercom:</strong> Customer support chat functionality</li>
                    <li><strong>Zendesk:</strong> Help desk and support ticket management</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Payment Processing</h3>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li><strong>Stripe:</strong> Secure payment processing</li>
                    <li><strong>PayPal:</strong> Alternative payment method</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Cookie Duration</h2>
                <p class="text-gray-700 mb-4">Cookies have different lifespans:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-800 mb-2">Session Cookies</h4>
                        <p class="text-gray-600 text-sm">Deleted when you close your browser</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-800 mb-2">Persistent Cookies</h4>
                        <p class="text-gray-600 text-sm">Remain until expiration date or manual deletion</p>
                    </div>
                </div>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Managing Your Cookie Preferences</h2>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Cookie Consent Banner</h3>
                <p class="text-gray-700 mb-4">
                    When you first visit our website, you'll see a cookie consent banner where you can:
                </p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>Accept all cookies</li>
                    <li>Reject non-essential cookies</li>
                    <li>Customize your cookie preferences</li>
                    <li>Learn more about each cookie category</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Browser Settings</h3>
                <p class="text-gray-700 mb-4">
                    You can also manage cookies through your browser settings:
                </p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li><strong>Chrome:</strong> Settings > Privacy and security > Cookies and other site data</li>
                    <li><strong>Firefox:</strong> Settings > Privacy & Security > Cookies and Site Data</li>
                    <li><strong>Safari:</strong> Preferences > Privacy > Manage Website Data</li>
                    <li><strong>Edge:</strong> Settings > Cookies and site permissions > Cookies and site data</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Account Settings</h3>
                <p class="text-gray-700 mb-6">
                    Logged-in users can manage cookie preferences in their account settings under "Privacy & Cookies."
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Impact of Disabling Cookies</h2>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <p class="text-yellow-800 font-medium mb-2">⚠️ <strong>Important Notice</strong></p>
                    <p class="text-yellow-700">Disabling certain cookies may affect your experience with Postify.</p>
                </div>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">If You Disable Essential Cookies:</h3>
                <ul class="list-disc pl-6 mb-4 text-gray-700">
                    <li>You may not be able to log in to your account</li>
                    <li>Security features may not work properly</li>
                    <li>Some pages may not load correctly</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">If You Disable Functional Cookies:</h3>
                <ul class="list-disc pl-6 mb-4 text-gray-700">
                    <li>Your preferences won't be remembered</li>
                    <li>You'll need to reconfigure settings each visit</li>
                    <li>Personalization features won't work</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">If You Disable Analytics Cookies:</h3>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>We can't improve our service based on usage data</li>
                    <li>Performance issues may take longer to identify</li>
                    <li>Your usage won't contribute to product improvements</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Your Rights</h2>
                <p class="text-gray-700 mb-4">Under data protection laws, you have the right to:</p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li><strong>Consent:</strong> Give or withdraw consent for non-essential cookies</li>
                    <li><strong>Access:</strong> Know what cookies are being used</li>
                    <li><strong>Control:</strong> Manage your cookie preferences</li>
                    <li><strong>Deletion:</strong> Request deletion of cookie data</li>
                    <li><strong>Portability:</strong> Export your cookie preference settings</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Updates to This Cookie Policy</h2>
                <p class="text-gray-700 mb-6">
                    We may update this Cookie Policy from time to time to reflect changes in our practices or for legal reasons. We will notify you of any material changes by posting the updated policy on this page and updating the "Last updated" date.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Contact Us</h2>
                <p class="text-gray-700 mb-4">
                    If you have any questions about our use of cookies or this Cookie Policy, please contact us:
                </p>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700">
                        <strong>Company:</strong> SSA Technology<br>
                        <strong>Website:</strong> <a href="https://ssatechs.com" class="text-blue-600 hover:underline">ssatechs.com</a><br>
                        <strong>Email:</strong> <a href="mailto:ssatechs1220@gmail.com?subject=Cookie Policy Inquiry" class="text-blue-600 hover:underline">ssatechs1220@gmail.com</a><br>
                        <strong>Phone:</strong> <a href="tel:+923409148304" class="text-blue-600 hover:underline">+92 340 9148304</a>
                    </p>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">🍪 Cookie Preference Center</h3>
                    <p class="text-blue-800 mb-4">
                        Want to change your cookie settings? You can update your preferences at any time.
                    </p>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors" onclick="openCookiePreferences()">
                        Manage Cookie Preferences
                    </button>
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
                    <a href="{{ route('cookie-policy') }}" class="text-gray-300 hover:text-white transition-colors">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function openCookiePreferences() {
            // This would open your cookie preference modal/panel
            alert('Cookie preference center would open here. Integrate with your cookie consent solution.');
        }
    </script>
</body>
</html>
