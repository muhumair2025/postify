<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('social_account_id')->constrained()->onDelete('cascade');
            $table->enum('platform', ['youtube', 'facebook', 'tiktok', 'instagram']);
            $table->enum('post_type', ['text', 'image', 'video', 'story']);
            $table->string('title')->nullable();
            $table->text('content');
            $table->json('media_files')->nullable(); // Store file paths/URLs
            $table->json('hashtags')->nullable();
            $table->json('platform_specific_data')->nullable(); // For platform-specific settings
            $table->enum('status', ['draft', 'scheduled', 'published', 'failed'])->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('platform_post_id')->nullable(); // ID from the social platform
            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
