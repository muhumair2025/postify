<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'scheduled_for',
        'timezone',
        'frequency',
        'frequency_data',
        'is_processed',
        'processed_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_for' => 'datetime',
            'frequency_data' => 'array',
            'is_processed' => 'boolean',
            'processed_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the post that owns the scheduled post.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Scope to get active scheduled posts
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get pending scheduled posts
     */
    public function scopePending($query)
    {
        return $query->where('is_processed', false)->where('is_active', true);
    }

    /**
     * Scope to get posts ready to process
     */
    public function scopeReadyToProcess($query)
    {
        return $query->pending()
            ->where('scheduled_for', '<=', now());
    }

    /**
     * Mark as processed
     */
    public function markAsProcessed(): void
    {
        $this->update([
            'is_processed' => true,
            'processed_at' => now(),
        ]);
    }

    /**
     * Check if this is a recurring post
     */
    public function isRecurring(): bool
    {
        return $this->frequency !== 'once';
    }

    /**
     * Calculate next scheduled time for recurring posts
     */
    public function getNextScheduledTime(): ?\Carbon\Carbon
    {
        if (!$this->isRecurring()) {
            return null;
        }

        $current = $this->scheduled_for;
        
        return match($this->frequency) {
            'daily' => $current->addDay(),
            'weekly' => $current->addWeek(),
            'monthly' => $current->addMonth(),
            default => null,
        };
    }
}
