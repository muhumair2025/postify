<!-- Facebook Form -->
<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    <input type="hidden" name="content_type" value="video" id="facebook-content-type">
    
    <h4 class="text-lg font-medium text-gray-900">Facebook Content</h4>
    
    <!-- Media Upload -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Media</label>
        <div class="border-2 border-dashed border-gray-300 p-6 text-center hover:border-gray-400 transition-colors">
            <input type="file" name="video_file" accept="video/*,image/*" class="hidden" id="facebook-media-upload">
            <label for="facebook-media-upload" class="cursor-pointer">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-lg font-medium text-gray-900">Click to upload media</p>
                <p class="text-sm text-gray-500">Images, Videos (Max: 500MB)</p>
            </label>
        </div>
    </div>

    <!-- Post Content -->
    <div>
        <label for="facebook-content" class="block text-sm font-medium text-gray-700 mb-2">What's on your mind?</label>
        <textarea name="content" id="facebook-content" rows="4" 
                  class="block w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Share your thoughts..." maxlength="5000"></textarea>
        <p class="text-xs text-gray-500 mt-1">0/5000 characters</p>
    </div>

    <!-- Visibility -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Audience</label>
        <div class="space-y-2">
            <label class="flex items-center">
                <input type="radio" name="visibility" value="public" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                <span class="ml-2 text-sm text-gray-700">Public</span>
            </label>
            <label class="flex items-center">
                <input type="radio" name="visibility" value="friends" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                <span class="ml-2 text-sm text-gray-700">Friends</span>
            </label>
            <label class="flex items-center">
                <input type="radio" name="visibility" value="private" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
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
                class="px-6 py-2 border border-transparent text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
            Post Now
        </button>
    </div>
</form>
