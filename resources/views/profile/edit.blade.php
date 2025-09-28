<x-app-layout>
    <x-slot name="title">Profile & Settings</x-slot>

    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Profile Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>
                <p class="mt-1 text-sm text-gray-600">Update your account's profile information and timezone settings.</p>
            </div>
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Update Password</h3>
                <p class="mt-1 text-sm text-gray-600">Ensure your account is using a long, random password to stay secure.</p>
            </div>
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Delete Account</h3>
                <p class="mt-1 text-sm text-gray-600">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
            </div>
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
