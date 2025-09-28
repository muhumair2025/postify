<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\SocialAccount;
use App\Models\ScheduledPost;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();
        
        // Get dashboard statistics
        $stats = [
            'total_posts' => $user->posts()->count(),
            'scheduled_posts' => $user->posts()->scheduled()->count(),
            'published_posts' => $user->posts()->status('published')->count(),
            'connected_accounts' => $user->socialAccounts()->active()->count(),
        ];

        // Get recent posts
        $recentPosts = $user->posts()
            ->with(['socialAccount'])
            ->latest()
            ->limit(5)
            ->get();

        // Get upcoming scheduled posts
        $upcomingPosts = $user->posts()
            ->scheduled()
            ->with(['socialAccount', 'scheduledPost'])
            ->whereHas('scheduledPost', function($query) {
                $query->pending();
            })
            ->orderBy('scheduled_at')
            ->limit(5)
            ->get();

        // Get connected social accounts
        $socialAccounts = $user->socialAccounts()
            ->active()
            ->get()
            ->groupBy('platform');

        return view('dashboard', compact(
            'stats',
            'recentPosts', 
            'upcomingPosts',
            'socialAccounts'
        ));
    }

    /**
     * Show the calendar view.
     */
    public function calendar(): View
    {
        $user = auth()->user();
        
        // Get all social accounts for the dropdown
        $socialAccounts = $user->socialAccounts()->get();
        
        // Debug: Log account information
        \Log::info('Calendar: User has ' . $socialAccounts->count() . ' social accounts');
        foreach ($socialAccounts as $account) {
            \Log::info('Account: ' . $account->platform . ' - ' . $account->username . ' (Status: ' . $account->status . ')');
        }

        // Get posts for calendar (expand to show 6 months for better navigation)
        $posts = $user->posts()
            ->with(['socialAccount', 'scheduledPost'])
            ->whereNotNull('scheduled_at')
            ->whereBetween('scheduled_at', [
                now()->subMonths(3)->startOfMonth(),
                now()->addMonths(3)->endOfMonth()
            ])
            ->get();

        // Get YouTube videos from connected accounts
        $youtubeVideos = [];
        $youtubeAccounts = $user->socialAccounts()
            ->where('platform', 'youtube')
            ->get(); // Remove status filter to see all YouTube accounts

        \Log::info('Found ' . $youtubeAccounts->count() . ' YouTube accounts');
        
        foreach ($youtubeAccounts as $account) {
            \Log::info("Processing YouTube account {$account->id} - Channel: {$account->channel_id}, Has token: " . ($account->access_token ? 'Yes' : 'No'));
            
            if ($account->access_token) {
                // If channel_id is missing, try to fetch it
                if (empty($account->channel_id)) {
                    \Log::info("Channel ID missing for account {$account->id}, attempting to fetch it");
                    $channelId = $this->getYouTubeChannelId($account);
                    if ($channelId) {
                        try {
                            $account->channel_id = $channelId;
                            $account->save();
                            \Log::info("Fetched and saved channel ID: {$channelId} for account {$account->id}");
                        } catch (\Exception $e) {
                            \Log::error("Failed to save channel ID for account {$account->id}: " . $e->getMessage());
                            // Continue without the channel_id - we'll use account_id as fallback
                        }
                    } else {
                        \Log::warning("Could not fetch channel ID for account {$account->id}");
                        continue;
                    }
                }
                
                $videos = $this->fetchYouTubeVideos($account);
                \Log::info("Retrieved " . count($videos) . " videos from account {$account->id}");
                
                // Add account info to each video
                foreach ($videos as &$video) {
                    $video['social_account_id'] = $account->id;
                    $video['social_account'] = [
                        'id' => $account->id,
                        'platform' => 'youtube',
                        'username' => $account->username
                    ];
                }
                $youtubeVideos = array_merge($youtubeVideos, $videos);
            } else {
                \Log::warning("YouTube account {$account->id} missing access token");
            }
        }
        
        \Log::info('Total YouTube videos collected: ' . count($youtubeVideos));

        // Check for accounts with connection issues (only show warning if no videos were fetched AND there are YouTube accounts)
        $hasYouTubeConnectionIssues = false;
        $hasYouTubeAccounts = $socialAccounts->where('platform', 'youtube')->count() > 0;
        
        \Log::info("Connection check - YouTube accounts: {$hasYouTubeAccounts}, Videos fetched: " . count($youtubeVideos));
        
        // Only flag as having issues if:
        // 1. There are YouTube accounts, AND
        // 2. No videos were fetched, AND 
        // 3. We actually tried to fetch videos (account has access_token)
        if ($hasYouTubeAccounts && count($youtubeVideos) === 0) {
            // Check if any YouTube account tried but failed to fetch videos
            foreach ($socialAccounts as $account) {
                if ($account->platform === 'youtube' && $account->access_token) {
                    \Log::info("Flagging connection issues for YouTube account {$account->id} - has token but no videos fetched");
                    $hasYouTubeConnectionIssues = true;
                    break;
                }
            }
        }
        
        \Log::info("Final connection status - hasYouTubeConnectionIssues: " . ($hasYouTubeConnectionIssues ? 'true' : 'false'));

        return view('calendar.calendar', compact('posts', 'youtubeVideos', 'socialAccounts', 'hasYouTubeConnectionIssues'));
    }

    /**
     * Get YouTube channel ID for an account
     */
    private function getYouTubeChannelId($account): ?string
    {
        try {
            // Check if Google API client classes exist
            if (!class_exists('\Google_Client') || !class_exists('\Google_Service_YouTube')) {
                \Log::warning('Google API client not available for YouTube integration');
                return null;
            }
            
            $client = new \Google_Client();
            $client->setAccessToken($account->access_token);
            
            // Check if token is valid and refresh if possible
            if ($client->isAccessTokenExpired()) {
                \Log::info("Access token expired for YouTube account {$account->id}, attempting to refresh");
                
                // Try to refresh the token if refresh token is available
                if ($account->refresh_token) {
                    try {
                        $client->setRefreshToken($account->refresh_token);
                        $newToken = $client->fetchAccessTokenWithRefreshToken();
                        
                        if (isset($newToken['access_token'])) {
                            // Update the account with new token
                            $account->access_token = json_encode($newToken);
                            $account->save();
                            \Log::info("Successfully refreshed access token for account {$account->id}");
                            
                            // Set the new token
                            $client->setAccessToken($newToken);
                        } else {
                            \Log::warning("Failed to refresh token for YouTube account {$account->id}");
                            return null;
                        }
                    } catch (\Exception $e) {
                        \Log::error("Error refreshing token for account {$account->id}: " . $e->getMessage());
                        return null;
                    }
                } else {
                    \Log::warning("No refresh token available for YouTube account {$account->id}. User needs to reconnect.");
                    return null;
                }
            }
            
            $youtube = new \Google_Service_YouTube($client);
            
            // Get channel information for the authenticated user
            $channelResponse = $youtube->channels->listChannels('id,snippet', [
                'mine' => true
            ]);
            
            if (!empty($channelResponse->items)) {
                $channel = $channelResponse->items[0];
                \Log::info("Found channel: {$channel->id} - {$channel->snippet->title}");
                return $channel->id;
            }
            
            \Log::warning("No channel found for account {$account->id}");
            return null;
            
        } catch (\Exception $e) {
            \Log::error('Failed to fetch YouTube channel ID for account ' . $account->id . ': ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Fetch YouTube videos for a given account
     */
    private function fetchYouTubeVideos($account): array
    {
        try {
            \Log::info("Fetching YouTube videos for account {$account->id} - Channel: {$account->channel_id}");
            
            // Check if Google API client classes exist
            if (!class_exists('\Google_Client') || !class_exists('\Google_Service_YouTube')) {
                \Log::warning('Google API client not available for YouTube integration');
                return [];
            }
            
            $client = new \Google_Client();
            $client->setAccessToken($account->access_token);
            
            // Check if token is valid and refresh if possible
            if ($client->isAccessTokenExpired()) {
                \Log::info("Access token expired for YouTube account {$account->id}, attempting to refresh");
                
                // Try to refresh the token if refresh token is available
                if ($account->refresh_token) {
                    try {
                        $client->setRefreshToken($account->refresh_token);
                        $newToken = $client->fetchAccessTokenWithRefreshToken();
                        
                        if (isset($newToken['access_token'])) {
                            // Update the account with new token
                            $account->access_token = json_encode($newToken);
                            $account->save();
                            \Log::info("Successfully refreshed access token for account {$account->id}");
                            
                            // Set the new token
                            $client->setAccessToken($newToken);
                        } else {
                            \Log::warning("Failed to refresh token for YouTube account {$account->id}");
                            return [];
                        }
                    } catch (\Exception $e) {
                        \Log::error("Error refreshing token for account {$account->id}: " . $e->getMessage());
                        return [];
                    }
                } else {
                    \Log::warning("No refresh token available for YouTube account {$account->id}. User needs to reconnect.");
                    return [];
                }
            }
            
            $youtube = new \Google_Service_YouTube($client);
            \Log::info("YouTube client initialized successfully");
            
            // Get channel uploads playlist (use channel_id or account_id as fallback)
            $channelId = $account->channel_id ?: $account->account_id;
            \Log::info("Using channel ID: {$channelId}");
            
            $channelResponse = $youtube->channels->listChannels('contentDetails', [
                'id' => $channelId
            ]);
            
            \Log::info("Channel response received - Items count: " . count($channelResponse->items));
            
            if (empty($channelResponse->items)) {
                \Log::warning("No channel found for ID: {$channelId}");
                return [];
            }
            
            $uploadsPlaylistId = $channelResponse->items[0]->contentDetails->relatedPlaylists->uploads;
            \Log::info("Uploads playlist ID: {$uploadsPlaylistId}");
            
            // Get recent videos from uploads playlist (remove date filter initially for debugging)
            $playlistResponse = $youtube->playlistItems->listPlaylistItems('snippet', [
                'playlistId' => $uploadsPlaylistId,
                'maxResults' => 50 // YouTube API max per request
                // Temporarily remove date filter to see all videos
            ]);
            
            \Log::info("Initial playlist response - Items count: " . count($playlistResponse->items));
            
            // Get additional pages if available (up to 200 total videos)
            $allItems = $playlistResponse->items;
            $pageToken = $playlistResponse->nextPageToken ?? null;
            $pageCount = 1;
            
            while ($pageToken && $pageCount < 4) { // Max 4 pages = 200 videos
                $nextPageResponse = $youtube->playlistItems->listPlaylistItems('snippet', [
                    'playlistId' => $uploadsPlaylistId,
                    'maxResults' => 50,
                    'pageToken' => $pageToken
                ]);
                
                $allItems = array_merge($allItems, $nextPageResponse->items);
                $pageToken = $nextPageResponse->nextPageToken ?? null;
                $pageCount++;
                \Log::info("Page {$pageCount} - Added " . count($nextPageResponse->items) . " items. Total: " . count($allItems));
            }
            
            \Log::info("Total items fetched: " . count($allItems));
            
            // Get video IDs for detailed information
            $videoIds = [];
            foreach ($allItems as $item) {
                $videoIds[] = $item->snippet->resourceId->videoId;
            }
            
            \Log::info("Video IDs to fetch details for: " . count($videoIds));
            
            // Fetch detailed video information including privacy status
            $videoDetails = [];
            if (!empty($videoIds)) {
                // Process in batches of 50 (YouTube API limit)
                $batches = array_chunk($videoIds, 50);
                
                foreach ($batches as $batchIndex => $batch) {
                    \Log::info("Fetching batch " . ($batchIndex + 1) . " with " . count($batch) . " video IDs");
                    
                    $videoResponse = $youtube->videos->listVideos('snippet,status', [
                        'id' => implode(',', $batch)
                    ]);
                    
                    \Log::info("Video details response - Items count: " . count($videoResponse->items));
                    
                    foreach ($videoResponse->items as $video) {
                        $videoDetails[$video->id] = $video;
                    }
                }
            }
            
            \Log::info("Total video details fetched: " . count($videoDetails));
            
            $videos = [];
            foreach ($allItems as $item) {
                $videoId = $item->snippet->resourceId->videoId;
                $videoDetail = $videoDetails[$videoId] ?? null;
                
                // Include all videos regardless of privacy status (public, unlisted, private)
                $privacyStatus = $videoDetail->status->privacyStatus ?? 'unknown';
                
                $videos[] = [
                    'video_id' => $videoId,
                    'title' => $item->snippet->title,
                    'description' => $item->snippet->description,
                    'published_at' => $item->snippet->publishedAt,
                    'scheduled_at' => $item->snippet->publishedAt, // Use published date as scheduled date
                    'thumbnail_url' => $item->snippet->thumbnails->medium->url ?? null,
                    'platform' => 'youtube',
                    'channel_id' => $account->channel_id,
                    'channel_title' => $item->snippet->channelTitle,
                    'privacy_status' => $privacyStatus,
                    'is_unlisted' => $privacyStatus === 'unlisted',
                    'is_private' => $privacyStatus === 'private',
                    'content' => $item->snippet->title, // Use title as content for calendar display
                    'status' => 'published', // Mark as published since these are already live
                ];
            }
            
            \Log::info("Final video count for account {$account->id}: " . count($videos));
            
            return $videos;
            
        } catch (\Exception $e) {
            // Log error and return empty array
            \Log::error('Failed to fetch YouTube videos for account ' . $account->id . ': ' . $e->getMessage());
            \Log::error('Exception details: ' . $e->getTraceAsString());
            return [];
        }
    }
}
