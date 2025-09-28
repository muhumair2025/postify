<!-- Instagram Form -->
<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    <input type="hidden" name="content_type" value="video" id="instagram-content-type">
    
    <h4 class="text-lg font-medium text-gray-900">Instagram Content</h4>
    
    <!-- Media Upload -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Media</label>
        <div class="border-2 border-dashed border-gray-300 p-6 text-center hover:border-gray-400 transition-colors">
            <input type="file" name="video_file" accept="video/*,image/*" class="hidden" id="instagram-media-upload">
            <label for="instagram-media-upload" class="cursor-pointer">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-lg font-medium text-gray-900">Click to upload media</p>
                <p class="text-sm text-gray-500">Photos, Videos, Reels</p>
            </label>
        </div>
    </div>

    <!-- Caption -->
    <div>
        <label for="instagram-content" class="block text-sm font-medium text-gray-700 mb-2">Caption</label>
        <textarea name="content" id="instagram-content" rows="4" 
                  class="block w-full border-gray-300 focus:ring-pink-500 focus:border-pink-500"
                  placeholder="Write a caption..." maxlength="2200"></textarea>
        <p class="text-xs text-gray-500 mt-1">0/2200 characters</p>
    </div>

    <!-- Hashtags -->
    <div>
        <label for="instagram-tags" class="block text-sm font-medium text-gray-700 mb-2">Hashtags</label>
        <input type="text" name="tags" id="instagram-tags" 
               class="block w-full border-gray-300 focus:ring-pink-500 focus:border-pink-500"
               placeholder="#hashtag #another #tag">
        <p class="text-xs text-gray-500 mt-1">Separate hashtags with spaces</p>
    </div>

    <!-- Alt Text -->
    <div>
        <label for="instagram-alt" class="block text-sm font-medium text-gray-700 mb-2">Alt Text (Optional)</label>
        <input type="text" name="alt_text" id="instagram-alt" 
               class="block w-full border-gray-300 focus:ring-pink-500 focus:border-pink-500"
               placeholder="Describe your image for accessibility">
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
        <button type="submit" name="status" value="draft" 
                class="px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            Save as Draft
        </button>
        
        <button type="submit" name="status" value="published" 
                class="px-6 py-2 border border-transparent text-sm font-medium text-white bg-pink-600 hover:bg-pink-700">
            Share Now
        </button>
    </div>
</form>
