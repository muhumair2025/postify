<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAccountController extends Controller
{
    /**
     * Display social accounts management page
     */
    public function index()
    {
        $user = Auth::user();
        $socialAccounts = $user->socialAccounts()->get()->groupBy('platform');
        
        $platforms = [
            'youtube' => [
                'name' => 'YouTube',
                'color' => 'red',
                'description' => 'Connect your YouTube channel to share videos and community posts'
            ],
            'facebook' => [
                'name' => 'Facebook',
                'color' => 'blue',
                'description' => 'Share posts to your Facebook pages and personal timeline'
            ],
            'instagram' => [
                'name' => 'Instagram',
                'color' => 'pink',
                'description' => 'Post photos and stories to your Instagram account'
            ],
            'tiktok' => [
                'name' => 'TikTok',
                'color' => 'gray',
                'description' => 'Share short videos to your TikTok account'
            ]
        ];
        
        return view('social-accounts.index', compact('socialAccounts', 'platforms'));
    }
    
    /**
     * Redirect to platform OAuth
     */
    public function connect(string $platform)
    {
        try {
            switch ($platform) {
                case 'youtube':
                    return Socialite::driver('google')
                        ->scopes([
                            'https://www.googleapis.com/auth/youtube.upload',
                            'https://www.googleapis.com/auth/youtube.readonly',
                            'https://www.googleapis.com/auth/youtube',
                            'https://www.googleapis.com/auth/youtube.force-ssl',
                            'https://www.googleapis.com/auth/youtubepartner-channel-audit'
                        ])
                        ->with([
                            'access_type' => 'offline',
                            'prompt' => 'consent'
                        ])
                        ->redirect();
                        
                case 'facebook':
                    return Socialite::driver('facebook')
                        ->scopes(['pages_show_list', 'pages_read_engagement'])
                        ->redirect();
                        
                case 'instagram':
                    return Socialite::driver('instagram')
                        ->redirect();
                        
                case 'tiktok':
                    return Socialite::driver('tiktok')
                        ->scopes(['user.info.basic', 'video.upload'])
                        ->redirect();
                        
                default:
                    return redirect()->back()->with('error', 'Platform not supported');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to connect to ' . ucfirst($platform) . ': ' . $e->getMessage());
        }
    }
    
    /**
     * Handle OAuth callback
     */
    public function callback(string $platform)
    {
        try {
            $user = Auth::user();
            
            switch ($platform) {
                case 'youtube':
                    $socialUser = Socialite::driver('google')->user();
                    
                    // Fetch YouTube channel data using YouTube API
                    $channelData = $this->fetchYouTubeChannelData($socialUser->token);
                    
                    \Log::info('YouTube OAuth callback - Channel data received:', [
                        'channel_count' => count($channelData),
                        'user_email' => $socialUser->getEmail(),
                        'has_token' => !empty($socialUser->token),
                        'has_refresh_token' => !empty($socialUser->refreshToken),
                        'refresh_token_length' => $socialUser->refreshToken ? strlen($socialUser->refreshToken) : 0,
                        'expires_in' => $socialUser->expiresIn ?? 'unknown'
                    ]);
                    
                    if (empty($channelData)) {
                        return redirect()->route('social-accounts.index')
                            ->with('error', 'Unable to access YouTube channel data. Please ensure you granted all necessary permissions during the authorization process and try connecting again.');
                    }
                    
                    // Store each channel as a separate social account to support multiple channels
                    $connectedChannels = 0;
                    foreach ($channelData as $channel) {
                        $existingAccount = SocialAccount::where([
                            'user_id' => $user->id,
                            'platform' => 'youtube',
                            'account_id' => $channel['id']
                        ])->first();
                        
                        if (!$existingAccount) {
                            SocialAccount::create([
                                'user_id' => $user->id,
                                'platform' => 'youtube',
                                'account_id' => $channel['id'],
                                'channel_id' => $channel['id'], // Add channel_id field
                                'username' => $channel['snippet']['title'],
                                'account_name' => $channel['snippet']['title'],
                                'account_email' => $socialUser->getEmail(),
                                'access_token' => $socialUser->token,
                                'refresh_token' => $socialUser->refreshToken,
                                'status' => 'active',
                                'account_data' => [
                                    'avatar' => $channel['snippet']['thumbnails']['default']['url'] ?? $socialUser->getAvatar(),
                                    'nickname' => $socialUser->getNickname(),
                                    'channel_id' => $channel['id'],
                                    'channel_handle' => $channel['snippet']['customUrl'] ?? '@' . strtolower(str_replace(' ', '', $channel['snippet']['title'])),
                                    'subscriber_count' => $channel['statistics']['subscriberCount'] ?? 0,
                                    'view_count' => $channel['statistics']['viewCount'] ?? 0,
                                    'video_count' => $channel['statistics']['videoCount'] ?? 0,
                                    'description' => $channel['snippet']['description'] ?? '',
                                    'published_at' => $channel['snippet']['publishedAt'] ?? null
                                ],
                                'token_expires_at' => now()->addSeconds($socialUser->expiresIn ?? 3600),
                                'is_active' => true
                            ]);
                            $connectedChannels++;
                        }
                    }
                    
                    if ($connectedChannels > 0) {
                        $message = $connectedChannels === 1 
                            ? 'YouTube channel connected successfully!' 
                            : "{$connectedChannels} YouTube channels connected successfully!";
                        return redirect()->route('social-accounts.index')->with('success', $message);
                    } else {
                        return redirect()->route('social-accounts.index')
                            ->with('info', 'All available YouTube channels are already connected.');
                    }
                        
                case 'facebook':
                    $socialUser = Socialite::driver('facebook')->user();
                    
                    SocialAccount::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'platform' => 'facebook',
                            'account_id' => $socialUser->getId()
                        ],
                        [
                            'account_name' => $socialUser->getName(),
                            'account_email' => $socialUser->getEmail(),
                            'access_token' => $socialUser->token,
                            'refresh_token' => $socialUser->refreshToken,
                            'account_data' => [
                                'avatar' => $socialUser->getAvatar(),
                                'nickname' => $socialUser->getNickname()
                            ],
                            'token_expires_at' => now()->addSeconds($socialUser->expiresIn ?? 3600),
                            'is_active' => true
                        ]
                    );
                    
                    return redirect()->route('social-accounts.index')
                        ->with('success', 'Facebook account connected successfully!');
                        
                case 'instagram':
                    $socialUser = Socialite::driver('instagram')->user();
                    
                    SocialAccount::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'platform' => 'instagram',
                            'account_id' => $socialUser->getId()
                        ],
                        [
                            'account_name' => $socialUser->getName(),
                            'account_email' => $socialUser->getEmail(),
                            'access_token' => $socialUser->token,
                            'refresh_token' => $socialUser->refreshToken,
                            'account_data' => [
                                'avatar' => $socialUser->getAvatar(),
                                'nickname' => $socialUser->getNickname()
                            ],
                            'token_expires_at' => now()->addSeconds($socialUser->expiresIn ?? 3600),
                            'is_active' => true
                        ]
                    );
                    
                    return redirect()->route('social-accounts.index')
                        ->with('success', 'Instagram account connected successfully!');
                        
                case 'tiktok':
                    $socialUser = Socialite::driver('tiktok')->user();
                    
                    SocialAccount::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'platform' => 'tiktok',
                            'account_id' => $socialUser->getId()
                        ],
                        [
                            'account_name' => $socialUser->getName() ?? $socialUser->getNickname(),
                            'username' => $socialUser->getNickname(),
                            'account_email' => $socialUser->getEmail(),
                            'access_token' => $socialUser->token,
                            'refresh_token' => $socialUser->refreshToken,
                            'account_data' => [
                                'avatar' => $socialUser->getAvatar(),
                                'nickname' => $socialUser->getNickname(),
                                'display_name' => $socialUser->getName()
                            ],
                            'token_expires_at' => now()->addSeconds($socialUser->expiresIn ?? 86400), // TikTok tokens usually last 24 hours
                            'is_active' => true
                        ]
                    );
                    
                    return redirect()->route('social-accounts.index')
                        ->with('success', 'TikTok account connected successfully!');
                        
                default:
                    return redirect()->route('social-accounts.index')
                        ->with('error', 'Platform not supported');
            }
        } catch (\Exception $e) {
            return redirect()->route('social-accounts.index')
                ->with('error', 'Failed to connect account: ' . $e->getMessage());
        }
    }
    
    /**
     * Refresh social account data and tokens
     */
    public function refresh(SocialAccount $socialAccount)
    {
        if ($socialAccount->user_id !== Auth::id()) {
            abort(403);
        }
        
        try {
            switch ($socialAccount->platform) {
                case 'youtube':
                    $this->refreshYouTubeData($socialAccount);
                    break;
                    
                case 'facebook':
                    $this->refreshFacebookData($socialAccount);
                    break;
                    
                case 'instagram':
                    $this->refreshInstagramData($socialAccount);
                    break;
                    
                case 'tiktok':
                    $this->refreshTikTokData($socialAccount);
                    break;
                    
                default:
                    return redirect()->route('social-accounts.index')
                        ->with('error', 'Refresh not supported for this platform');
            }
            
            return redirect()->route('social-accounts.index')
                ->with('success', ucfirst($socialAccount->platform) . ' account data refreshed successfully!');
                
        } catch (\Exception $e) {
            return redirect()->route('social-accounts.index')
                ->with('error', 'Failed to refresh account data: ' . $e->getMessage());
        }
    }
    
    /**
     * Disconnect social account
     */
    public function disconnect(SocialAccount $socialAccount)
    {
        if ($socialAccount->user_id !== Auth::id()) {
            abort(403);
        }
        
        $platform = $socialAccount->platform;
        $socialAccount->delete();
        
        return redirect()->route('social-accounts.index')
            ->with('success', ucfirst($platform) . ' account disconnected successfully!');
    }
    
    /**
     * Refresh YouTube account data
     */
    private function refreshYouTubeData(SocialAccount $account)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $maxRetries = 2;
            $currentRetry = 0;
            
            while ($currentRetry < $maxRetries) {
                try {
                    // If token is expired or this is a retry, refresh the token
                    if ($account->isTokenExpired() || $currentRetry > 0) {
                        if (!$account->refresh_token) {
                            \Log::warning('YouTube account missing refresh token', [
                                'account_id' => $account->id,
                                'channel_id' => $account->account_id,
                                'created_at' => $account->created_at,
                                'has_access_token' => !empty($account->access_token)
                            ]);
                            throw new \Exception('No refresh token available. This account was connected before refresh tokens were properly configured. Please disconnect and reconnect your YouTube account to enable automatic token refresh.');
                        }
                        $this->refreshAccessToken($account);
                        // Reload the account to get the updated token
                        $account->refresh();
                    }
                    
                    // Fetch specific channel data
                    $response = $client->get('https://www.googleapis.com/youtube/v3/channels', [
                        'query' => [
                            'part' => 'snippet,statistics,brandingSettings',
                            'id' => $account->account_id,
                            'maxResults' => 1
                        ],
                        'headers' => [
                            'Authorization' => 'Bearer ' . $account->access_token,
                            'Accept' => 'application/json'
                        ]
                    ]);
                    
                    $data = json_decode($response->getBody(), true);
                    
                    if (!empty($data['items'])) {
                        $channel = $data['items'][0];
                        
                        // Merge with existing account data to preserve fields
                        $existingData = $account->account_data ?? [];
                        
                        // Update account data
                        $account->update([
                            'account_data' => array_merge($existingData, [
                                'avatar' => $channel['snippet']['thumbnails']['default']['url'] ?? $existingData['avatar'] ?? null,
                                'channel_id' => $channel['id'],
                                'channel_handle' => $channel['snippet']['customUrl'] ?? $existingData['channel_handle'] ?? '@' . strtolower(str_replace(' ', '', $channel['snippet']['title'])),
                                'subscriber_count' => $channel['statistics']['subscriberCount'] ?? 0,
                                'view_count' => $channel['statistics']['viewCount'] ?? 0,
                                'video_count' => $channel['statistics']['videoCount'] ?? 0,
                                'description' => $channel['snippet']['description'] ?? '',
                                'published_at' => $channel['snippet']['publishedAt'] ?? $existingData['published_at'] ?? null,
                                'last_refreshed' => now()->toISOString()
                            ])
                        ]);
                        
                        return; // Success, exit the retry loop
                    } else {
                        throw new \Exception('No channel data found for this account.');
                    }
                    
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    if ($e->getResponse()->getStatusCode() === 401) {
                        // Unauthorized - token might be invalid, try refreshing
                        $currentRetry++;
                        if ($currentRetry >= $maxRetries) {
                            throw new \Exception('Authentication failed. Please reconnect your YouTube account.');
                        }
                        continue; // Retry with token refresh
                    } else {
                        throw $e;
                    }
                }
            }
            
        } catch (\Exception $e) {
            \Log::error('YouTube Refresh Error: ' . $e->getMessage(), [
                'account_id' => $account->id,
                'channel_id' => $account->account_id,
                'token_expired' => $account->isTokenExpired()
            ]);
            throw new \Exception('Failed to refresh YouTube data: ' . $e->getMessage());
        }
    }
    
    /**
     * Refresh Facebook account data
     */
    private function refreshFacebookData(SocialAccount $account)
    {
        // If token is expired, try to refresh using refresh token
        if ($account->isTokenExpired() && $account->refresh_token) {
            $this->refreshAccessToken($account);
        }
        
        // Facebook data refresh logic can be implemented here
        // For now, just update the token expiry
        $account->update([
            'token_expires_at' => now()->addDays(60)
        ]);
    }
    
    /**
     * Refresh Instagram account data
     */
    private function refreshInstagramData(SocialAccount $account)
    {
        // If token is expired, try to refresh using refresh token
        if ($account->isTokenExpired() && $account->refresh_token) {
            $this->refreshAccessToken($account);
        }
        
        // Instagram data refresh logic can be implemented here
        // For now, just update the token expiry
        $account->update([
            'token_expires_at' => now()->addDays(60)
        ]);
    }
    
    /**
     * Refresh TikTok account data
     */
    private function refreshTikTokData(SocialAccount $account)
    {
        try {
            // If token is expired, try to refresh using refresh token
            if ($account->isTokenExpired() && $account->refresh_token) {
                $this->refreshAccessToken($account);
                $account->refresh(); // Reload account with new token
            }
            
            // Fetch updated TikTok user info
            $client = new \GuzzleHttp\Client();
            
            $response = $client->get('https://open-api.tiktok.com/user/info/', [
                'query' => [
                    'access_token' => $account->access_token,
                    'fields' => 'open_id,union_id,avatar_url,display_name'
                ],
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]);
            
            $data = json_decode($response->getBody(), true);
            
            if (isset($data['data']['user'])) {
                $user = $data['data']['user'];
                
                // Update account data
                $account->update([
                    'account_data' => array_merge($account->account_data ?? [], [
                        'avatar' => $user['avatar_url'] ?? null,
                        'display_name' => $user['display_name'] ?? null,
                        'last_refreshed' => now()->toISOString()
                    ])
                ]);
            }
            
        } catch (\Exception $e) {
            \Log::warning('TikTok data refresh failed: ' . $e->getMessage(), [
                'account_id' => $account->id
            ]);
            
            // If refresh fails, just update the token expiry
            $account->update([
                'token_expires_at' => now()->addDay()
            ]);
        }
    }
    
    /**
     * Refresh access token using refresh token
     */
    private function refreshAccessToken(SocialAccount $account)
    {
        try {
            switch ($account->platform) {
                case 'youtube':
                    $client = new \GuzzleHttp\Client();
                    
                    \Log::info('Refreshing YouTube access token', [
                        'account_id' => $account->id,
                        'channel_id' => $account->account_id
                    ]);
                    
                    $response = $client->post('https://oauth2.googleapis.com/token', [
                        'form_params' => [
                            'client_id' => config('services.google.client_id'),
                            'client_secret' => config('services.google.client_secret'),
                            'refresh_token' => $account->refresh_token,
                            'grant_type' => 'refresh_token'
                        ],
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/x-www-form-urlencoded'
                        ]
                    ]);
                    
                    $data = json_decode($response->getBody(), true);
                    
                    if (isset($data['access_token'])) {
                        $account->update([
                            'access_token' => $data['access_token'],
                            'token_expires_at' => now()->addSeconds($data['expires_in'] ?? 3600)
                        ]);
                        
                        \Log::info('Successfully refreshed YouTube access token', [
                            'account_id' => $account->id,
                            'expires_in' => $data['expires_in'] ?? 3600
                        ]);
                    } else {
                        throw new \Exception('No access token in refresh response');
                    }
                    break;
                    
                case 'facebook':
                    // Facebook token refresh implementation
                    throw new \Exception('Facebook token refresh not implemented yet');
                    
                case 'instagram':
                    // Instagram token refresh implementation  
                    throw new \Exception('Instagram token refresh not implemented yet');
                    
                case 'tiktok':
                    $client = new \GuzzleHttp\Client();
                    
                    \Log::info('Refreshing TikTok access token', [
                        'account_id' => $account->id
                    ]);
                    
                    $response = $client->post('https://open-api.tiktok.com/oauth/refresh_token/', [
                        'form_params' => [
                            'client_key' => config('services.tiktok.client_id'),
                            'client_secret' => config('services.tiktok.client_secret'),
                            'refresh_token' => $account->refresh_token,
                            'grant_type' => 'refresh_token'
                        ],
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/x-www-form-urlencoded'
                        ]
                    ]);
                    
                    $data = json_decode($response->getBody(), true);
                    
                    if (isset($data['data']['access_token'])) {
                        $account->update([
                            'access_token' => $data['data']['access_token'],
                            'refresh_token' => $data['data']['refresh_token'] ?? $account->refresh_token,
                            'token_expires_at' => now()->addSeconds($data['data']['expires_in'] ?? 86400)
                        ]);
                        
                        \Log::info('Successfully refreshed TikTok access token', [
                            'account_id' => $account->id,
                            'expires_in' => $data['data']['expires_in'] ?? 86400
                        ]);
                    } else {
                        throw new \Exception('No access token in refresh response');
                    }
                    break;
                    
                default:
                    throw new \Exception('Platform not supported for token refresh');
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            \Log::error('Token Refresh HTTP Error: ' . $e->getMessage(), [
                'account_id' => $account->id,
                'response' => $responseBody,
                'status_code' => $e->getResponse()->getStatusCode()
            ]);
            
            $errorData = json_decode($responseBody, true);
            $errorMessage = $errorData['error_description'] ?? $errorData['error'] ?? 'Failed to refresh access token';
            
            throw new \Exception('Token refresh failed: ' . $errorMessage);
        } catch (\Exception $e) {
            \Log::error('Token Refresh Error: ' . $e->getMessage(), [
                'account_id' => $account->id,
                'platform' => $account->platform
            ]);
            throw new \Exception('Failed to refresh access token: ' . $e->getMessage());
        }
    }
    
    /**
     * Fetch YouTube channel data using YouTube API
     */
    private function fetchYouTubeChannelData($accessToken)
    {
        try {
            $client = new \GuzzleHttp\Client();
            
            \Log::info('Fetching YouTube channel data with access token: ' . substr($accessToken, 0, 20) . '...');
            
            // Fetch user's YouTube channels using reliable methods
            $channels = [];
            
            // Method 1: Get main channel (mine=true) - this always works
            $response = $client->get('https://www.googleapis.com/youtube/v3/channels', [
                'query' => [
                    'part' => 'snippet,statistics,brandingSettings',
                    'mine' => 'true',
                    'maxResults' => 50
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json'
                ]
            ]);
            
            $data = json_decode($response->getBody(), true);
            
            \Log::info('YouTube API response:', [
                'status_code' => $response->getStatusCode(),
                'items_count' => count($data['items'] ?? []),
                'has_error' => isset($data['error'])
            ]);
            
            if (isset($data['error'])) {
                \Log::error('YouTube API returned error:', $data['error']);
                return [];
            }
            
            if (!empty($data['items'])) {
                $channels = $data['items'];
            }
            
            // Method 2: Try to get additional channels using managedByMe parameter
            // This approach checks for Brand Accounts managed by the authenticated user
            try {
                // Get all channels managed by this authenticated user (Brand Accounts)
                $managedResponse = $client->get('https://www.googleapis.com/youtube/v3/channels', [
                    'query' => [
                        'part' => 'snippet,statistics,brandingSettings',
                        'managedByMe' => 'true',
                        'maxResults' => 50
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Accept' => 'application/json'
                    ]
                ]);
                
                $managedData = json_decode($managedResponse->getBody(), true);
                
                if (!empty($managedData['items'])) {
                    \Log::info('Found additional managed channels: ' . count($managedData['items']));
                    
                    // Add channels that are not already in our list
                    foreach ($managedData['items'] as $managedChannel) {
                        $exists = false;
                        foreach ($channels as $existingChannel) {
                            if ($existingChannel['id'] === $managedChannel['id']) {
                                $exists = true;
                                break;
                            }
                        }
                        if (!$exists) {
                            $channels[] = $managedChannel;
                            \Log::info('Added managed channel: ' . $managedChannel['snippet']['title']);
                        }
                    }
                }
            } catch (\Exception $e) {
                \Log::info('Could not fetch managed channels (this is normal for personal channels): ' . $e->getMessage());
            }
            
            // Method 3: Try getting channels using forContentOwner if available (for content owners)
            try {
                // This method works for YouTube Content ID partners who manage multiple channels
                $contentOwnerResponse = $client->get('https://www.googleapis.com/youtube/v3/channels', [
                    'query' => [
                        'part' => 'snippet,statistics,brandingSettings',
                        'forContentOwner' => 'true',
                        'maxResults' => 50
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Accept' => 'application/json'
                    ]
                ]);
                
                $contentOwnerData = json_decode($contentOwnerResponse->getBody(), true);
                
                if (!empty($contentOwnerData['items'])) {
                    \Log::info('Found content owner channels: ' . count($contentOwnerData['items']));
                    
                    // Add channels that are not already in our list
                    foreach ($contentOwnerData['items'] as $ownerChannel) {
                        $exists = false;
                        foreach ($channels as $existingChannel) {
                            if ($existingChannel['id'] === $ownerChannel['id']) {
                                $exists = true;
                                break;
                            }
                        }
                        if (!$exists) {
                            $channels[] = $ownerChannel;
                            \Log::info('Added content owner channel: ' . $ownerChannel['snippet']['title']);
                        }
                    }
                }
            } catch (\Exception $e) {
                \Log::info('Could not fetch content owner channels (this is normal for non-partners): ' . $e->getMessage());
            }
            
            // Log detailed information about found channels for debugging
            \Log::info('Channel discovery complete. Found channels:', [
                'total_channels' => count($channels),
                'channel_details' => array_map(function($channel) {
                    return [
                        'id' => $channel['id'],
                        'title' => $channel['snippet']['title'],
                        'custom_url' => $channel['snippet']['customUrl'] ?? 'none'
                    ];
                }, $channels)
            ]);
            
            \Log::info('Total unique channels found: ' . count($channels));
            
            return $channels;
            
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $errorBody = $response->getBody()->getContents();
            
            \Log::error('YouTube API Client Error:', [
                'status_code' => $statusCode,
                'error_body' => $errorBody,
                'message' => $e->getMessage()
            ]);
            
            return [];
        } catch (\Exception $e) {
            \Log::error('YouTube API Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
    }
}
