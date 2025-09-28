<!-- TikTok Form -->
<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    <input type="hidden" name="content_type" value="short" id="tiktok-content-type">
    
    <h4 class="text-lg font-medium text-gray-900">TikTok Content</h4>
    
    <!-- Video Upload -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Video</label>
        <div class="border-2 border-dashed border-gray-300 p-6 text-center hover:border-gray-400 transition-colors">
            <input type="file" name="video_file" accept="video/*" class="hidden" id="tiktok-video-upload">
            <label for="tiktok-video-upload" class="cursor-pointer">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <p class="text-lg font-medium text-gray-900">Click to upload video</p>
                <p class="text-sm text-gray-500">Vertical videos (9:16) ≤ 60 seconds</p>
            </label>
        </div>
    </div>

    <!-- Caption -->
    <div>
        <label for="tiktok-content" class="block text-sm font-medium text-gray-700 mb-2">Caption</label>
        <textarea name="content" id="tiktok-content" rows="3" 
                  class="block w-full border-gray-300 focus:ring-black focus:border-black"
                  placeholder="Describe your video..." maxlength="150"></textarea>
        <p class="text-xs text-gray-500 mt-1">0/150 characters</p>
    </div>

    <!-- Hashtags -->
    <div>
        <label for="tiktok-tags" class="block text-sm font-medium text-gray-700 mb-2">Hashtags</label>
        <input type="text" name="tags" id="tiktok-tags" 
               class="block w-full border-gray-300 focus:ring-black focus:border-black"
               placeholder="#fyp #viral #trending">
        <p class="text-xs text-gray-500 mt-1">Use trending hashtags to increase visibility</p>
    </div>

    <!-- Privacy Settings -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Privacy</label>
        <div class="space-y-2">
            <label class="flex items-center">
                <input type="radio" name="visibility" value="public" class="h-4 w-4 text-black focus:ring-gray-500 border-gray-300" checked>
                <span class="ml-2 text-sm text-gray-700">Everyone</span>
            </label>
            <label class="flex items-center">
                <input type="radio" name="visibility" value="friends" class="h-4 w-4 text-black focus:ring-gray-500 border-gray-300">
                <span class="ml-2 text-sm text-gray-700">Friends</span>
            </label>
            <label class="flex items-center">
                <input type="radio" name="visibility" value="private" class="h-4 w-4 text-black focus:ring-gray-500 border-gray-300">
                <span class="ml-2 text-sm text-gray-700">Only me</span>
            </label>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
        <button type="submit" name="status" value="draft" 
                class="px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            Save as Draft
        </button>
        
        <button type="submit" name="status" value="published" 
                class="px-6 py-2 border border-transparent text-sm font-medium text-white bg-black hover:bg-gray-800">
            Post Now
        </button>
    </div>
</form>
