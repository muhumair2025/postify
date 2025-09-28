<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule the command to publish scheduled posts every minute
Schedule::command('posts:publish-scheduled')->everyMinute()
    ->withoutOverlapping()
    ->runInBackground();
