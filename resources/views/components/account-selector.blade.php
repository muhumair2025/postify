@props(['selectedPlatforms' => [], 'allowMultiple' => true])

@php
    $user = auth()->user();
    $socialAccounts = $user ? $user->socialAccounts()->active()->get()->groupBy('platform') : collect();
@endphp

<div class="bg-white border border-gray-200 rounded-lg p-4">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-gray-900">Select Accounts</h3>
        @if($allowMultiple)
            <span class="text-xs text-gray-500 hidden sm:block">Select multiple for cross-posting</span>
        @endif
    </div>

    @if($socialAccounts->count() > 0)
        <div class="space-y-3" id="account-selector">
            @foreach(['youtube', 'facebook', 'instagram', 'tiktok'] as $platform)
                @if($socialAccounts->has($platform))
                    @foreach($socialAccounts[$platform] as $account)
                        <label class="relative flex items-center space-x-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors account-option" 
                               data-platform="{{ $platform }}" data-account-id="{{ $account->id }}">
                            
                            @if($allowMultiple)
                                <input type="checkbox" name="selected_accounts[]" value="{{ $account->id }}" 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded account-checkbox flex-shrink-0"
                                       onchange="handleAccountSelection(this)"
                                       {{ in_array($platform, $selectedPlatforms) ? 'checked' : '' }}>
                            @else
                                <input type="radio" name="selected_account" value="{{ $account->id }}" 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 account-radio flex-shrink-0"
                                       onchange="handleAccountSelection(this)"
                                       {{ in_array($platform, $selectedPlatforms) ? 'checked' : '' }}>
                            @endif
                            
                            <!-- Profile Image or Platform Icon -->
                            @if($account->account_data && isset($account->account_data['avatar']))
                                <img src="{{ $account->account_data['avatar'] }}" alt="{{ $account->account_name }}" 
                                     class="w-12 h-12 object-cover border-2 border-{{ $platform === 'youtube' ? 'red' : ($platform === 'facebook' ? 'blue' : ($platform === 'instagram' ? 'pink' : 'gray')) }}-200">
                            @elseif($platform === 'youtube')
                                <div class="w-12 h-12 bg-red-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                </div>
                            @elseif($platform === 'facebook')
                                <div class="w-10 h-10 bg-blue-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </div>
                            @elseif($platform === 'instagram')
                                <div class="w-10 h-10 bg-pink-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </div>
                            @elseif($platform === 'tiktok')
                                <div class="w-10 h-10 bg-gray-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="flex-1 min-w-0 pr-3">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $account->account_name }}</p>
                                <div class="flex items-center space-x-2 mt-1">
                                    <p class="text-xs text-gray-500">{{ ucfirst($platform) }}</p>
                                    @if($platform === 'youtube' && $account->account_data && isset($account->account_data['subscriber_count']))
                                        <span class="text-xs text-gray-400">•</span>
                                        <p class="text-xs text-gray-400 hidden sm:block">{{ number_format($account->account_data['subscriber_count']) }} subscribers</p>
                                    @elseif($platform === 'instagram' && $account->account_data && isset($account->account_data['followers_count']))
                                        <span class="text-xs text-gray-400">•</span>
                                        <p class="text-xs text-gray-400 hidden sm:block">{{ number_format($account->account_data['followers_count']) }} followers</p>
                                    @elseif($platform === 'facebook' && $account->account_data && isset($account->account_data['likes_count']))
                                        <span class="text-xs text-gray-400">•</span>
                                        <p class="text-xs text-gray-400 hidden sm:block">{{ number_format($account->account_data['likes_count']) }} likes</p>
                                    @elseif($platform === 'tiktok' && $account->account_data && isset($account->account_data['followers_count']))
                                        <span class="text-xs text-gray-400">•</span>
                                        <p class="text-xs text-gray-400 hidden sm:block">{{ number_format($account->account_data['followers_count']) }} followers</p>
                                    @endif
                                </div>
                                @if($account->account_email)
                                    <p class="text-xs text-gray-400 truncate hidden sm:block">{{ $account->account_email }}</p>
                                @endif
                                @if($account->account_data && isset($account->account_data['verified']) && $account->account_data['verified'])
                                    <div class="flex items-center mt-1">
                                        <svg class="w-3 h-3 text-blue-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-xs text-blue-600">Verified</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Platform Status Badge -->
                            <div class="flex flex-col items-end space-y-1 flex-shrink-0">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-green-800 bg-green-100">
                                    Connected
                                </span>
                                <!-- Eligibility status will be shown here -->
                                <div class="eligibility-status hidden">
                                    <span class="text-xs text-red-600">Not eligible</span>
                                </div>
                            </div>

                            <!-- Suggestion Badge -->
                            <div class="suggestion-badge absolute -top-1 -right-1 hidden">
                                <span class="inline-flex items-center px-1 py-0.5 text-xs font-medium text-blue-800 bg-blue-100">
                                    Suggested
                                </span>
                            </div>
                        </label>
                    @endforeach
                @else
                    <!-- Platform not connected -->
                    <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg opacity-50">
                        @if($platform === 'youtube')
                            <div class="w-10 h-10 bg-gray-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </div>
                        @elseif($platform === 'facebook')
                            <div class="w-10 h-10 bg-gray-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </div>
                        @elseif($platform === 'instagram')
                            <div class="w-10 h-10 bg-gray-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.40z"/>
                                </svg>
                            </div>
                        @elseif($platform === 'tiktok')
                            <div class="w-10 h-10 bg-gray-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500">{{ ucfirst($platform) }}</p>
                            <p class="text-xs text-gray-400">Not connected</p>
                        </div>
                        
                        <a href="{{ route('social-accounts.connect', $platform) }}" 
                           class="text-xs text-blue-600 hover:text-blue-500">Connect</a>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Selected Platforms Summary -->
        <div id="selected-platforms-summary" class="mt-4 hidden">
            <div class="border-t border-gray-200 pt-4">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Posting to:</h4>
                <div id="platform-badges" class="flex flex-wrap gap-2"></div>
            </div>
        </div>

        <!-- Cross-posting suggestions -->
        <div id="cross-post-suggestions" class="mt-4 hidden">
            <div class="bg-blue-50 border border-blue-200 p-3">
                <div class="flex">
                    <svg class="h-5 w-5 text-blue-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-blue-800">Cross-posting Suggestion</h4>
                        <p class="text-sm text-blue-700 mt-1" id="suggestion-text"></p>
                        <button onclick="acceptSuggestion()" class="text-xs text-blue-600 hover:text-blue-800 mt-1">
                            Select suggested platforms
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-500">No accounts connected</p>
            <a href="{{ route('social-accounts.index') }}" class="mt-2 text-blue-600 hover:text-blue-500">
                Connect your first account
            </a>
        </div>
    @endif
