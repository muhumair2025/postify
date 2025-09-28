<x-fullwidth-layout>
    <x-slot name="title">Create Post</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="bg-white shadow-sm border border-gray-200">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-900">Create New Post</h1>
                <p class="mt-1 text-gray-600">Choose your platform and create engaging content</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Account Selection -->
            <div class="lg:col-span-1">
                <x-account-selector :allowMultiple="true" />
            </div>

            <!-- Platform Selection & Forms -->
            <div class="lg:col-span-2">
                <div class="bg-white border border-gray-200 p-6">
                    <!-- Dynamic Form Container - YouTube form will handle content type selection -->
                    <div id="form-container">
                        <div id="eligibility-check" class="mb-4 hidden">
                            <div class="bg-yellow-50 border border-yellow-200 p-3">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-yellow-800">Platform Compatibility Check</h4>
                                        <p class="text-sm text-yellow-700 mt-1" id="eligibility-message"></p>
                                        <div class="mt-2">
                                            <button onclick="fixEligibility()" class="text-xs text-yellow-600 hover:text-yellow-800">
                                                Auto-fix selection
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Platform-specific forms will be loaded here -->
                        <div id="youtube-form" class="platform-form">
                            @include('posts.forms.youtube-form')
                        </div>
                        
                        <div id="facebook-form" class="platform-form hidden">
                            @include('posts.forms.facebook-form')
                        </div>
                        
                        <div id="instagram-form" class="platform-form hidden">
                            @include('posts.forms.instagram-form')
                        </div>
                        
                        <div id="tiktok-form" class="platform-form hidden">
                            @include('posts.forms.tiktok-form')
                        </div>
                    </div>

                    <!-- No Selection State -->
                    <div id="no-selection" class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h4a1 1 0 011 1v2h4a1 1 0 011 1v2a1 1 0 01-1 1h-1v9a2 2 0 01-2 2H6a2 2 0 01-2-2V8H3a1 1 0 01-1-1V5a1 1 0 011-1h4z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Select Content Type</h3>
                        <p class="text-gray-500">Choose whether you want to create video content or short-form content to get started.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedContentType = 'video'; // Default to video
        let selectedAccounts = [];
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded, initializing...');
            
            // Listen for content type changes from YouTube form
            const youtubeForm = document.querySelector('#youtube-form');
            if (youtubeForm) {
                youtubeForm.addEventListener('change', function(e) {
                    if (e.target.name === 'youtube_content_type') {
                        selectedContentType = e.target.value;
                        checkSelectedAccountsEligibility();
                    }
                });
            }
            
            // Update selected accounts when checkboxes change - use event delegation
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('account-checkbox') || e.target.classList.contains('account-radio')) {
                    console.log('Account checkbox changed:', e.target.value, e.target.checked);
                    updateSelectedAccountsInput();
                }
            });
            
            // Also listen for clicks on labels and containers
            document.addEventListener('click', function(e) {
                if (e.target.closest('.account-option')) {
                    setTimeout(updateSelectedAccountsInput, 100); // Small delay to ensure checkbox state is updated
                }
            });
            
            // Initialize selected accounts on page load
            setTimeout(updateSelectedAccountsInput, 500); // Delay to ensure all elements are loaded
        });
        
        function updateSelectedAccountsInput() {
            try {
                // Look for both checkbox and radio inputs
                const selectedInputs = document.querySelectorAll('input[name="selected_accounts[]"], input[name="selected_accounts"]:checked, .account-checkbox:checked, .account-radio:checked');
                console.log('Found selected inputs:', selectedInputs.length);
                
                const accountIds = [];
                selectedInputs.forEach(input => {
                    if (input.checked && input.value) {
                        accountIds.push(input.value);
                    }
                });
                
                const hiddenInput = document.getElementById('selected_accounts_input');
                if (hiddenInput) {
                    hiddenInput.value = accountIds.join(',');
                    console.log('Updated hidden input with:', hiddenInput.value);
                } else {
                    console.error('Hidden input selected_accounts_input not found!');
                }
                
                // Also update any other selected_accounts fields
                const otherInputs = document.querySelectorAll('input[name="selected_accounts"]');
                otherInputs.forEach(input => {
                    if (input.type === 'hidden') {
                        input.value = accountIds.join(',');
                    }
                });
                
                console.log('Selected account IDs:', accountIds);
                return accountIds;
            } catch (error) {
                console.error('Error updating selected accounts:', error);
                return [];
            }
        }

        function checkSelectedAccountsEligibility() {
            const selectedInputs = document.querySelectorAll('.account-checkbox:checked');
            selectedAccounts = Array.from(selectedInputs).map(input => ({
                id: input.value,
                platform: input.closest('.account-option').dataset.platform
            }));

            if (selectedAccounts.length === 0) {
                showEligibilityMessage('Please select at least one account to continue.', 'warning');
                return;
            }

            const eligiblePlatforms = getEligiblePlatforms(selectedContentType);
            const ineligibleAccounts = selectedAccounts.filter(account => 
                !eligiblePlatforms.includes(account.platform)
            );

            if (ineligibleAccounts.length > 0) {
                const ineligiblePlatformNames = ineligibleAccounts.map(acc => acc.platform).join(', ');
                showEligibilityMessage(
                    `${selectedContentType === 'short' ? 'Short content' : 'Video content'} is not supported on: ${ineligiblePlatformNames}. Please deselect these accounts or choose a different content type.`,
                    'error'
                );
                return;
            }

            // All selected accounts are eligible
            hideEligibilityMessage();
            showAppropriateForm();
        }

        function getEligiblePlatforms(contentType) {
            if (contentType === 'short') {
                return ['youtube', 'instagram', 'tiktok']; // Facebook doesn't support shorts
            } else {
                return ['youtube', 'facebook', 'instagram', 'tiktok']; // All platforms support videos
            }
        }

        function showEligibilityMessage(message, type) {
            const eligibilityDiv = document.getElementById('eligibility-check');
            const messageElement = document.getElementById('eligibility-message');
            
            messageElement.textContent = message;
            eligibilityDiv.classList.remove('hidden');
            
            // Hide all forms when there's an eligibility issue
            document.querySelectorAll('.platform-form').forEach(form => form.classList.add('hidden'));
        }

        function hideEligibilityMessage() {
            document.getElementById('eligibility-check').classList.add('hidden');
        }

        function fixEligibility() {
            if (!selectedContentType) return;
            
            const eligiblePlatforms = getEligiblePlatforms(selectedContentType);
            
            // Uncheck ineligible accounts
            document.querySelectorAll('.account-checkbox:checked').forEach(input => {
                const platform = input.closest('.account-option').dataset.platform;
                if (!eligiblePlatforms.includes(platform)) {
                    input.checked = false;
                }
            });
            
            // If no accounts left selected, auto-select the first eligible account
            const remainingSelected = document.querySelectorAll('.account-checkbox:checked');
            if (remainingSelected.length === 0) {
                const firstEligibleAccount = document.querySelector(`[data-platform="${eligiblePlatforms[0]}"] .account-checkbox`);
                if (firstEligibleAccount) {
                    firstEligibleAccount.checked = true;
                }
            }
            
            // Update the selection
            updateSelectedPlatforms(); // This function is in the account-selector component
            checkSelectedAccountsEligibility();
            
            // Show success message
            showNotification('Selection fixed! Incompatible accounts have been removed.', 'success');
        }
        
        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-4 py-2 text-sm font-medium text-white ${
                type === 'success' ? 'bg-green-600' : 'bg-blue-600'
            } shadow-lg transform transition-all duration-300`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        function showAppropriateForm() {
            // Hide all forms first
            document.querySelectorAll('.platform-form').forEach(form => form.classList.add('hidden'));
            
            // Determine which form to show based on selected accounts
            const platforms = selectedAccounts.map(acc => acc.platform);
            const uniquePlatforms = [...new Set(platforms)];
            
            // For now, show the form of the first selected platform
            // Later we can create a unified form for multi-platform posting
            if (uniquePlatforms.includes('youtube')) {
                document.getElementById('youtube-form').classList.remove('hidden');
            } else if (uniquePlatforms.includes('facebook')) {
                document.getElementById('facebook-form').classList.remove('hidden');
            } else if (uniquePlatforms.includes('instagram')) {
                document.getElementById('instagram-form').classList.remove('hidden');
            } else if (uniquePlatforms.includes('tiktok')) {
                document.getElementById('tiktok-form').classList.remove('hidden');
            }
        }

        // Override the account selection handler to check eligibility
        function handleAccountSelection(checkbox) {
            console.log('handleAccountSelection called:', checkbox);
            updateSelectedPlatforms(); // From account-selector component
            updateSelectedAccountsInput(); // Update hidden form field
            
            if (selectedContentType) {
                checkSelectedAccountsEligibility();
            }
            
            showCrossPostSuggestions(); // From account-selector component
        }
        
        // Make sure this function is available globally
        window.handleAccountSelection = handleAccountSelection;
        window.updateSelectedAccountsInput = updateSelectedAccountsInput;
        
        // Form validation function
        function validateForm() {
            const accountIds = updateSelectedAccountsInput();
            
            if (accountIds.length === 0) {
                alert('Please select at least one social media account before submitting.');
                return false;
            }
            
            const hiddenInput = document.getElementById('selected_accounts_input');
            if (!hiddenInput || !hiddenInput.value) {
                alert('Error: Selected accounts not properly set. Please try selecting accounts again.');
                return false;
            }
            
            console.log('Form validation passed. Selected accounts:', hiddenInput.value);
            return true;
        }
    </script>
</x-fullwidth-layout>
