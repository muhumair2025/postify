<x-guest-layout>
    <x-slot name="title">Reset Password</x-slot>

    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Reset your password</h2>
        <p class="mt-2 text-gray-600">Enter your new password below</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" readonly />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('New password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Enter your new password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters long</p>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm new password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" 
                                required autocomplete="new-password" 
                                placeholder="Confirm your new password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button class="w-full justify-center py-3">
                {{ __('Reset password') }}
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
