# Scheduled Posts Auto-Publishing Setup

This system now includes automatic publishing of scheduled posts. Here's how to set it up:

## What's Been Implemented

1. **Timezone Support**: 
   - Users can now set their timezone in their profile
   - All scheduled times are displayed in the user's timezone
   - Posts are stored in UTC and converted for display

2. **Auto-Publishing Command**: 
   - A Laravel command `posts:publish-scheduled` runs every minute
   - It checks for posts that are scheduled and ready to publish
   - Automatically publishes them without user intervention

3. **Scheduler Configuration**: 
   - The scheduler is configured in `routes/console.php`
   - Runs every minute to check for posts to publish

## How to Enable Auto-Publishing

### For Local Development (Windows)

1. **Option 1: Manual Testing**
   ```powershell
   php artisan posts:publish-scheduled
   ```

2. **Option 2: Use Windows Task Scheduler**
   - Open Task Scheduler
   - Create a new task that runs every minute
   - Set the action to run:
     ```
     C:\path\to\php.exe D:\postify\artisan schedule:run
     ```

3. **Option 3: Keep a terminal open**
   ```powershell
   # Run this command and keep the terminal open
   php artisan schedule:work
   ```

### For Production (Linux/Unix)

Add this to your crontab:
```bash
* * * * * cd /path/to/postify && php artisan schedule:run >> /dev/null 2>&1
```

To edit crontab:
```bash
crontab -e
```

## How It Works

1. **Creating a Scheduled Post**:
   - Select "Schedule for later" when creating a post
   - Choose date and time (shown in your timezone)
   - The post will be saved with status "scheduled"

2. **Auto-Publishing**:
   - Every minute, the system checks for posts where:
     - Status is "scheduled"
     - Scheduled time has passed
   - It then automatically publishes these posts
   - Updates status to "published" or "failed"

3. **Timezone Handling**:
   - All times are stored in UTC in the database
   - Displayed in user's selected timezone
   - Auto-publishing respects user timezones

## Monitoring

- Check Laravel logs for publishing status: `storage/logs/laravel.log`
- Failed posts will show status "failed" with error details
- Successfully published posts show status "published"

## Troubleshooting

1. **Posts not auto-publishing**:
   - Ensure the scheduler is running
   - Check if the scheduled time has actually passed
   - Look for errors in the Laravel logs

2. **Wrong timezone**:
   - Update your timezone in Profile settings
   - Refresh the page to see updated times

3. **Testing**:
   - Create a post scheduled for 1-2 minutes in the future
   - Run `php artisan posts:publish-scheduled` manually
   - Check if the post was published
