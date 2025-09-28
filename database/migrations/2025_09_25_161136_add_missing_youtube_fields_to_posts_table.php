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
            $table->string('youtube_video_id')->nullable()->after('platform_post_id');
            $table->string('youtube_privacy_status')->nullable()->after('youtube_video_id');
            $table->integer('youtube_category_id')->nullable()->after('youtube_privacy_status');
            $table->json('youtube_tags')->nullable()->after('youtube_category_id');
            $table->boolean('youtube_is_short')->default(false)->after('youtube_tags');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'youtube_video_id',
                'youtube_privacy_status',
                'youtube_category_id',
                'youtube_tags',
                'youtube_is_short'
            ]);
        });
    }
};