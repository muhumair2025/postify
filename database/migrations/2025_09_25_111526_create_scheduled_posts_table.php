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
        Schema::create('scheduled_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->timestamp('scheduled_for');
            $table->string('timezone')->default('UTC');
            $table->enum('frequency', ['once', 'daily', 'weekly', 'monthly'])->default('once');
            $table->json('frequency_data')->nullable(); // For recurring posts config
            $table->boolean('is_processed')->default(false);
            $table->timestamp('processed_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_posts');
    }
};
