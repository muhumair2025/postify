<x-app-layout>
    <x-slot name="title">Calendar</x-slot>
    
    <div class="p-4 sm:p-6">
    <!-- Calendar Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-2">Content Calendar</h1>
        <p class="text-gray-600">View and manage your scheduled and published content</p>
    </div>

        <!-- Calendar Controls -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <!-- Social Profile Selector -->
            <div class="mb-4">
                <label for="profileSelector" class="block text-sm font-medium text-gray-700 mb-2">Filter by Social Profile</label>
                <select id="profileSelector" class="w-full sm:w-80 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                    <option value="all">All Profiles</option>
                    @if($socialAccounts && $socialAccounts->count() > 0)
                        @foreach($socialAccounts as $account)
                            <option value="{{ $account->id }}" data-platform="{{ $account->platform }}">
                                {{ ucfirst($account->platform) }} - {{ $account->username ?? $account->account_name ?? 'Unknown Account' }}
                            </option>
                        @endforeach
                    @else
                        <option disabled>No connected accounts found</option>
                    @endif
                </select>
                @if($socialAccounts && $socialAccounts->count() == 0)
                    <p class="text-sm text-gray-500 mt-1">Connect your social media accounts to filter by profile.</p>
                @endif
            </div>
            
            <!-- Connection Status Alert -->
            <div id="connectionAlert" class="@if(!$hasYouTubeConnectionIssues) hidden @endif mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-400 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-yellow-800">YouTube Account Needs Reconnection</h3>
                        <p class="text-sm text-yellow-700 mt-1">
                            Your YouTube account connection is missing required permissions or has expired tokens. To display your videos and shorts in the calendar, please reconnect your account with full permissions.
                        </p>
                        <p class="text-sm text-yellow-600 mt-1">
                            <strong>Note:</strong> Make sure to grant all requested permissions during reconnection, including access to read your channel data and video information.
                        </p>
                        <div class="mt-3">
                            <a href="{{ route('social-accounts.index') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-yellow-800 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                Reconnect YouTube Account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                <!-- View Switcher -->
            <div class="flex gap-2">
                    <button id="monthViewBtn" 
                            class="view-btn px-4 py-2 text-sm font-medium rounded-lg bg-blue-500 text-white transition-colors">
                    Month
                </button>
                    <button id="weekViewBtn" 
                            class="view-btn px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                    Week
                </button>
                    <button id="dayViewBtn" 
                            class="view-btn px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                    Day
                </button>
            </div>

                <!-- Navigation -->
            <div class="flex items-center gap-4">
                    <button id="prevBtn" 
                            class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                    
                    <h2 id="periodDisplay" class="text-lg font-medium text-gray-800 min-w-[200px] text-center">
                        <!-- Period will be set by JavaScript -->
                    </h2>
                    
                    <button id="nextBtn" 
                            class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                    
                    <button id="todayBtn" 
                            class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Today
                </button>
            </div>
        </div>
    </div>

    <!-- Calendar Container -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Month View -->
        <div id="monthView" class="calendar-view">
                <!-- Month Header -->
            <div class="grid grid-cols-7 bg-gray-50 border-b border-gray-200">
                    <div class="p-3 text-center text-sm font-medium text-gray-700">Sun</div>
                    <div class="p-3 text-center text-sm font-medium text-gray-700">Mon</div>
                    <div class="p-3 text-center text-sm font-medium text-gray-700">Tue</div>
                    <div class="p-3 text-center text-sm font-medium text-gray-700">Wed</div>
                    <div class="p-3 text-center text-sm font-medium text-gray-700">Thu</div>
                    <div class="p-3 text-center text-sm font-medium text-gray-700">Fri</div>
                    <div class="p-3 text-center text-sm font-medium text-gray-700">Sat</div>
            </div>
                <!-- Month Grid -->
            <div id="monthGrid" class="grid grid-cols-7">
                    <!-- Days will be populated by JavaScript -->
            </div>
        </div>

        <!-- Week View -->
        <div id="weekView" class="calendar-view hidden">
                <div class="overflow-x-auto">
                    <!-- Week Header -->
                    <div class="grid grid-cols-8 bg-gray-50 border-b border-gray-200 min-w-[800px]">
                <div class="p-3 text-sm font-medium text-gray-700">Time</div>
                        <div class="p-3 text-center text-sm font-medium text-gray-700" id="weekDay0">Sun</div>
                        <div class="p-3 text-center text-sm font-medium text-gray-700" id="weekDay1">Mon</div>
                        <div class="p-3 text-center text-sm font-medium text-gray-700" id="weekDay2">Tue</div>
                        <div class="p-3 text-center text-sm font-medium text-gray-700" id="weekDay3">Wed</div>
                        <div class="p-3 text-center text-sm font-medium text-gray-700" id="weekDay4">Thu</div>
                        <div class="p-3 text-center text-sm font-medium text-gray-700" id="weekDay5">Fri</div>
                        <div class="p-3 text-center text-sm font-medium text-gray-700" id="weekDay6">Sat</div>
            </div>
                    <!-- Week Grid -->
                    <div id="weekGrid" class="min-w-[800px]">
                        <!-- Hours will be populated by JavaScript -->
                    </div>
            </div>
        </div>

        <!-- Day View -->
        <div id="dayView" class="calendar-view hidden">
                <div class="overflow-x-auto">
                    <!-- Day Header -->
                    <div class="bg-gray-50 border-b border-gray-200 p-4">
                        <h3 id="dayHeader" class="text-lg font-medium text-gray-800 text-center">
                            <!-- Day will be set by JavaScript -->
                        </h3>
                    </div>
                    <!-- Day Grid -->
                    <div id="dayGrid">
                        <!-- Hours will be populated by JavaScript -->
                    </div>
            </div>
        </div>
    </div>
