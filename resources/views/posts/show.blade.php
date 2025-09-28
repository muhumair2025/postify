<x-app-layout>
    <x-slot name="title">Post Details</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Posted to {{ ucfirst($post->platform) }} • 
                            @if($post->published_at)
                                Published {{ $post->published_at->diffForHumans() }}
                            @elseif($post->scheduled_at)
                                Scheduled for {{ $post->scheduled_at->setTimezone(auth()->user()->timezone ?? 'UTC')->format('M j, Y \a\t g:i A') }} ({{ auth()->user()->timezone ?? 'UTC' }})
                            @else
                                {{ ucfirst($post->status) }}
                            @endif
                        </p>
                    </div>
                    
                    <!-- Status Badge -->
                    <div>
                        @if($post->status === 'published')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Published
                            </span>
                        @elseif($post->status === 'scheduled')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Scheduled
                            </span>
                        @elseif($post->status === 'failed')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.96-.833-2.73 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                Failed
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ ucfirst($post->status) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Post Content -->
                <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Content</h2>
                    @if($post->content)
                        <div class="prose max-w-none">
                            <p class="text-gray-700 whitespace-pre-line">{{ $post->content }}</p>
                        </div>
                    @else
                        <p class="text-gray-500 italic">No description provided</p>
                    @endif
                </div>

                <!-- Media Preview -->
                @if($post->media_paths)
                    <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Media</h2>
                        
                        @if(isset($post->media_paths['video']))
                            <div class="mb-4">
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Video</h3>
                                <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden">
                                    <video controls class="w-full h-full object-cover">
                                        <source src="{{ Storage::url($post->media_paths['video']) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        @endif
                        
                        @if(isset($post->media_paths['thumbnail']))
                            <div class="mb-4">
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Thumbnail</h3>
                                <img src="{{ Storage::url($post->media_paths['thumbnail']) }}" 
                                     alt="Video thumbnail" 
                                     class="max-w-xs rounded-lg border border-gray-200">
                            </div>
                        @endif
                    </div>
                @endif

                <!-- YouTube Success -->
                @if($post->platform === 'youtube' && $post->youtube_video_id)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-green-800">Successfully Published to YouTube!</h3>
                                <p class="mt-1 text-sm text-green-700">Your video is now live on your YouTube channel.</p>
                                <div class="mt-3">
                                    <a href="https://youtube.com/watch?v={{ $post->youtube_video_id }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                        </svg>
                                        View on YouTube
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Error Message -->
                @if($post->status === 'failed' && $post->error_message)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-red-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.96-.833-2.73 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-red-800">Publishing Failed</h3>
                                <p class="mt-1 text-sm text-red-700">{{ $post->error_message }}</p>
                                <div class="mt-3">
                                    <form action="{{ route('posts.retry', $post) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Retry Publishing
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Post Details -->
                <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Post Details</h2>
                    
                    <dl class="space-y-3 text-sm">
                        <div>
                            <dt class="font-medium text-gray-700">Platform</dt>
                            <dd class="mt-1 text-gray-900 capitalize">{{ $post->platform }}</dd>
                        </div>
                        
                        <div>
                            <dt class="font-medium text-gray-700">Type</dt>
                            <dd class="mt-1 text-gray-900 capitalize">
                                {{ $post->content_type ?: $post->post_type }}
                                @if($post->youtube_is_short)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        Short
                                    </span>
                                @endif
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="font-medium text-gray-700">Visibility</dt>
                            <dd class="mt-1 text-gray-900 capitalize">{{ $post->visibility }}</dd>
                        </div>
                        
                        @if($post->youtube_category_id)
                        <div>
                            <dt class="font-medium text-gray-700">Category</dt>
                            <dd class="mt-1 text-gray-900">Category {{ $post->youtube_category_id }}</dd>
                        </div>
                        @endif
                        
                        <div>
                            <dt class="font-medium text-gray-700">Created</dt>
                            <dd class="mt-1 text-gray-900">{{ $post->created_at->format('M j, Y \a\t g:i A') }}</dd>
                        </div>
                        
                        @if($post->published_at)
                        <div>
                            <dt class="font-medium text-gray-700">Published</dt>
                            <dd class="mt-1 text-gray-900">{{ $post->published_at->format('M j, Y \a\t g:i A') }}</dd>
                        </div>
                        @endif
                        
                        @if($post->scheduled_at)
                        <div>
                            <dt class="font-medium text-gray-700">Scheduled For</dt>
                            <dd class="mt-1 text-gray-900">
                                {{ $post->scheduled_at->setTimezone(auth()->user()->timezone ?? 'UTC')->format('M j, Y \a\t g:i A') }}
                                <span class="text-sm text-gray-500">({{ auth()->user()->timezone ?? 'UTC' }})</span>
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <!-- Tags -->
                @if($post->youtube_tags && !empty($post->youtube_tags))
                <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Tags</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->youtube_tags as $tag)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Connected Account -->
                <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Connected Account</h2>
                    @if($post->socialAccount)
                        <div class="flex items-center space-x-3">
                            @if($post->socialAccount->account_data && isset($post->socialAccount->account_data['avatar']))
                                <img src="{{ $post->socialAccount->account_data['avatar'] }}" 
                                     alt="Profile" 
                                     class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <span class="text-red-600 font-medium text-sm">
                                        {{ substr($post->socialAccount->account_name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $post->socialAccount->account_name }}</p>
                                <p class="text-xs text-gray-500">{{ $post->socialAccount->account_email }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions</h2>
                    <div class="space-y-3">
                        <a href="{{ route('posts.edit', $post) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Post
                        </a>
                        
                        @if($post->status === 'failed')
                            <form action="{{ route('posts.retry', $post) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Retry Publishing
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('posts.duplicate', $post) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Duplicate
                        </a>
                        
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this post?')"
                              class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 text-sm font-medium text-red-700 bg-white hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete Post
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="flex justify-start">
            <a href="{{ route('posts.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Posts
            </a>
        </div>
    </div>
</x-app-layout>
