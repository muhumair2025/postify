<!-- Enhanced YouTube Form -->
<div x-data="{
    contentType: 'video',
    title: '',
    description: '',
    hashtags: '',
    visibility: 'public',
    scheduleType: 'now',
    scheduleDate: '',
    scheduleTime: '',
    thumbnailFile: null,
    videoFile: null,
    category: '22',
    previewMode: 'mobile'
}" class="space-y-6">

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" onsubmit="return validateForm()">
        @csrf
        <input type="hidden" name="content_type" :value="contentType">
        <input type="hidden" name="selected_accounts" id="selected_accounts_input" value="">
        
        <!-- Validation Errors Display -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 p-4 mb-6">
                <div class="flex">
                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Content Type Selection -->
        <div class="bg-white p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Content Type</h3>
            <div class="grid grid-cols-2 gap-4">
                <label class="relative">
                    <input type="radio" x-model="contentType" value="video" name="youtube_content_type" class="sr-only">
                    <div class="p-4 border-2 cursor-pointer transition-all" 
                         :class="contentType === 'video' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300'">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            <div>
                                <h4 class="font-medium text-gray-900">Video</h4>
                                <p class="text-sm text-gray-500">Upload a regular video</p>
                            </div>
                        </div>
                    </div>
                </label>
                
                <label class="relative">
                    <input type="radio" x-model="contentType" value="short" name="youtube_content_type" class="sr-only">
                    <div class="p-4 border-2 cursor-pointer transition-all" 
                         :class="contentType === 'short' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300'">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9.5 7.5L14 12l-4.5 4.5V7.5z"/>
                                <rect x="6" y="4" width="2" height="16" rx="1"/>
                                <rect x="16" y="4" width="2" height="16" rx="1"/>
                            </svg>
                            <div>
                                <h4 class="font-medium text-gray-900">YouTube Short</h4>
                                <p class="text-sm text-gray-500">Vertical video under 60s</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        </div>

        <!-- Video Upload Section -->
        <div class="bg-white p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Video Upload</h3>
            
            <!-- File Upload Area -->
            <div class="border-2 border-dashed border-gray-300 p-8 text-center hover:border-gray-400 transition-colors">
                <input type="file" name="video_file" id="video-upload" accept="video/*" class="hidden" 
                       @change="videoFile = $event.target.files[0]">
                <label for="video-upload" class="cursor-pointer">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="mt-4">
                        <p class="text-lg text-gray-600">Click to upload video</p>
                        <p class="text-sm text-gray-500">or drag and drop</p>
                        <p class="text-xs text-gray-400 mt-2" x-show="contentType === 'short'">Max 60 seconds for YouTube Shorts</p>
                        <p class="text-xs text-gray-400 mt-2" x-show="contentType === 'video'">Supports MP4, MOV, AVI, WMV (max 256GB)</p>
                    </div>
                </label>
            </div>
            
            <div x-show="videoFile" class="mt-4 p-4 bg-green-50 border border-green-200">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-green-900" x-text="videoFile ? videoFile.name : ''"></span>
                </div>
            </div>
        </div>

        <!-- Optional Thumbnail Upload -->
        <div class="bg-white p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Custom Thumbnail (Optional)</h3>
            <div class="text-sm text-gray-600 mb-4">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Custom thumbnails require a verified YouTube channel. If not verified, YouTube will auto-generate thumbnails.</span>
                </div>
            </div>
            
            <!-- Thumbnail Upload Area -->
            <div class="border-2 border-dashed border-gray-300 p-6 text-center hover:border-gray-400 transition-colors">
                <input type="file" name="thumbnail" id="thumbnail-upload" accept="image/*" class="hidden" 
                       @change="thumbnailFile = $event.target.files[0]">
                <label for="thumbnail-upload" class="cursor-pointer">
                    <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div class="mt-2">
                        <p class="text-sm text-gray-600">Click to upload thumbnail</p>
                        <p class="text-xs text-gray-500">JPG, PNG (1280x720 recommended)</p>
                    </div>
                </label>
            </div>
            
            <div x-show="thumbnailFile" class="mt-4 p-4 bg-green-50 border border-green-200">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-green-900" x-text="thumbnailFile ? thumbnailFile.name : ''"></span>
                </div>
            </div>
        </div>

        <!-- Content Details -->
        <div class="bg-white p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Content Details</h3>
            
            <!-- Title -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <span x-text="contentType === 'short' ? 'Short Title' : 'Video Title'"></span>
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" x-model="title" name="title" 
                       class="w-full px-3 py-2 border border-gray-300 focus:ring-red-500 focus:border-red-500" 
                       placeholder="Enter your title..." maxlength="100" required>
                <div class="flex justify-between mt-1">
                    <span class="text-xs text-gray-500">Make it catchy and descriptive</span>
                    <span class="text-xs text-gray-400" x-text="title.length + '/100'"></span>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea x-model="description" name="content" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 focus:ring-red-500 focus:border-red-500"
                          placeholder="Tell viewers about your video..."></textarea>
                <div class="flex justify-between mt-1">
                    <span class="text-xs text-gray-500">Include relevant keywords</span>
                    <span class="text-xs text-gray-400" x-text="description.length + '/5000'"></span>
                </div>
            </div>

            <!-- Hashtags -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Hashtags</label>
                <input type="text" x-model="hashtags" name="hashtags" 
                       class="w-full px-3 py-2 border border-gray-300 focus:ring-red-500 focus:border-red-500" 
                       placeholder="#gaming #tutorial #funny (separate with spaces)">
                <div class="flex justify-between mt-1">
                    <span class="text-xs text-gray-500">Use relevant hashtags to improve discoverability</span>
                    <span class="text-xs text-gray-400" x-text="(hashtags.match(/#\\w+/g) || []).length + ' hashtags'"></span>
                </div>
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select x-model="category" name="youtube_category_id" class="w-full px-3 py-2 border border-gray-300 focus:ring-red-500 focus:border-red-500">
                    <option value="1">Film & Animation</option>
                    <option value="2">Autos & Vehicles</option>
                    <option value="10">Music</option>
                    <option value="15">Pets & Animals</option>
                    <option value="17">Sports</option>
                    <option value="19">Travel & Events</option>
                    <option value="20">Gaming</option>
                    <option value="22" selected>People & Blogs</option>
                    <option value="23">Comedy</option>
                    <option value="24">Entertainment</option>
                    <option value="25">News & Politics</option>
                    <option value="26">Howto & Style</option>
                    <option value="27">Education</option>
                    <option value="28">Science & Technology</option>
                </select>
            </div>
        </div>

        <!-- Visibility & Settings -->
        <div class="bg-white p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Visibility & Settings</h3>
            
            <!-- Visibility -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Who can see this video?</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="relative">
                        <input type="radio" x-model="visibility" value="public" name="visibility" class="sr-only">
                        <div class="p-4 border-2 cursor-pointer transition-all" 
                             :class="visibility === 'public' ? 'border-red-500 bg-red-50' : 'border-gray-200'">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <h4 class="font-medium text-gray-900">Public</h4>
                                    <p class="text-xs text-gray-500">Anyone can search for and view</p>
                                </div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="relative">
                        <input type="radio" x-model="visibility" value="unlisted" name="visibility" class="sr-only">
                        <div class="p-4 border-2 cursor-pointer transition-all" 
                             :class="visibility === 'unlisted' ? 'border-red-500 bg-red-50' : 'border-gray-200'">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"></path>
                                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-medium text-gray-900">Unlisted</h4>
                                    <p class="text-xs text-gray-500">Only people with the link</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <!-- Scheduling -->
        <div class="bg-white p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Publishing</h3>
            
            <div class="space-y-4">
                <!-- Schedule Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">When to publish?</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative">
                            <input type="radio" x-model="scheduleType" value="now" name="schedule_type" class="sr-only">
                            <div class="p-4 border-2 cursor-pointer transition-all" 
                                 :class="scheduleType === 'now' ? 'border-red-500 bg-red-50' : 'border-gray-200'">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h4 class="font-medium text-gray-900">Publish Now</h4>
                                        <p class="text-xs text-gray-500">Make live immediately</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative">
                            <input type="radio" x-model="scheduleType" value="schedule" name="schedule_type" class="sr-only">
                            <div class="p-4 border-2 cursor-pointer transition-all" 
                                 :class="scheduleType === 'schedule' ? 'border-red-500 bg-red-50' : 'border-gray-200'">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h4 class="font-medium text-gray-900">Schedule</h4>
                                        <p class="text-xs text-gray-500">Publish at specific time</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Schedule Date & Time -->
                <div x-show="scheduleType === 'schedule'" class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <input type="date" x-model="scheduleDate" name="schedule_date" 
                               class="w-full px-3 py-2 border border-gray-300 focus:ring-red-500 focus:border-red-500"
                               :min="new Date().toISOString().split('T')[0]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Time</label>
                        <input type="time" x-model="scheduleTime" name="schedule_time" 
                               class="w-full px-3 py-2 border border-gray-300 focus:ring-red-500 focus:border-red-500">
                    </div>
                </div>
                
                <div x-show="scheduleType === 'schedule'" class="text-xs text-gray-500">
                    <p>Time is in your timezone: {{ auth()->user()->timezone ?? 'UTC' }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white p-6 border border-gray-200">
            <div class="flex justify-between items-center">
                <button type="submit" name="status" value="draft" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                    Save as Draft
                </button>
                
                <div class="flex space-x-3">
                    <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 transition-colors">
                        Preview
                    </button>
                    
                    <button type="submit" name="status" :value="scheduleType === 'now' ? 'published' : 'scheduled'" 
                            class="px-6 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 transition-colors" 
                            x-text="scheduleType === 'now' ? 'Publish Now' : 'Schedule Post'">
                        Publish Now
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>