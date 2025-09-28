<!-- Top Bar -->
<header class="corporate-navbar">
    <div class="flex items-center justify-between h-16 px-6">
        <!-- Mobile menu button -->
        <div class="lg:hidden">
            <button type="button" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" id="mobile-menu-button">
                <span class="sr-only">Open sidebar</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Page title -->
        <div class="flex-1 lg:ml-0 ml-4">
            <h1 class="text-2xl font-semibold text-gray-900">{{ $title ?? 'Dashboard' }}</h1>
        </div>

        <!-- Right side items -->
        <div class="flex items-center space-x-2 sm:space-x-4">
            <!-- Quick Actions -->
            <div class="hidden md:flex items-center space-x-2">
                <a href="{{ route('posts.create') }}" class="corporate-button">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden lg:inline">Create Post</span>
                    <span class="lg:hidden">Create</span>
                </a>
            </div>


            <!-- User dropdown -->
            <div class="relative">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="corporate-profile-trigger" style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; padding: 6px 12px; background: #ffffff; border: 1px solid #d1d5db; border-radius: 0; min-height: 42px; min-width: 140px;">
                            <div class="corporate-profile-content" style="display: flex; flex-direction: row; align-items: center; flex: 1;">
                                <div class="corporate-profile-avatar" style="width: 28px; height: 28px; background: #3b82f6; color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; border-radius: 0; margin-right: 8px;">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="corporate-profile-name hidden sm:block" style="font-size: 14px; font-weight: 500; color: #374151; white-space: nowrap;">{{ auth()->user()->name }}</span>
                            </div>
                            <svg class="corporate-profile-dropdown-icon h-4 w-4" style="color: #6b7280; margin-left: 8px;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm text-gray-900 font-medium">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile & Settings
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('social-accounts.index')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            Social Accounts
                        </x-dropdown-link>

                        <div class="border-t border-gray-100"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</header>

<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        if (mobileMenuButton && sidebar && sidebarOverlay) {
            mobileMenuButton.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
                sidebar.classList.toggle('translate-x-0');
                sidebarOverlay.classList.toggle('opacity-0');
                sidebarOverlay.classList.toggle('opacity-100');
                sidebarOverlay.classList.toggle('pointer-events-none');
            });

            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                sidebarOverlay.classList.add('opacity-0');
                sidebarOverlay.classList.remove('opacity-100');
                sidebarOverlay.classList.add('pointer-events-none');
            });
        }
    });
</script>