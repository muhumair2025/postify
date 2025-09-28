<x-guest-layout>
    <x-slot name="title">Reset Password</x-slot>

    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Forgot your password?</h2>
        <p class="mt-2 text-gray-600">No problem! Enter your email and we'll send you a reset link.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="Enter your email address" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button class="w-full justify-center py-3">
                {{ __('Send reset link') }}
            </x-primary-button>
        </div>

        <!-- Back to login -->
        <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                ← Back to sign in
            </a>
        </div>
    </form>
</x-guest-layout>
