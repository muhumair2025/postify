<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'platform',
        'account_id',
        'account_name',
        'account_email',
        'access_token',
        'refresh_token',
        'account_data',
        'token_expires_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'account_data' => 'array',
            'token_expires_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    protected $hidden = [
        'access_token',
        'refresh_token',
    ];

    /**
     * Get the user that owns the social account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the posts for the social account.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Check if token is expired
     */
    public function isTokenExpired(): bool
    {
        return $this->token_expires_at && $this->token_expires_at->isPast();
    }

    /**
     * Scope to get active accounts
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get accounts by platform
     */
    public function scopePlatform($query, string $platform)
    {
        return $query->where('platform', $platform);
    }
}
