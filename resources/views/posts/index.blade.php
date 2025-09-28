<x-app-layout>
    <x-slot name="title">All Posts</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="bg-white shadow-sm border border-gray-200">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">All Posts</h1>
                        <p class="mt-1 text-gray-600">Manage your content across all platforms</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Post
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white shadow-sm border border-gray-200">
            <div class="p-4">
                <div class="flex flex-wrap gap-4">
                    <select class="border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option>All Platforms</option>
                        <option>YouTube</option>
                        <option>Facebook</option>
                        <option>Instagram</option>
                        <option>TikTok</option>
                    </select>
                    
                    <select class="border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option>All Status</option>
                        <option>Draft</option>
                        <option>Scheduled</option>
                        <option>Published</option>
                        <option>Failed</option>
                    </select>
                    
                    <select class="border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option>All Time</option>
                        <option>Today</option>
                        <option>This Week</option>
                        <option>This Month</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Posts List -->
        <div class="bg-white shadow-sm border border-gray-200">
            @if($posts->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($posts as $post)
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex items-start space-x-4">
                                <!-- Platform Icon -->
                                <div class="flex-shrink-0">
                                    @if($post->platform === 'youtube')
                                        <div class="w-10 h-10 bg-red-100 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                            </svg>
                                        </div>
                                    @elseif($post->platform === 'facebook')
                                        <div class="w-10 h-10 bg-blue-100 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                            </svg>
                                        </div>
                                    @elseif($post->platform === 'instagram')
                                        <div class="w-10 h-10 bg-pink-100 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Post Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <h3 class="text-lg font-medium text-gray-900 truncate">
                                                {{ $post->title ?: Str::limit($post->content, 50) }}
                                            </h3>
                                            
                                            @if($post->content_type === 'short')
                                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-purple-100 text-purple-800">
                                                    Short
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Status Badge -->
                                        <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium
                                            @if($post->status === 'published') bg-green-100 text-green-800
                                            @elseif($post->status === 'scheduled') bg-yellow-100 text-yellow-800
                                            @elseif($post->status === 'draft') bg-gray-100 text-gray-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </div>
                                    
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                        {{ $post->content }}
                                    </p>
                                    
                                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                        <span>{{ $post->socialAccount->account_name }}</span>
                                        <span>•</span>
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                        
                                        @if($post->scheduled_at)
                                            <span>•</span>
                                            <span class="text-yellow-600">
                                                Scheduled for {{ $post->scheduled_at->setTimezone(auth()->user()->timezone ?? 'UTC')->format('M j, Y g:i A') }}
                                                <span class="text-xs text-gray-500">({{ auth()->user()->timezone ?? 'UTC' }})</span>
                                            </span>
                                        @endif
                                        
                                        @if($post->published_at)
                                            <span>•</span>
                                            <span class="text-green-600">
                                                Published {{ $post->published_at->diffForHumans() }}
                                            </span>
                                        @endif

                                        <span>•</span>
                                        <span class="capitalize">{{ $post->visibility }}</span>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex-shrink-0 flex items-center space-x-2">
                                    @if($post->status === 'draft')
                                        <a href="{{ route('posts.edit', $post) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Continue Editing
                                        </a>
                                    @endif
                                    
                                    @if($post->status === 'scheduled')
                                        <form action="{{ route('posts.publish', $post) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                Publish Now
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('posts.show', $post) }}" class="text-gray-600 hover:text-gray-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    
                                    <div class="relative">
                                        <button class="text-gray-600 hover:text-gray-800" onclick="toggleDropdown({{ $post->id }})">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                            </svg>
                                        </button>
                                        
                                        <div id="dropdown-{{ $post->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg border border-gray-200 z-10">
                                            <a href="{{ route('posts.duplicate', $post) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                Duplicate
                                            </a>
                                            <a href="{{ route('posts.edit', $post) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                Edit
                                            </a>
                                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50" onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-3 border-t border-gray-200">
                    {{ $posts->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No posts yet</h3>
                    <p class="text-gray-500 mb-6">Get started by creating your first post.</p>
                    <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Your First Post
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleDropdown(postId) {
            const dropdown = document.getElementById(`dropdown-${postId}`);
            dropdown.classList.toggle('hidden');
            
            // Close other dropdowns
            document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                if (el.id !== `dropdown-${postId}`) {
                    el.classList.add('hidden');
                }
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('[onclick^="toggleDropdown"]')) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                    el.classList.add('hidden');
                });
            }
        });
    </script>
</x-app-layout>
