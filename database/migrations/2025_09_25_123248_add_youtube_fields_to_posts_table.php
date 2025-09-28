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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('content_type')->nullable()->after('post_type'); // 'video' or 'short'
            $table->json('media_paths')->nullable()->after('media_files'); // Store file paths
            $table->string('visibility')->default('public')->after('hashtags'); // 'public', 'unlisted', 'private'
            $table->json('metadata')->nullable()->after('platform_specific_data'); // Additional data like tags, is_short, etc.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['content_type', 'media_paths', 'visibility', 'metadata']);
        });
    }
};
