<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\SocialAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of posts
     */
    public function index()
    {
        $user = Auth::user();
        $posts = $user->posts()->with('socialAccount')->latest()->paginate(15);
        
        return view('posts.index', compact('posts'));
    }
    
    /**
     * Show the form for creating a new post
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $platform = $request->get('platform');
        
        // Get connected accounts
        $socialAccounts = $user->socialAccounts()->active()->get()->groupBy('platform');
        
        // Always use the main create view which handles all platforms dynamically
        return view('posts.create', compact('socialAccounts', 'platform'));
    }
    
    /**
     * Store a newly created post
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Debug: Log the incoming request data
        \Log::info('YouTube form submission:', $request->all());
        
        $validated = $request->validate([
            'selected_accounts' => 'required|string', // Comma-separated account IDs
            'title' => 'required|string|max:100',
            'content' => 'nullable|string|max:5000',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:1024000', // 1GB max
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // 10MB max
            'hashtags' => 'nullable|string',
            'youtube_content_type' => 'required|in:video,short',
            'youtube_category_id' => 'required|integer',
            'visibility' => 'required|in:public,unlisted',
            'schedule_type' => 'required|in:now,schedule',
            'schedule_date' => 'nullable|date|after_or_equal:today',
            'schedule_time' => 'nullable|date_format:H:i',
            'status' => 'in:draft,scheduled,published'
        ]);
        
        // Parse selected accounts
        $selectedAccountIds = explode(',', $validated['selected_accounts']);
        $selectedAccountIds = array_filter($selectedAccountIds); // Remove empty values
        
        if (empty($selectedAccountIds)) {
            return redirect()->back()->withErrors(['selected_accounts' => 'Please select at least one account.']);
        }
        
        // Handle scheduling with timezone
        $scheduledAt = null;
        if ($validated['schedule_type'] === 'schedule' && $validated['schedule_date'] && $validated['schedule_time']) {
            $userTimezone = $user->timezone ?? 'UTC';
            $scheduleDateTime = $validated['schedule_date'] . ' ' . $validated['schedule_time'];
            
            try {
                $scheduledAt = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $scheduleDateTime, $userTimezone)
                    ->utc(); // Convert to UTC for storage
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['schedule_time' => 'Invalid date/time format.']);
            }
            
            // Ensure scheduled time is in the future
            if ($scheduledAt->isPast()) {
                return redirect()->back()->withErrors(['schedule_time' => 'Scheduled time must be in the future.']);
            }
        }
        
        // Verify user owns all selected accounts
        $socialAccounts = SocialAccount::whereIn('id', $selectedAccountIds)
            ->where('user_id', $user->id)
            ->get();
            
        if ($socialAccounts->count() !== count($selectedAccountIds)) {
            return redirect()->back()->withErrors(['selected_accounts' => 'Invalid account selection.']);
        }
        
        // Handle file uploads
        $videoPath = null;
        $thumbnailPath = null;
        
        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('videos', 'public');
        }
        
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }
        
        \Log::info('File uploads completed:', ['video' => $videoPath, 'thumbnail' => $thumbnailPath]);
        
        // Create posts for each selected account
        $createdPosts = [];
        
        // Determine post status
        $postStatus = $validated['status'] ?? 'draft';
        if ($validated['schedule_type'] === 'schedule' && $scheduledAt) {
            $postStatus = 'scheduled';
        } elseif ($validated['schedule_type'] === 'now' && $postStatus !== 'draft') {
            $postStatus = 'published';
        }
        
        // Parse hashtags
        $hashtags = [];
        if (!empty($validated['hashtags'])) {
            preg_match_all('/#\w+/', $validated['hashtags'], $matches);
            $hashtags = $matches[0];
        }
        
        foreach ($socialAccounts as $account) {
            $post = Post::create([
                'user_id' => $user->id,
                'social_account_id' => $account->id,
                'title' => $validated['title'],
                'content' => $validated['content'] ?? '',
                'platform' => $account->platform,
                'post_type' => 'video', // Required field - set to video since we're uploading videos
                'content_type' => $validated['youtube_content_type'],
                'visibility' => $validated['visibility'],
                'scheduled_at' => $scheduledAt,
                'status' => $postStatus,
                'media_paths' => [
                    'video' => $videoPath,
                    'thumbnail' => $thumbnailPath
                ],
                'youtube_category_id' => $account->platform === 'youtube' ? $validated['youtube_category_id'] : null,
                'youtube_tags' => $account->platform === 'youtube' ? $hashtags : null,
                'youtube_is_short' => $account->platform === 'youtube' ? ($validated['youtube_content_type'] === 'short') : false,
                'metadata' => [
                    'hashtags' => $hashtags,
                    'is_short' => $validated['youtube_content_type'] === 'short',
                    'cross_post_group' => uniqid(), // Group related cross-posts
                    'original_timezone' => $user->timezone ?? 'UTC'
                ]
            ]);
            
            $createdPosts[] = $post;
        }
        
        // If not scheduled and not draft, publish immediately
        foreach ($createdPosts as $post) {
            if ($post->status === 'published' && !$post->scheduled_at) {
                $this->publishPost($post);
            }
        }
        
        $platformCount = $socialAccounts->count();
        $platformList = $socialAccounts->pluck('platform')->unique()->implode(', ');
        
        $message = "Post created successfully for {$platformCount} platform(s): {$platformList}!";
        
        if ($postStatus === 'scheduled' && $scheduledAt) {
            $userTimezone = $user->timezone ?? 'UTC';
            $localTime = $scheduledAt->setTimezone($userTimezone)->format('M j, Y \\a\\t g:i A T');
            $message .= " Scheduled for: {$localTime}";
        } elseif ($postStatus === 'published') {
            $message .= " Published immediately!";
        } else {
            $message .= " Saved as draft.";
        }
        
        return redirect()->route('posts.index')
            ->with('success', $message);
    }
    
    /**
     * Display the specified post
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        return view('posts.show', compact('post'));
    }
    
    /**
     * Show the form for editing the specified post
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $socialAccounts = Auth::user()->socialAccounts()->active()->get();
        return view('posts.edit', compact('post', 'socialAccounts'));
    }
    
    /**
     * Update the specified post
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'visibility' => 'required|in:public,unlisted,private',
            'scheduled_at' => 'nullable|date|after:now',
            'tags' => 'nullable|string',
        ]);
        
        $post->update($validated);
        
        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully!');
    }
    
    /**
     * Remove the specified post
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        
        // Delete associated files
        if ($post->media_paths) {
            if (isset($post->media_paths['video'])) {
                Storage::disk('public')->delete($post->media_paths['video']);
            }
            if (isset($post->media_paths['thumbnail'])) {
                Storage::disk('public')->delete($post->media_paths['thumbnail']);
            }
        }
        
        $post->delete();
        
        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully!');
    }
    
    /**
     * Publish a post immediately
     */
    public function publish(Post $post)
    {
        $this->authorize('update', $post);
        
        try {
            $this->publishPost($post);
            return redirect()->back()
                ->with('success', 'Post published successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to publish post: ' . $e->getMessage());
        }
    }
    
    /**
     * Retry publishing a failed post
     */
    public function retry(Post $post)
    {
        $this->authorize('update', $post);
        
        if ($post->status !== 'failed') {
            return redirect()->back()
                ->with('error', 'Only failed posts can be retried.');
        }
        
        try {
            $this->publishPost($post);
            return redirect()->back()
                ->with('success', 'Post published successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to publish post: ' . $e->getMessage());
        }
    }
    
    /**
     * Schedule a post
     */
    public function schedule(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        
        $validated = $request->validate([
            'scheduled_at' => 'required|date|after:now'
        ]);
        
        $post->update([
            'scheduled_at' => $validated['scheduled_at'],
            'status' => 'scheduled'
        ]);
        
        return redirect()->back()
            ->with('success', 'Post scheduled successfully!');
    }
    
    /**
     * Duplicate a post
     */
    public function duplicate(Post $post)
    {
        $this->authorize('view', $post);
        
        $newPost = $post->replicate();
        $newPost->title = $post->title . ' (Copy)';
        $newPost->status = 'draft';
        $newPost->scheduled_at = null;
        $newPost->published_at = null;
        $newPost->save();
        
        return redirect()->route('posts.edit', $newPost)
            ->with('success', 'Post duplicated successfully!');
    }
    
    /**
     * Actually publish the post to the platform
     */
    private function publishPost(Post $post)
    {
        try {
            switch ($post->platform) {
                case 'youtube':
                    $this->publishToYouTube($post);
                    break;
                    
                case 'facebook':
                    // TODO: Implement Facebook publishing
                    throw new \Exception('Facebook publishing not implemented yet');
                    
                case 'instagram':
                    // TODO: Implement Instagram publishing
                    throw new \Exception('Instagram publishing not implemented yet');
                    
                case 'tiktok':
                    // TODO: Implement TikTok publishing
                    throw new \Exception('TikTok publishing not implemented yet');
                    
                default:
                    throw new \Exception('Unsupported platform: ' . $post->platform);
            }
            
        } catch (\Exception $e) {
            \Log::error('Failed to publish post: ' . $e->getMessage(), [
                'post_id' => $post->id,
                'platform' => $post->platform
            ]);
            
            $post->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'retry_count' => $post->retry_count + 1
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Publish post to YouTube
     */
    private function publishToYouTube(Post $post)
    {
        $socialAccount = $post->socialAccount;
        
        // Check if token is expired and refresh if needed
        if ($socialAccount->isTokenExpired()) {
            if (!$socialAccount->refresh_token) {
                throw new \Exception('YouTube account needs to be reconnected');
            }
            $this->refreshYouTubeToken($socialAccount);
        }
        
        // Prepare video file path
        $videoPath = null;
        if ($post->media_paths && isset($post->media_paths['video'])) {
            $videoPath = storage_path('app/public/' . $post->media_paths['video']);
            
            if (!file_exists($videoPath)) {
                throw new \Exception('Video file not found: ' . $videoPath);
            }
        } else {
            throw new \Exception('No video file specified for upload');
        }
        
        // Prepare thumbnail path
        $thumbnailPath = null;
        if ($post->media_paths && isset($post->media_paths['thumbnail'])) {
            $thumbnailPath = storage_path('app/public/' . $post->media_paths['thumbnail']);
            
            if (!file_exists($thumbnailPath)) {
                \Log::warning('Thumbnail file not found: ' . $thumbnailPath);
                $thumbnailPath = null;
            }
        }
        
        \Log::info('Publishing to YouTube:', [
            'post_id' => $post->id,
            'title' => $post->title,
            'video_path' => $videoPath,
            'thumbnail_path' => $thumbnailPath,
            'is_short' => $post->youtube_is_short
        ]);
        
        // Create Google Client
        $client = new \Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setAccessToken($socialAccount->access_token);
        
        // Create YouTube service
        $youtube = new \Google_Service_YouTube($client);
        
        // Prepare video snippet
        $snippet = new \Google_Service_YouTube_VideoSnippet();
        $snippet->setTitle($post->title);
        $snippet->setDescription($post->content ?: '');
        $snippet->setCategoryId($post->youtube_category_id ?: '22'); // Default to People & Blogs
        
        // Add tags if available
        if ($post->youtube_tags && !empty($post->youtube_tags)) {
            $snippet->setTags($post->youtube_tags);
        }
        
        // Set privacy status
        $status = new \Google_Service_YouTube_VideoStatus();
        $status->setPrivacyStatus($post->visibility === 'unlisted' ? 'unlisted' : 'public');
        
        // Handle YouTube Shorts
        if ($post->youtube_is_short) {
            $snippet->setTitle('#Shorts ' . $post->title);
        }
        
        // Create video resource
        $video = new \Google_Service_YouTube_Video();
        $video->setSnippet($snippet);
        $video->setStatus($status);
        
        // Upload video
        $chunkSizeBytes = 1 * 1024 * 1024; // 1MB chunks
        
        $client->setDefer(true);
        $insertRequest = $youtube->videos->insert('status,snippet', $video);
        
        // Create media upload
        $media = new \Google_Http_MediaFileUpload(
            $client,
            $insertRequest,
            'video/*',
            null,
            true,
            $chunkSizeBytes
        );
        
        $media->setFileSize(filesize($videoPath));
        
        // Read and upload video in chunks
        $status = false;
        $handle = fopen($videoPath, 'rb');
        
        while (!$status && !feof($handle)) {
            $chunk = fread($handle, $chunkSizeBytes);
            $status = $media->nextChunk($chunk);
        }
        
        fclose($handle);
        
        $client->setDefer(false);
        
        if ($status === false) {
            throw new \Exception('Video upload failed');
        }
        
        $videoId = $status['id'];
        
        \Log::info('Video uploaded successfully:', [
            'post_id' => $post->id,
            'youtube_video_id' => $videoId
        ]);
        
        // Upload thumbnail if provided
        if ($thumbnailPath) {
            try {
                $thumbnailRequest = $youtube->thumbnails->set($videoId, [
                    'data' => file_get_contents($thumbnailPath),
                    'mimeType' => 'image/jpeg'
                ]);
                \Log::info('Thumbnail uploaded successfully for video: ' . $videoId);
            } catch (\Exception $e) {
                \Log::warning('Failed to upload thumbnail: ' . $e->getMessage());
            }
        }
        
        // Update post with YouTube video ID and mark as published
        $post->update([
            'status' => 'published',
            'published_at' => now(),
            'youtube_video_id' => $videoId,
            'platform_post_id' => $videoId,
            'error_message' => null
        ]);
        
        \Log::info('Post published successfully to YouTube:', [
            'post_id' => $post->id,
            'youtube_video_id' => $videoId,
            'channel_id' => $socialAccount->account_id
        ]);
    }
    
    /**
     * Refresh YouTube access token
     */
    private function refreshYouTubeToken(SocialAccount $account)
    {
        try {
            $client = new \GuzzleHttp\Client();
            
            $response = $client->post('https://oauth2.googleapis.com/token', [
                'form_params' => [
                    'client_id' => config('services.google.client_id'),
                    'client_secret' => config('services.google.client_secret'),
                    'refresh_token' => $account->refresh_token,
                    'grant_type' => 'refresh_token'
                ]
            ]);
            
            $data = json_decode($response->getBody(), true);
            
            $account->update([
                'access_token' => $data['access_token'],
                'token_expires_at' => now()->addSeconds($data['expires_in'] ?? 3600)
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Failed to refresh YouTube token: ' . $e->getMessage());
            throw new \Exception('Failed to refresh YouTube access token');
        }
    }
}
