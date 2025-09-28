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
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('platform', ['youtube', 'facebook', 'tiktok', 'instagram']);
            $table->string('account_id')->unique(); // Platform-specific account ID
            $table->string('account_name'); // Display name/username
            $table->string('account_email')->nullable();
            $table->text('access_token');
            $table->text('refresh_token')->nullable();
            $table->json('account_data')->nullable(); // Store additional platform-specific data
            $table->timestamp('token_expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['user_id', 'platform', 'account_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_accounts');
    }
};
