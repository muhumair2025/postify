<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GDPR Compliance - Postify</title>
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
            <h1 class="text-4xl font-bold text-gray-900 mb-8">GDPR Compliance</h1>
            <p class="text-gray-600 mb-8">General Data Protection Regulation - Your Rights and Our Commitments</p>

            <div class="prose prose-lg max-w-none">
                <div class="bg-blue-50 border-l-4 border-blue-400 p-6 mb-8">
                    <h2 class="text-xl font-semibold text-blue-900 mb-3">🇪🇺 Our GDPR Commitment</h2>
                    <p class="text-blue-800">
                        Postify is fully committed to protecting your personal data and complying with the General Data Protection Regulation (GDPR). This page explains your rights under GDPR and how we ensure your data is protected.
                    </p>
                </div>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">What is GDPR?</h2>
                <p class="text-gray-700 mb-6">
                    The General Data Protection Regulation (GDPR) is a comprehensive data protection law that came into effect on May 25, 2018. It applies to all companies processing personal data of individuals in the European Union, regardless of where the company is located. GDPR gives you greater control over your personal data and how it's used.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Your Rights Under GDPR</h2>
                <p class="text-gray-700 mb-6">
                    Under GDPR, you have several fundamental rights regarding your personal data. We respect and facilitate these rights:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Right to Information -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-lg border border-blue-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Right to Information</h3>
                        </div>
                        <p class="text-gray-700 text-sm">You have the right to know what personal data we collect, how we use it, and who we share it with.</p>
                    </div>

                    <!-- Right of Access -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-lg border border-green-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Right of Access</h3>
                        </div>
                        <p class="text-gray-700 text-sm">You can request a copy of all personal data we hold about you, free of charge.</p>
                    </div>

                    <!-- Right to Rectification -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-lg border border-purple-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Right to Rectification</h3>
                        </div>
                        <p class="text-gray-700 text-sm">You can request correction of inaccurate or incomplete personal data.</p>
                    </div>

                    <!-- Right to Erasure -->
                    <div class="bg-gradient-to-br from-red-50 to-orange-50 p-6 rounded-lg border border-red-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Right to Erasure</h3>
                        </div>
                        <p class="text-gray-700 text-sm">You can request deletion of your personal data under certain circumstances.</p>
                    </div>

                    <!-- Right to Restrict Processing -->
                    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 p-6 rounded-lg border border-yellow-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-yellow-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Right to Restrict Processing</h3>
                        </div>
                        <p class="text-gray-700 text-sm">You can request that we limit how we process your personal data in certain situations.</p>
                    </div>

                    <!-- Right to Data Portability -->
                    <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-6 rounded-lg border border-teal-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-teal-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Right to Data Portability</h3>
                        </div>
                        <p class="text-gray-700 text-sm">You can request your data in a machine-readable format to transfer to another service.</p>
                    </div>
                </div>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">How to Exercise Your Rights</h2>
                <p class="text-gray-700 mb-6">
                    We've made it easy for you to exercise your GDPR rights. Here's how you can make requests:
                </p>

                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">📧 Contact Methods</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">Email (Recommended)</h4>
                            <p class="text-gray-700 text-sm mb-2">Send your request to:</p>
                            <p class="text-blue-600 font-medium"><a href="mailto:ssatechs1220@gmail.com?subject=GDPR Request" class="hover:underline">ssatechs1220@gmail.com</a></p>
                            <p class="text-gray-600 text-sm">Response time: Within 72 hours</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">Account Settings</h4>
                            <p class="text-gray-700 text-sm mb-2">For logged-in users:</p>
                            <p class="text-blue-600 font-medium">Dashboard → Privacy Settings</p>
                            <p class="text-gray-600 text-sm">Instant access to most options</p>
                        </div>
                    </div>
                </div>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">Request Processing</h3>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li><strong>Response Time:</strong> We respond to all GDPR requests within 30 days (usually much faster)</li>
                    <li><strong>Identity Verification:</strong> We may need to verify your identity for security purposes</li>
                    <li><strong>Free of Charge:</strong> Most requests are processed free of charge</li>
                    <li><strong>Status Updates:</strong> We'll keep you informed about the progress of your request</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Legal Basis for Processing</h2>
                <p class="text-gray-700 mb-4">
                    Under GDPR, we must have a legal basis for processing your personal data. Here are the legal bases we rely on:
                </p>

                <div class="space-y-4 mb-8">
                    <div class="border-l-4 border-blue-400 pl-4">
                        <h4 class="font-semibold text-gray-800">Contract Performance</h4>
                        <p class="text-gray-700 text-sm">Processing necessary to provide our social media management services</p>
                    </div>
                    <div class="border-l-4 border-green-400 pl-4">
                        <h4 class="font-semibold text-gray-800">Legitimate Interest</h4>
                        <p class="text-gray-700 text-sm">Improving our services, security, and customer support</p>
                    </div>
                    <div class="border-l-4 border-purple-400 pl-4">
                        <h4 class="font-semibold text-gray-800">Consent</h4>
                        <p class="text-gray-700 text-sm">Marketing communications and optional features (you can withdraw anytime)</p>
                    </div>
                    <div class="border-l-4 border-orange-400 pl-4">
                        <h4 class="font-semibold text-gray-800">Legal Obligation</h4>
                        <p class="text-gray-700 text-sm">Compliance with tax, accounting, and other legal requirements</p>
                    </div>
                </div>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Data Protection Measures</h2>
                <p class="text-gray-700 mb-4">
                    We implement comprehensive technical and organizational measures to protect your data:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-blue-900 mb-2">🔐 Technical Safeguards</h4>
                        <ul class="text-blue-800 text-sm space-y-1">
                            <li>• End-to-end encryption</li>
                            <li>• Secure data centers</li>
                            <li>• Regular security audits</li>
                            <li>• Access controls and monitoring</li>
                        </ul>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-green-900 mb-2">📋 Organizational Measures</h4>
                        <ul class="text-green-800 text-sm space-y-1">
                            <li>• Staff training on data protection</li>
                            <li>• Data processing agreements</li>
                            <li>• Privacy by design principles</li>
                            <li>• Regular compliance reviews</li>
                        </ul>
                    </div>
                </div>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">International Data Transfers</h2>
                <p class="text-gray-700 mb-4">
                    When we transfer your data outside the EU, we ensure adequate protection through:
                </p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li><strong>Adequacy Decisions:</strong> Transfers to countries with adequate data protection</li>
                    <li><strong>Standard Contractual Clauses:</strong> EU-approved contracts for data protection</li>
                    <li><strong>Binding Corporate Rules:</strong> Internal policies ensuring consistent protection</li>
                    <li><strong>Certification Schemes:</strong> Third-party verified protection standards</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Data Breach Notification</h2>
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                    <p class="text-red-800 font-medium mb-2">🚨 Our Breach Response Commitment</p>
                    <p class="text-red-700 text-sm">
                        In the unlikely event of a data breach that poses a high risk to your rights and freedoms, we will notify you within 72 hours of becoming aware of the breach.
                    </p>
                </div>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Children's Data Protection</h2>
                <p class="text-gray-700 mb-6">
                    We take special care to protect children's data. Our service is not intended for children under 16 years of age (or the minimum age in your country). If we become aware that we have collected personal data from a child without proper consent, we will delete it promptly.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Data Protection Officer</h2>
                <div class="bg-gray-50 p-4 rounded-lg mb-8">
                    <p class="text-gray-700 mb-2">
                        Our Data Protection Officer (DPO) oversees our GDPR compliance and is available to answer your questions:
                    </p>
                    <p class="text-gray-700">
                        <strong>Company:</strong> SSA Technology<br>
                        <strong>Website:</strong> <a href="https://ssatechs.com" class="text-blue-600 hover:underline">ssatechs.com</a><br>
                        <strong>Email:</strong> <a href="mailto:ssatechs1220@gmail.com?subject=DPO Inquiry" class="text-blue-600 hover:underline">ssatechs1220@gmail.com</a><br>
                        <strong>Phone:</strong> <a href="tel:+923409148304" class="text-blue-600 hover:underline">+92 340 9148304</a>
                    </p>
                </div>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Supervisory Authority</h2>
                <p class="text-gray-700 mb-4">
                    If you're not satisfied with how we handle your GDPR request, you have the right to lodge a complaint with your local supervisory authority:
                </p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li><strong>EU Residents:</strong> Contact your national data protection authority</li>
                    <li><strong>UK Residents:</strong> Information Commissioner's Office (ICO)</li>
                    <li><strong>Other Jurisdictions:</strong> Contact your local privacy regulator</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <a href="mailto:ssatechs1220@gmail.com?subject=GDPR%20Data%20Access%20Request" class="bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-lg text-center font-medium transition-colors">
                        Request My Data
                    </a>
                    <a href="mailto:ssatechs1220@gmail.com?subject=GDPR%20Data%20Deletion%20Request" class="bg-red-600 hover:bg-red-700 text-white p-4 rounded-lg text-center font-medium transition-colors">
                        Delete My Data
                    </a>
                    <a href="mailto:ssatechs1220@gmail.com?subject=GDPR%20Data%20Correction%20Request" class="bg-green-600 hover:bg-green-700 text-white p-4 rounded-lg text-center font-medium transition-colors">
                        Correct My Data
                    </a>
                    <a href="mailto:ssatechs1220@gmail.com?subject=GDPR%20Data%20Export%20Request" class="bg-purple-600 hover:bg-purple-700 text-white p-4 rounded-lg text-center font-medium transition-colors">
                        Export My Data
                    </a>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-green-900 mb-3">✅ Our GDPR Compliance Promise</h3>
                    <p class="text-green-800 mb-4">
                        We are committed to full GDPR compliance and continuously improving our data protection practices. Your privacy is not just a legal requirement for us—it's a fundamental value.
                    </p>
                    <p class="text-green-700 text-sm">
                        Last GDPR compliance review: {{ date('F Y') }} | Next review: {{ date('F Y', strtotime('+6 months')) }}
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
                    <a href="{{ route('gdpr') }}" class="text-gray-300 hover:text-white transition-colors">GDPR</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
