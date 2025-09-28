<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'social_account_id',
        'platform',
        'post_type',
        'content_type',
        'title',
        'content',
        'media_files',
        'media_paths',
        'hashtags',
        'visibility',
        'platform_specific_data',
        'metadata',
        'status',
        'scheduled_at',
        'published_at',
        'platform_post_id',
        'youtube_video_id',
        'youtube_privacy_status',
        'youtube_category_id',
        'youtube_tags',
        'youtube_is_short',
        'error_message',
        'retry_count',
    ];

    protected function casts(): array
    {
        return [
            'media_files' => 'array',
            'media_paths' => 'array',
            'hashtags' => 'array',
            'platform_specific_data' => 'array',
            'metadata' => 'array',
            'youtube_tags' => 'array',
            'youtube_is_short' => 'boolean',
            'scheduled_at' => 'datetime',
            'published_at' => 'datetime',
            'retry_count' => 'integer',
        ];
    }

    /**
     * Get the user that owns the post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the social account for the post.
     */
    public function socialAccount(): BelongsTo
    {
        return $this->belongsTo(SocialAccount::class);
    }

    /**
     * Get the scheduled post information.
     */
    public function scheduledPost(): HasOne
    {
        return $this->hasOne(ScheduledPost::class);
    }

    /**
     * Scope to get posts by status
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get posts by platform
     */
    public function scopePlatform($query, string $platform)
    {
        return $query->where('platform', $platform);
    }

    /**
     * Scope to get scheduled posts
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')->whereNotNull('scheduled_at');
    }

    /**
     * Scope to get posts ready for publishing
     */
    public function scopeReadyToPublish($query)
    {
        return $query->scheduled()
            ->where('scheduled_at', '<=', now())
            ->whereHas('scheduledPost', function ($q) {
                $q->where('is_active', true)->where('is_processed', false);
            });
    }

    /**
     * Check if post can be published now
     */
    public function canPublishNow(): bool
    {
        return $this->status === 'scheduled' 
            && $this->scheduled_at 
            && $this->scheduled_at->isPast()
            && $this->scheduledPost
            && $this->scheduledPost->is_active
            && !$this->scheduledPost->is_processed;
    }
}