</div>

    <!-- Post Details Modal -->
<div id="postModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Post Details</h3>
                    <button id="closeModalBtn" 
                            class="text-gray-400 hover:text-gray-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
                <div id="modalContent">
                    <!-- Content will be populated by JavaScript -->
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
        /* Calendar Styles */
    .calendar-day {
            min-height: 140px;
        border-right: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .calendar-day:hover {
            background-color: #f9fafb;
    }
    
    .calendar-day:nth-child(7n) {
        border-right: none;
    }
    
    .calendar-day-other-month {
        background-color: #f9fafb;
        color: #9ca3af;
    }
    
    .calendar-day-today {
        background-color: #eff6ff;
    }
        
        .calendar-day-has-posts {
            background-color: #fef3c7;
    }
    
    .post-item {
        cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
            overflow: hidden;
    }
    
    .post-item:hover {
        transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .post-thumbnail {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
            flex-shrink: 0;
        }
        
        .post-content {
            flex: 1;
            min-width: 0;
        }
        
        /* Post card styling */
        .post-card {
            transition: all 0.2s ease-in-out;
        }
        .post-card:hover {
        transform: translateY(-1px);
    }
    
    .hour-row {
            min-height: 80px; /* Increased for better card spacing */
        border-bottom: 1px solid #e5e7eb;
    }
    
    .time-slot {
        position: relative;
            border-right: 1px solid #e5e7eb;
            padding: 6px;
            min-height: 80px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .time-slot:last-child {
            border-right: none;
        }
        
        .time-label {
            background-color: #f9fafb;
            border-right: 1px solid #e5e7eb;
            padding: 8px;
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
        }
        
        /* Platform Colors - now using border-left for cards */
        .platform-facebook { border-left-color: #1877f2 !important; }
        .platform-instagram { border-left-color: #e4405f !important; }
        .platform-youtube { border-left-color: #ef4444 !important; }
        .platform-twitter { border-left-color: #1da1f2 !important; }
        .platform-tiktok { border-left-color: #000000 !important; }
        .platform-default { border-left-color: #6b7280 !important; }
        
        /* Privacy status indicators */
        .privacy-unlisted { 
            background-color: #fef3c7; 
            color: #92400e; 
            border-left-color: #f59e0b !important;
        }
        .privacy-private { 
            background-color: #fecaca; 
            color: #991b1b; 
            border-left-color: #dc2626 !important;
        }
        
        /* Status badge styling */
        .status-badge {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        .privacy-unlisted .status-badge {
            background-color: #f59e0b;
            color: white;
            border-color: #f59e0b;
        }
        .privacy-private .status-badge {
            background-color: #dc2626;
            color: white;
            border-color: #dc2626;
        }
        
        /* Utility for line clamping */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 640px) {
            .calendar-day {
                min-height: 100px;
            }
            
            .hour-row {
                min-height: 50px;
            }
            
            .post-item {
                font-size: 0.75rem;
                padding: 2px 4px;
            }
            
            .post-thumbnail {
                width: 30px;
                height: 30px;
            }
        }
        
        /* Loading States */
        .loading {
            opacity: 0.5;
            pointer-events: none;
        }
        
        /* Animations */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('scripts')
<script>
    (function() {
        'use strict';
        
        console.log('Calendar script loading...');
        
        // Calendar state
let currentView = 'month';
let currentDate = new Date();
        let posts = [];
        let youtubeVideos = [];
        let socialAccounts = [];
        let selectedAccountId = 'all';
        
        // Parse data from Laravel
        try {
            posts = @json($posts ?? []);
            youtubeVideos = @json($youtubeVideos ?? []);
            socialAccounts = @json($socialAccounts ?? []);
            
            
            console.log('Loaded posts:', posts.length, 'YouTube videos:', youtubeVideos.length, 'Social accounts:', socialAccounts.length);
            
            // Debug: Log the structure of posts and accounts
            if (posts.length > 0) {
                console.log('Sample post structure:', posts[0]);
            }
            if (youtubeVideos.length > 0) {
                console.log('Sample YouTube video structure:', youtubeVideos[0]);
            } else {
                console.log('No YouTube videos found');
            }
            if (socialAccounts.length > 0) {
                console.log('Sample social account structure:', socialAccounts[0]);
                console.log('All social accounts:', socialAccounts);
                
                // Check for YouTube accounts specifically
                const youtubeAccounts = socialAccounts.filter(acc => acc.platform === 'youtube');
                console.log('YouTube accounts found:', youtubeAccounts.length);
                youtubeAccounts.forEach(acc => {
                    console.log(`YouTube account ${acc.id}: Status=${acc.status}, Channel=${acc.channel_id}, Username=${acc.username}`);
                });
                
                // Show connection alert if YouTube accounts exist but no videos
                if (youtubeAccounts.length > 0 && youtubeVideos.length === 0) {
                    const connectionAlert = document.getElementById('connectionAlert');
                    if (connectionAlert) {
                        connectionAlert.classList.remove('hidden');
                    }
                }
            }
        } catch (e) {
            console.error('Failed to parse data:', e);
            posts = [];
            youtubeVideos = [];
            socialAccounts = [];
        }
        
        // Global element references
        let monthViewBtn, weekViewBtn, dayViewBtn, prevBtn, nextBtn, todayBtn, closeModalBtn, postModal, periodDisplay, profileSelector;

// View switching
function switchView(view) {
    currentView = view;
    
    // Update button states
            document.querySelectorAll('.view-btn').forEach(btn => {
        btn.classList.remove('bg-blue-500', 'text-white');
        btn.classList.add('bg-gray-100', 'text-gray-700');
    });
    
            const activeBtn = document.getElementById(view + 'ViewBtn');
            if (activeBtn) {
                activeBtn.classList.remove('bg-gray-100', 'text-gray-700');
                activeBtn.classList.add('bg-blue-500', 'text-white');
            }
    
    // Hide all views
            document.querySelectorAll('.calendar-view').forEach(v => {
                v.classList.add('hidden');
            });
    
    // Show selected view
            const viewElement = document.getElementById(view + 'View');
            if (viewElement) {
                viewElement.classList.remove('hidden');
            }
    
            render();
}

// Navigation
        function navigate(direction) {
            const newDate = new Date(currentDate);
            
            switch (currentView) {
                case 'month':
        if (direction === 'prev') {
                        newDate.setMonth(newDate.getMonth() - 1);
        } else {
                        newDate.setMonth(newDate.getMonth() + 1);
        }
                    break;
                case 'week':
        if (direction === 'prev') {
                        newDate.setDate(newDate.getDate() - 7);
        } else {
                        newDate.setDate(newDate.getDate() + 7);
        }
                    break;
                case 'day':
        if (direction === 'prev') {
                        newDate.setDate(newDate.getDate() - 1);
        } else {
                        newDate.setDate(newDate.getDate() + 1);
        }
                    break;
    }
            
            currentDate = newDate;
            render();
}

function goToToday() {
    currentDate = new Date();
            render();
}

// Update period display
function updatePeriodDisplay() {
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'];
    
    let periodText = '';
    
            switch (currentView) {
                case 'month':
        periodText = monthNames[currentDate.getMonth()] + ' ' + currentDate.getFullYear();
                    break;
                case 'week':
                    const weekStart = getWeekStart(currentDate);
        const weekEnd = new Date(weekStart);
        weekEnd.setDate(weekStart.getDate() + 6);
        periodText = formatDate(weekStart) + ' - ' + formatDate(weekEnd);
                    break;
                case 'day':
        periodText = formatDate(currentDate);
                    break;
            }
            
            if (periodDisplay) {
                periodDisplay.textContent = periodText;
            }
        }
        
        // Main render function
        function render() {
            console.log('Rendering view:', currentView, 'Date:', currentDate);
            updatePeriodDisplay();
            
            switch (currentView) {
                case 'month':
                    renderMonthView();
                    break;
                case 'week':
                    renderWeekView();
                    break;
                case 'day':
                    renderDayView();
                    break;
            }
        }
        
        // Render month view
function renderMonthView() {
    const grid = document.getElementById('monthGrid');
            if (!grid) {
                console.error('Month grid not found!');
                return;
            }
            
            console.log('Rendering month view...');
    grid.innerHTML = '';
    
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();
    
            console.log('Year:', year, 'Month:', month, 'Days in month:', daysInMonth);
    
    // Previous month days
    for (let i = firstDay - 1; i >= 0; i--) {
        const day = daysInPrevMonth - i;
        const date = new Date(year, month - 1, day);
        grid.appendChild(createDayCell(date, true));
    }
    
    // Current month days
    for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(year, month, day);
        grid.appendChild(createDayCell(date, false));
    }
    
    // Next month days
            const totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
            const remainingCells = totalCells - (firstDay + daysInMonth);
    for (let day = 1; day <= remainingCells; day++) {
        const date = new Date(year, month + 1, day);
        grid.appendChild(createDayCell(date, true));
    }
}

        // Create day cell
function createDayCell(date, isOtherMonth) {
    const cell = document.createElement('div');
    cell.className = 'calendar-day p-2 relative';
    
    if (isOtherMonth) {
        cell.classList.add('calendar-day-other-month');
    }
    
            // Check if today
            if (isSameDay(date, new Date())) {
        cell.classList.add('calendar-day-today');
    }
    
    // Day number
    const dayNumber = document.createElement('div');
    dayNumber.className = 'text-sm font-medium mb-1';
    dayNumber.textContent = date.getDate();
    cell.appendChild(dayNumber);
    
            // Posts for this day
            const dayPosts = getPostsForDate(date);
            if (dayPosts.length > 0) {
                cell.classList.add('calendar-day-has-posts');
                
    const postsContainer = document.createElement('div');
    postsContainer.className = 'space-y-1';
    
                // Show up to 3 posts
    dayPosts.slice(0, 3).forEach(post => {
        const postElement = createPostElement(post);
        postsContainer.appendChild(postElement);
    });
    
                // Show more indicator
    if (dayPosts.length > 3) {
        const moreElement = document.createElement('div');
                    moreElement.className = 'text-xs text-gray-500 font-medium mt-1';
        moreElement.textContent = `+${dayPosts.length - 3} more`;
        postsContainer.appendChild(moreElement);
    }
    
    cell.appendChild(postsContainer);
            }
    
    // Click handler
    cell.addEventListener('click', () => showDayPosts(date));
    
    return cell;
}

// Create post element
function createPostElement(post) {
    const element = document.createElement('div');
    const platform = getPostPlatform(post);
    
    // Apply privacy status styling for YouTube videos
    let platformClass = `platform-${platform}`;
    if (platform === 'youtube' && post.privacy_status) {
        if (post.privacy_status === 'unlisted') {
            platformClass = 'privacy-unlisted';
        } else if (post.privacy_status === 'private') {
            platformClass = 'privacy-private';
        }
    }
    
    element.className = `post-card bg-white rounded-lg shadow-sm border-l-4 p-3 mb-2 hover:shadow-md transition-shadow cursor-pointer ${platformClass}`;
    
    // Header with time and platform/source
    const header = document.createElement('div');
    header.className = 'flex items-center justify-between mb-2';
    
    // Time
    const time = document.createElement('div');
    time.className = 'text-xs font-semibold text-gray-600';
    time.textContent = formatTime(new Date(post.scheduled_at || post.published_at));
    
    // Platform indicator
    const indicatorWrapper = document.createElement('div');
    indicatorWrapper.className = 'flex items-center gap-1';
    
    // Privacy status badge for YouTube videos
    if (platform === 'youtube' && post.privacy_status && post.privacy_status !== 'public') {
        const statusBadge = document.createElement('span');
        statusBadge.className = 'status-badge px-1 py-0.5 text-xs rounded border';
        statusBadge.textContent = post.privacy_status.toUpperCase();
        indicatorWrapper.appendChild(statusBadge);
    }
    
    header.appendChild(time);
    header.appendChild(indicatorWrapper);
    element.appendChild(header);
    
    // Content area with thumbnail and text
    const contentArea = document.createElement('div');
    contentArea.className = 'flex gap-2';
    
    // Get thumbnail URL
    const thumbnailUrl = getPostThumbnail(post);
    
    // If has thumbnail, show it
    if (thumbnailUrl) {
        const thumbnail = document.createElement('img');
        thumbnail.className = 'w-10 h-10 object-cover rounded flex-shrink-0';
        thumbnail.src = thumbnailUrl;
        thumbnail.alt = 'Post thumbnail';
        thumbnail.onerror = function() {
            this.style.display = 'none';
        };
        contentArea.appendChild(thumbnail);
    }
    
    // Content text
    const contentText = document.createElement('div');
    contentText.className = 'flex-1 min-w-0';
    
    const content = document.createElement('div');
    content.className = 'text-xs text-gray-700 line-clamp-2 leading-relaxed';
    content.textContent = getPostContent(post).substring(0, 60) + (getPostContent(post).length > 60 ? '...' : '');
    contentText.appendChild(content);
    
    contentArea.appendChild(contentText);
    element.appendChild(contentArea);
    
    // Click handler
    element.addEventListener('click', (e) => {
        e.stopPropagation();
        showPostDetails(post);
    });
    
    return element;
}

        // Render week view
function renderWeekView() {
            updateWeekHeaders();
            
    const grid = document.getElementById('weekGrid');
            if (!grid) return;
            
    grid.innerHTML = '';
    
            // Create hourly rows
    for (let hour = 0; hour < 24; hour++) {
        const row = document.createElement('div');
        row.className = 'grid grid-cols-8 hour-row';
        
        // Time label
        const timeLabel = document.createElement('div');
                timeLabel.className = 'time-label';
        timeLabel.textContent = formatHour(hour);
        row.appendChild(timeLabel);
        
        // Day columns
        for (let day = 0; day < 7; day++) {
                    const date = getWeekStart(currentDate);
                    date.setDate(date.getDate() + day);
            date.setHours(hour, 0, 0, 0);
            
            const cell = document.createElement('div');
                    cell.className = 'time-slot';
            
            // Get posts for this hour
            const hourPosts = getPostsForHour(date);
            hourPosts.forEach(post => {
                const postElement = createPostElement(post);
                cell.appendChild(postElement);
            });
            
            row.appendChild(cell);
        }
        
        grid.appendChild(row);
    }
}

        // Update week headers
        function updateWeekHeaders() {
            const weekStart = getWeekStart(currentDate);
            const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            
            for (let i = 0; i < 7; i++) {
                const date = new Date(weekStart);
                date.setDate(weekStart.getDate() + i);
                
                const header = document.getElementById(`weekDay${i}`);
                if (header) {
                    header.textContent = `${dayNames[i]} ${date.getDate()}`;
                }
            }
        }
        
        // Render day view
function renderDayView() {
            const headerElement = document.getElementById('dayHeader');
            if (headerElement) {
                headerElement.textContent = formatDate(currentDate);
            }
            
    const grid = document.getElementById('dayGrid');
            if (!grid) return;
            
    grid.innerHTML = '';
    
    for (let hour = 0; hour < 24; hour++) {
        const row = document.createElement('div');
        row.className = 'flex hour-row';
        
        // Time label
        const timeLabel = document.createElement('div');
                timeLabel.className = 'w-20 time-label';
        timeLabel.textContent = formatHour(hour);
        row.appendChild(timeLabel);
        
        // Content area
        const contentArea = document.createElement('div');
                contentArea.className = 'flex-1 p-2 border-r border-gray-200';
        
        // Get posts for this hour
        const date = new Date(currentDate);
        date.setHours(hour, 0, 0, 0);
        const hourPosts = getPostsForHour(date);
        
        hourPosts.forEach(post => {
            const postCard = createDetailedPostCard(post);
            contentArea.appendChild(postCard);
        });
        
        row.appendChild(contentArea);
        grid.appendChild(row);
    }
}

        // Create detailed post card
        function createDetailedPostCard(post) {
            const card = document.createElement('div');
            const platform = getPostPlatform(post);
            
            // Apply privacy status styling for YouTube videos
            let platformClass = `platform-${platform}`;
            if (platform === 'youtube' && post.privacy_status) {
                if (post.privacy_status === 'unlisted') {
                    platformClass = 'privacy-unlisted';
                } else if (post.privacy_status === 'private') {
                    platformClass = 'privacy-private';
                }
            }
            
            card.className = `post-card bg-white rounded-lg shadow border-l-4 p-4 mb-3 hover:shadow-lg transition-all cursor-pointer ${platformClass}`;
            
            // Header with time and indicators
    const header = document.createElement('div');
            header.className = 'flex items-center justify-between mb-3';
            
            // Left side - Platform indicators
            const leftSide = document.createElement('div');
            leftSide.className = 'flex items-center gap-2';
            
            // Platform badge
            const platformBadge = document.createElement('span');
            platformBadge.className = 'px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700';
            platformBadge.textContent = platform.charAt(0).toUpperCase() + platform.slice(1);
            
            // Privacy status badge for YouTube videos
            if (platform === 'youtube' && post.privacy_status && post.privacy_status !== 'public') {
                const statusBadge = document.createElement('span');
                statusBadge.className = 'status-badge px-2 py-1 text-xs font-medium rounded border';
                statusBadge.textContent = post.privacy_status.toUpperCase();
                leftSide.appendChild(statusBadge);
            }
            
            leftSide.appendChild(platformBadge);
            
            // Right side - Time
    const time = document.createElement('span');
            time.className = 'text-sm font-semibold text-gray-600';
    time.textContent = formatTime(new Date(post.scheduled_at || post.published_at));
    
            header.appendChild(leftSide);
    header.appendChild(time);
    card.appendChild(header);
    
            // Content area
            const contentArea = document.createElement('div');
            contentArea.className = 'flex gap-3';
            
            // Thumbnail
            const thumbnailUrl = getPostThumbnail(post);
            if (thumbnailUrl) {
                const thumbnailWrapper = document.createElement('div');
                thumbnailWrapper.className = 'flex-shrink-0';
                
                const thumbnail = document.createElement('img');
                thumbnail.className = 'w-16 h-16 object-cover rounded-lg';
                thumbnail.src = thumbnailUrl;
                thumbnail.alt = 'Post thumbnail';
                thumbnail.onerror = function() {
                    this.parentElement.style.display = 'none';
                };
                
                thumbnailWrapper.appendChild(thumbnail);
                contentArea.appendChild(thumbnailWrapper);
            }
            
            // Content text
            const contentWrapper = document.createElement('div');
            contentWrapper.className = 'flex-1 min-w-0';
    
    const content = document.createElement('p');
            content.className = 'text-sm text-gray-700 line-clamp-3 leading-relaxed';
            content.textContent = getPostContent(post);
            contentWrapper.appendChild(content);
            
            contentArea.appendChild(contentWrapper);
            card.appendChild(contentArea);
            
            // Click handler
    card.addEventListener('click', () => showPostDetails(post));
    
    return card;
}

        // Show day posts
function showDayPosts(date) {
    const dayPosts = getPostsForDate(date);
    if (dayPosts.length === 0) return;
    
            const modalContent = document.getElementById('modalContent');
            if (!modalContent) return;
            
    modalContent.innerHTML = `
        <h4 class="font-medium text-gray-900 mb-4">Posts for ${formatDate(date)}</h4>
                <div class="space-y-3">
            ${dayPosts.map(post => `
                        <div class="border border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50 transition-colors" data-post-id="${post.id || post.video_id}">
                    <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium">${formatTime(new Date(post.scheduled_at || post.published_at))}</span>
                                <span class="px-2 py-1 text-xs rounded-full platform-${getPostPlatform(post)}">
                                    ${getPostPlatform(post).toUpperCase()}
                                </span>
                    </div>
                            <p class="text-sm text-gray-700">${getPostContent(post).substring(0, 100)}...</p>
                </div>
            `).join('')}
        </div>
    `;
    
            // Add click handlers to post items
            modalContent.querySelectorAll('[data-post-id]').forEach((element, index) => {
                element.addEventListener('click', () => showPostDetails(dayPosts[index]));
            });
            
            showModal();
}

// Show post details
function showPostDetails(post) {
            const modalContent = document.getElementById('modalContent');
            if (!modalContent) return;
            
            const platform = getPostPlatform(post);
            const content = getPostContent(post);
            
            const thumbnailUrl = getPostThumbnail(post);
    
    modalContent.innerHTML = `
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 text-sm font-medium rounded-full platform-${platform}">
                                ${platform.toUpperCase()}
                            </span>
                            ${platform === 'youtube' && post.privacy_status && post.privacy_status !== 'public' ? `
                                <span class="px-2 py-1 text-xs font-medium rounded bg-yellow-100 text-yellow-800">
                                    ${post.privacy_status.toUpperCase()}
                                </span>
                            ` : ''}
                        </div>
                        <span class="text-sm text-gray-500">
                            ${formatDateTime(new Date(post.scheduled_at || post.published_at))}
                        </span>
            </div>
            
                    ${thumbnailUrl ? `
                <div class="rounded-lg overflow-hidden">
                            <img src="${thumbnailUrl}" alt="Post media" class="w-full max-h-96 object-contain bg-gray-100">
                </div>
            ` : ''}
            
            <div>
                <h4 class="font-medium text-gray-900 mb-2">Content</h4>
                        <p class="text-gray-700 whitespace-pre-wrap">${content}</p>
            </div>
            
            ${post.hashtags && post.hashtags.length > 0 ? `
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Hashtags</h4>
                    <div class="flex flex-wrap gap-2">
                        ${post.hashtags.map(tag => `<span class="text-sm text-blue-600">#${tag}</span>`).join('')}
                    </div>
                </div>
            ` : ''}
            
            <div class="flex gap-2 pt-4 border-t border-gray-200">
                ${post.id ? `
                    <a href="/posts/${post.id}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        View Post
                    </a>
                ` : ''}
                ${post.video_id ? `
                            <a href="https://youtube.com/watch?v=${post.video_id}" target="_blank" 
                               class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                        View on YouTube
                    </a>
                ` : ''}
            </div>
        </div>
    `;
    
            showModal();
        }
        
        // Modal functions
        function showModal() {
            if (postModal) {
                postModal.classList.remove('hidden');
            }
        }
        
        function closeModal() {
            if (postModal) {
                postModal.classList.add('hidden');
            }
}

// Helper functions
        function getPostsForDate(date) {
            const dateStr = formatDateString(date);
            let allPosts = [...posts, ...youtubeVideos];
            
            // Filter by selected account
            if (selectedAccountId !== 'all') {
                const originalCount = allPosts.length;
                allPosts = allPosts.filter(post => {
                    const accountId = post.social_account?.id || post.social_account_id;
                    const matches = accountId == selectedAccountId;
                    if (originalCount > 0 && allPosts.length === 0) {
                        console.log('Filtering post:', post, 'Account ID:', accountId, 'Selected:', selectedAccountId, 'Matches:', matches);
                    }
                    return matches;
                });
                console.log(`Filtered from ${originalCount} to ${allPosts.length} posts for account ${selectedAccountId}`);
            }
            
            return allPosts.filter(post => {
                const postDate = new Date(post.scheduled_at || post.published_at);
                return formatDateString(postDate) === dateStr;
            }).sort((a, b) => new Date(a.scheduled_at || a.published_at) - new Date(b.scheduled_at || b.published_at));
        }
        
        function getPostsForHour(date) {
            let allPosts = [...posts, ...youtubeVideos];
            
            // Filter by selected account
            if (selectedAccountId !== 'all') {
                allPosts = allPosts.filter(post => {
                    const accountId = post.social_account?.id || post.social_account_id;
                    return accountId == selectedAccountId;
                });
            }
            
            return allPosts.filter(post => {
                const postDate = new Date(post.scheduled_at || post.published_at);
                return isSameHour(postDate, date);
            });
        }
        
        function getPostPlatform(post) {
            return (post.social_account?.platform || post.platform || 'youtube').toLowerCase();
        }
        
        
        function getPostContent(post) {
            return post.content || post.title || post.description || 'No content';
        }
        
        function getPostThumbnail(post) {
            // For YouTube videos
            if (post.video_id) {
                return `https://img.youtube.com/vi/${post.video_id}/mqdefault.jpg`;
            }
            
            // For posts with media files
            if (post.media_files && post.media_files.length > 0) {
                const firstMedia = post.media_files[0];
                // If it's an object with url property
                if (firstMedia.url) {
                    return firstMedia.url;
                }
                // If it's a direct URL string
                if (typeof firstMedia === 'string') {
                    return firstMedia;
                }
            }
            
            // For posts with thumbnail property
            if (post.thumbnail) {
                return post.thumbnail;
            }
            
            return null;
        }
        
        function getWeekStart(date) {
            const start = new Date(date);
            start.setDate(date.getDate() - date.getDay());
            start.setHours(0, 0, 0, 0);
            return start;
        }
        
        function isSameDay(date1, date2) {
            return formatDateString(date1) === formatDateString(date2);
        }
        
        function isSameHour(date1, date2) {
            return isSameDay(date1, date2) && date1.getHours() === date2.getHours();
        }
        
        function formatDateString(date) {
            return date.toISOString().split('T')[0];
        }
        
function formatDate(date) {
            return date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
}

function formatDateTime(date) {
            return date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
}

function formatTime(date) {
            return date.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: true 
            });
}

function formatHour(hour) {
    const period = hour >= 12 ? 'PM' : 'AM';
    const displayHour = hour === 0 ? 12 : hour > 12 ? hour - 12 : hour;
    return `${displayHour} ${period}`;
}

        // Initialize function
        function init() {
            console.log('Initializing calendar...');
            
            // Get elements
            monthViewBtn = document.getElementById('monthViewBtn');
            weekViewBtn = document.getElementById('weekViewBtn');
            dayViewBtn = document.getElementById('dayViewBtn');
            prevBtn = document.getElementById('prevBtn');
            nextBtn = document.getElementById('nextBtn');
            todayBtn = document.getElementById('todayBtn');
            closeModalBtn = document.getElementById('closeModalBtn');
            postModal = document.getElementById('postModal');
            periodDisplay = document.getElementById('periodDisplay');
            profileSelector = document.getElementById('profileSelector');
            
            console.log('Elements found:', {
                monthViewBtn: !!monthViewBtn,
                weekViewBtn: !!weekViewBtn,
                dayViewBtn: !!dayViewBtn,
                prevBtn: !!prevBtn,
                nextBtn: !!nextBtn,
                todayBtn: !!todayBtn,
                periodDisplay: !!periodDisplay,
                profileSelector: !!profileSelector
            });
            
            // Attach event listeners
            if (monthViewBtn) {
                monthViewBtn.addEventListener('click', () => switchView('month'));
            }
            
            if (weekViewBtn) {
                weekViewBtn.addEventListener('click', () => switchView('week'));
            }
            
            if (dayViewBtn) {
                dayViewBtn.addEventListener('click', () => switchView('day'));
            }
            
            if (prevBtn) {
                prevBtn.addEventListener('click', () => navigate('prev'));
            }
            
            if (nextBtn) {
                nextBtn.addEventListener('click', () => navigate('next'));
            }
            
            if (todayBtn) {
                todayBtn.addEventListener('click', goToToday);
            }
            
            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', closeModal);
            }
            
            if (postModal) {
                postModal.addEventListener('click', (e) => {
                    if (e.target === postModal) {
                        closeModal();
                    }
                });
            }
            
            if (profileSelector) {
                profileSelector.addEventListener('change', (e) => {
                    selectedAccountId = e.target.value;
                    console.log('Selected account:', selectedAccountId);
                    console.log('Available social accounts:', socialAccounts);
                    console.log('Total posts before filter:', posts.length);
                    console.log('Total YouTube videos before filter:', youtubeVideos.length);
                    render();
                });
            }
            
            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
            
            // Initial render
            console.log('Calendar ready, rendering...');
            render();
        }
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
        
    })();
</script>
@endpush
</x-app-layout>