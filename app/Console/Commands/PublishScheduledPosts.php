<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\ScheduledPost;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Http\Controllers\PostController;

class PublishScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:publish-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically publish posts that are scheduled for the current time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for scheduled posts to publish...');

        // Get all posts that are scheduled and ready to be published
        $postsToPublish = Post::with(['user', 'socialAccount'])
            ->where('status', 'scheduled')
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '<=', now())
            ->get();

        if ($postsToPublish->isEmpty()) {
            $this->info('No scheduled posts to publish at this time.');
            return Command::SUCCESS;
        }

        $publishedCount = 0;
        $failedCount = 0;

        foreach ($postsToPublish as $post) {
            try {
                $this->info("Processing post ID {$post->id} for user {$post->user->name}");

                // Create a new instance of PostController to handle the publishing
                $postController = app(PostController::class);
                
                // Use reflection to access the private publishPost method
                $reflection = new \ReflectionClass($postController);
                $method = $reflection->getMethod('publishPost');
                $method->setAccessible(true);
                
                // Call the publish method
                $method->invoke($postController, $post);

                // Update post status if successful
                $post->update([
                    'status' => 'published',
                    'published_at' => now()
                ]);

                // Mark scheduled post as processed if exists
                if ($post->scheduledPost) {
                    $post->scheduledPost->markAsProcessed();
                }

                $publishedCount++;
                $this->info("Successfully published post ID {$post->id}");

                // Log the successful publication
                Log::info('Scheduled post published automatically', [
                    'post_id' => $post->id,
                    'user_id' => $post->user_id,
                    'platform' => $post->socialAccount->platform,
                    'scheduled_at' => $post->scheduled_at,
                    'published_at' => now()
                ]);

            } catch (\Exception $e) {
                $failedCount++;
                $this->error("Failed to publish post ID {$post->id}: {$e->getMessage()}");

                // Update post status to failed
                $post->update([
                    'status' => 'failed',
                    'metadata' => array_merge($post->metadata ?? [], [
                        'last_error' => $e->getMessage(),
                        'failed_at' => now()->toDateTimeString(),
                        'scheduled_publish_attempt' => true
                    ])
                ]);

                // Log the error
                Log::error('Failed to publish scheduled post', [
                    'post_id' => $post->id,
                    'user_id' => $post->user_id,
                    'platform' => $post->socialAccount->platform,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        $this->info("Scheduled post publishing completed.");
        $this->info("Published: {$publishedCount}, Failed: {$failedCount}");

        return Command::SUCCESS;
    }
}