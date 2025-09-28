<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Http\Controllers\PostController;
use Illuminate\Console\Command;

class RetryFailedPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:retry-failed {--limit=10 : Maximum number of posts to retry}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retry publishing failed posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = $this->option('limit');
        
        $failedPosts = Post::where('status', 'failed')
            ->where('retry_count', '<', 3) // Don't retry more than 3 times
            ->orderBy('updated_at', 'asc')
            ->limit($limit)
            ->get();
            
        if ($failedPosts->isEmpty()) {
            $this->info('No failed posts to retry.');
            return;
        }
        
        $this->info("Found {$failedPosts->count()} failed posts to retry...");
        
        $controller = new PostController();
        $successCount = 0;
        $failCount = 0;
        
        foreach ($failedPosts as $post) {
            $this->line("Retrying post #{$post->id}: {$post->title}");
            
            try {
                // Use reflection to access private method
                $reflection = new \ReflectionClass($controller);
                $publishMethod = $reflection->getMethod('publishPost');
                $publishMethod->setAccessible(true);
                $publishMethod->invoke($controller, $post);
                
                $successCount++;
                $this->info("✓ Successfully published post #{$post->id}");
                
            } catch (\Exception $e) {
                $failCount++;
                $this->error("✗ Failed to publish post #{$post->id}: " . $e->getMessage());
            }
        }
        
        $this->newLine();
        $this->info("Retry completed: {$successCount} successful, {$failCount} failed");
    }
}
