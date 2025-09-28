<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-sm text-amber-600">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="underline text-sm text-amber-600 hover:text-amber-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div>
            <x-input-label for="timezone" :value="__('Timezone')" />
            <select id="timezone" name="timezone" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                @php
                    $timezones = [
                        'Pacific/Honolulu' => 'Hawaii (HST)',
                        'America/Anchorage' => 'Alaska (AKST)',
                        'America/Los_Angeles' => 'Pacific Time (PST)',
                        'America/Denver' => 'Mountain Time (MST)',
                        'America/Chicago' => 'Central Time (CST)',
                        'America/New_York' => 'Eastern Time (EST)',
                        'America/Sao_Paulo' => 'São Paulo (BRT)',
                        'UTC' => 'UTC (Coordinated Universal Time)',
                        'Europe/London' => 'London (GMT)',
                        'Europe/Paris' => 'Paris (CET)',
                        'Europe/Berlin' => 'Berlin (CET)',
                        'Europe/Rome' => 'Rome (CET)',
                        'Europe/Madrid' => 'Madrid (CET)',
                        'Europe/Amsterdam' => 'Amsterdam (CET)',
                        'Europe/Stockholm' => 'Stockholm (CET)',
                        'Europe/Warsaw' => 'Warsaw (CET)',
                        'Europe/Moscow' => 'Moscow (MSK)',
                        'Africa/Cairo' => 'Cairo (EET)',
                        'Asia/Dubai' => 'Dubai (GST)',
                        'Asia/Karachi' => 'Karachi (PKT)',
                        'Asia/Kolkata' => 'Mumbai/Delhi (IST)',
                        'Asia/Dhaka' => 'Dhaka (BST)',
                        'Asia/Bangkok' => 'Bangkok (ICT)',
                        'Asia/Singapore' => 'Singapore (SGT)',
                        'Asia/Shanghai' => 'Beijing/Shanghai (CST)',
                        'Asia/Tokyo' => 'Tokyo (JST)',
                        'Asia/Seoul' => 'Seoul (KST)',
                        'Australia/Sydney' => 'Sydney (AEDT)',
                        'Australia/Melbourne' => 'Melbourne (AEDT)',
                        'Pacific/Auckland' => 'Auckland (NZDT)',
                    ];
                @endphp
                @foreach($timezones as $value => $label)
                    <option value="{{ $value }}" {{ old('timezone', $user->timezone ?? 'UTC') === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('timezone')" />
            <p class="mt-1 text-sm text-gray-500">This timezone will be used for scheduling your posts and displaying times throughout the application.</p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Changes') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ __('Profile updated successfully!') }}</p>
            @endif
        </div>
    </form>
</section>