</div>

<script>
function handleAccountSelection(checkbox) {
    updateSelectedPlatforms();
    checkContentEligibility();
    showCrossPostSuggestions();
}

function updateSelectedPlatforms() {
    const selectedInputs = document.querySelectorAll('.account-checkbox:checked, .account-radio:checked');
    const summary = document.getElementById('selected-platforms-summary');
    const badges = document.getElementById('platform-badges');
    
    if (selectedInputs.length > 0) {
        summary.classList.remove('hidden');
        badges.innerHTML = '';
        
        selectedInputs.forEach(input => {
            const label = input.closest('.account-option');
            const platform = label.dataset.platform;
            const accountName = label.querySelector('p.text-sm').textContent;
            
            const badge = document.createElement('span');
            badge.className = 'inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800';
            badge.textContent = `${accountName} (${platform})`;
            badges.appendChild(badge);
        });
    } else {
        summary.classList.add('hidden');
    }
}

function checkContentEligibility() {
    // This will be called from the parent form when content changes
    // Placeholder for now - will be implemented in platform-specific forms
}

function showCrossPostSuggestions() {
    const selectedInputs = document.querySelectorAll('.account-checkbox:checked, .account-radio:checked');
    const suggestionsDiv = document.getElementById('cross-post-suggestions');
    
    if (selectedInputs.length === 1) {
        // Show suggestions for additional platforms
        const selectedPlatform = selectedInputs[0].closest('.account-option').dataset.platform;
        const suggestions = getSuggestedPlatforms(selectedPlatform);
        
        if (suggestions.length > 0) {
            document.getElementById('suggestion-text').textContent = 
                `Consider also posting to ${suggestions.join(', ')} to maximize your reach!`;
            suggestionsDiv.classList.remove('hidden');
        } else {
            suggestionsDiv.classList.add('hidden');
        }
    } else {
        suggestionsDiv.classList.add('hidden');
    }
}

function getSuggestedPlatforms(selectedPlatform) {
    const suggestions = {
        'youtube': ['instagram', 'facebook'],
        'instagram': ['youtube', 'tiktok'],
        'facebook': ['youtube', 'instagram'],
        'tiktok': ['instagram', 'youtube']
    };
    
    return suggestions[selectedPlatform] || [];
}

function acceptSuggestion() {
    // Auto-select suggested platforms if they're available
    const selectedPlatform = document.querySelector('.account-checkbox:checked, .account-radio:checked')
        ?.closest('.account-option').dataset.platform;
    
    if (selectedPlatform) {
        const suggestions = getSuggestedPlatforms(selectedPlatform);
        
        suggestions.forEach(platform => {
            const platformInput = document.querySelector(`[data-platform="${platform}"] input`);
            if (platformInput && !platformInput.disabled) {
                platformInput.checked = true;
            }
        });
        
        updateSelectedPlatforms();
        document.getElementById('cross-post-suggestions').classList.add('hidden');
    }
}
</script>
