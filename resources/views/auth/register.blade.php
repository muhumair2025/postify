<x-guest-layout>
    <x-slot name="title">Sign Up</x-slot>

    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Create your account</h2>
        <p class="mt-2 text-gray-600">Start managing your social media today</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" 
                            placeholder="Create a password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters long</p>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" 
                            required autocomplete="new-password" 
                            placeholder="Confirm your password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms and Privacy -->
        <div class="text-sm text-gray-600">
            By creating an account, you agree to our 
            <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Terms of Service</a> 
            and 
            <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Privacy Policy</a>
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button class="w-full justify-center py-3">
                {{ __('Create account') }}
            </x-primary-button>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Sign in
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
