@extends('layouts.base')

@section('title', 'Notification Settings - Crypto Trading')

@section('content')
<!-- CSRF Token Meta Tag -->
<meta name="_token" content="{{ csrf_token() }}">

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">@include('account._sidebar')</div>
        </div>
        <div class="col-md-9">
            <!-- Page Header -->
            <div class="card shadow-sm mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1">Notification Settings</h3>
                        <p class="text-muted mb-0">Manage your notification preferences and view recent alerts</p>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="saveNotificationSettings()">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="testRoute()">
                        <i class="fas fa-vial mr-2"></i>Test Route
                    </button>
                </div>
            </div>

            <!-- Notification Statistics -->
            <div class="row mb-4">
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card stat-card text-center">
                        <div class="card-body">
                            <div class="stat-icon mb-2">
                                <i class="fas fa-bell text-primary"></i>
                            </div>
                            <h4 class="mb-1">{{ $stats['unread'] }}</h4>
                            <small class="text-white">Unread</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card stat-card text-center">
                        <div class="card-body">
                            <div class="stat-icon mb-2">
                                <i class="fas fa-calendar-day text-success"></i>
                            </div>
                            <h4 class="mb-1">{{ $stats['today'] }}</h4>
                            <small class="text-white">Today</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card stat-card text-center">
                        <div class="card-body">
                            <div class="stat-icon mb-2">
                                <i class="fas fa-calendar-week text-info"></i>
                            </div>
                            <h4 class="mb-1">{{ $stats['this_week'] }}</h4>
                            <small class="text-white">This Week</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card stat-card text-center">
                        <div class="card-body">
                            <div class="stat-icon mb-2">
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                            </div>
                            <h4 class="mb-1">{{ $stats['active_alerts'] }}</h4>
                            <small class="text-white">Active Alerts</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Notification Categories -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-cog text-primary mr-2"></i>
                                Notification Categories
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Price Alerts -->
                            <div class="notification-category mb-4">
                                <div class="category-header mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-chart-line text-primary mr-2"></i>
                                        <h6 class="mb-0">Price Alerts</h6>
                                    </div>
                                    <small class="text-muted">Get notified about price movements</small>
                                </div>
                                <div class="notification-options">
                                    <div class="option-group">
                                        <label class="option-item">
                                            <input type="checkbox" class="form-check-input" name="price[email]" checked>
                                            <span class="option-label">Email</span>
                                        </label>
                                        <label class="option-item">
                                            <input type="checkbox" class="form-check-input" name="price[push]" checked>
                                            <span class="option-label">Push</span>
                                        </label>
                                        <label class="option-item">
                                            <input type="checkbox" class="form-check-input" name="price[in_app]" checked>
                                            <span class="option-label">In-App</span>
                                        </label>
                                    </div>
                                    <div class="frequency-selector">
                                        <select class="form-select" name="price[frequency]">
                                            <option value="immediate">Immediate</option>
                                            <option value="hourly">Hourly</option>
                                            <option value="daily">Daily</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Portfolio Updates -->
                            <div class="notification-category mb-4">
                                <div class="category-header mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-wallet text-success mr-2"></i>
                                        <h6 class="mb-0">Portfolio Updates</h6>
                                    </div>
                                    <small class="text-muted">Track your portfolio performance</small>
                                </div>
                                <div class="notification-options">
                                    <div class="option-group">
                                        <label class="option-item">
                                            <input type="checkbox" class="form-check-input" name="portfolio[email]" checked>
                                            <span class="option-label">Email</span>
                                        </label>
                                        <label class="option-item">
                                            <input type="checkbox" class="form-check-input" name="portfolio[push]" checked>
                                            <span class="option-label">Push</span>
                                        </label>
                                        <label class="option-item">
                                            <input type="checkbox" class="form-check-input" name="portfolio[in_app]" checked>
                                            <span class="option-label">In-App</span>
                                        </label>
                                    </div>
                                    <div class="frequency-selector">
                                        <select class="form-select" name="portfolio[frequency]">
                                            <option value="immediate">Immediate</option>
                                            <option value="hourly">Hourly</option>
                                            <option value="daily">Daily</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Security Alerts -->
                            <div class="notification-category mb-4">
                                <div class="category-header mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-shield-alt text-danger mr-2"></i>
                                        <h6 class="mb-0">Security Alerts</h6>
                                    </div>
                                    <small class="text-muted">Important security notifications</small>
                                </div>
                                <div class="notification-options">
                                    <div class="option-group">
                                        <label class="option-item">
                                            <input type="checkbox" class="form-check-input" name="security[email]" checked>
                                            <span class="option-label">Email</span>
                                        </label>
                                        <label class="option-item">
                                            <input type="checkbox" class="form-check-input" name="security[push]" checked>
                                            <span class="option-label">Push</span>
                                        </label>
                                        <label class="option-item">
                                            <input type="checkbox" class="form-check-input" name="security[in_app]" checked>
                                            <span class="option-label">In-App</span>
                                        </label>
                                    </div>
                                    <div class="frequency-selector">
                                        <select class="form-select" name="security[frequency]">
                                            <option value="immediate">Immediate</option>
                                            <option value="hourly">Hourly</option>
                                            <option value="daily">Daily</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- System Notifications -->
                            <div class="notification-category">
                                <div class="category-header mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-cog text-secondary mr-2"></i>
                                        <h6 class="mb-0">System Notifications</h6>
                                    </div>
                                    <small class="text-muted">Platform updates and maintenance</small>
                                </div>
                                <div class="notification-options">
                                    <div class="option-group">
                                        <label class="option-item">
                                            <input type="checkbox" class="form-check-input" name="system[email]">
                                            <span class="option-label">Email</span>
                                        </label>
                                        <label class="option-item">
                                            <input type="checkbox" class="form-check-input" name="system[push]" checked>
                                            <span class="option-label">Push</span>
                                        </label>
                                        <label class="option-item">
                                            <input type="checkbox" class="form-check-input" name="system[in_app]" checked>
                                            <span class="option-label">In-App</span>
                                        </label>
                                    </div>
                                    <div class="frequency-selector">
                                        <select class="form-select" name="system[frequency]">
                                            <option value="immediate">Immediate</option>
                                            <option value="hourly">Hourly</option>
                                            <option value="daily">Daily</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Advanced Settings -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-sliders-h text-info mr-2"></i>
                                Advanced Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Quiet Hours -->
                            <div class="setting-section mb-4">
                                <h6 class="setting-title">
                                    <i class="fas fa-moon text-warning mr-2"></i>
                                    Quiet Hours
                                </h6>
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="quietHours" name="advanced[quietHours]">
                                    <label class="form-check-label" for="quietHours">
                                        Enable quiet hours
                                    </label>
                                </div>
                                <div class="time-inputs">
                                    <div class="time-group">
                                        <label class="form-label">Start Time</label>
                                        <input type="time" class="form-control" name="advanced[quietStart]" value="22:00">
                                    </div>
                                    <div class="time-group">
                                        <label class="form-label">End Time</label>
                                        <input type="time" class="form-control" name="advanced[quietEnd]" value="08:00">
                                    </div>
                                </div>
                            </div>

                            <!-- General Preferences -->
                            <div class="setting-section mb-4">
                                <h6 class="setting-title">
                                    <i class="fas fa-cog text-primary mr-2"></i>
                                    General Preferences
                                </h6>
                                <div class="preferences-list">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="sound" name="advanced[sound]" checked>
                                        <label class="form-check-label" for="sound">
                                            <i class="fas fa-volume-up text-success mr-2"></i>
                                            Play sound for notifications
                                        </label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-map-marker-alt text-info mr-2"></i>
                                            Notification Position
                                        </label>
                                        <select class="form-select" name="advanced[position]">
                                            <option value="top-right">Top Right</option>
                                            <option value="top-left">Top Left</option>
                                            <option value="bottom-right">Bottom Right</option>
                                            <option value="bottom-left">Bottom Left</option>
                                        </select>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="autoDismiss" name="advanced[autoDismiss]" checked>
                                        <label class="form-check-label" for="autoDismiss">
                                            <i class="fas fa-clock text-warning mr-2"></i>
                                            Auto-dismiss after 5 seconds
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="groupNotifications" name="advanced[groupNotifications]" checked>
                                        <label class="form-check-label" for="groupNotifications">
                                            <i class="fas fa-layer-group text-primary mr-2"></i>
                                            Group similar notifications
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Test Notifications -->
                            <div class="setting-section">
                                <h6 class="setting-title">
                                    <i class="fas fa-vial text-success mr-2"></i>
                                    Test Notifications
                                </h6>
                                <div class="test-buttons">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="testNotification('price')">
                                        <i class="fas fa-chart-line mr-1"></i>Price
                                    </button>
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="testNotification('portfolio')">
                                        <i class="fas fa-wallet mr-1"></i>Portfolio
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="testNotification('security')">
                                        <i class="fas fa-shield-alt mr-1"></i>Security
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="testNotification('system')">
                                        <i class="fas fa-cog mr-1"></i>System
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Notifications -->
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-history text-secondary mr-2"></i>
                        Recent Notifications
                    </h5>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="markAllAsRead()">
                        <i class="fas fa-check-double mr-1"></i>Mark All as Read
                    </button>
                </div>
                <div class="card-body p-0">
                    @forelse($recentNotifications as $notification)
                        <div class="notification-item p-3 border-bottom {{ $notification->is_read ? '' : 'unread' }}" data-id="{{ $notification->id }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex align-items-start">
                                    <div class="preview-icon mr-3" style="background-color: {{ $notification->color }}">
                                        <i class="{{ $notification->icon }}"></i>
                                    </div>
                                    <div>
                                        <div class="notification-title">{{ $notification->title }}</div>
                                        <div class="notification-message text-muted">
                                            {{ $notification->message }}
                                        </div>
                                        <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    @if(!$notification->is_read)
                                        <button class="btn btn-sm btn-outline-primary mr-2" onclick="markAsRead({{ $notification->id }})">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-outline-success mr-2" disabled>
                                            <i class="fas fa-check-double"></i>
                                        </button>
                                    @endif
                                    <button class="btn btn-sm btn-outline-secondary" onclick="deleteNotification({{ $notification->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-bell-slash fa-2x mb-3"></i>
                            <p class="mb-0">No notifications yet</p>
                            <small>You'll see notifications here when they arrive</small>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern and responsive design */
:root {
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --success-color: #48bb78;
    --warning-color: #ed8936;
    --danger-color: #f56565;
    --info-color: #4299e1;
    --light-bg: #f7fafc;
    --border-color: #e2e8f0;
    --text-primary: #2d3748;
    --text-secondary: #718096;
    --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --border-radius: 0.5rem;
    --transition: all 0.2s ease-in-out;
}

/* Base styles */
body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: var(--text-primary);
    line-height: 1.6;
}

/* Card improvements */
.card {
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    background: white;
}

.card:hover {
    box-shadow: var(--shadow-md);
}

.card-header {
    background: var(--light-bg);
    border-bottom: 1px solid var(--border-color);
    padding: 1rem 1.5rem;
    border-radius: var(--border-radius) var(--border-radius) 0 0;
}

.card-body {
    padding: 1.5rem;
}

/* Statistics cards */
.stat-card {
    border: none;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: var(--border-radius);
    transition: var(--transition);
    overflow: hidden;
    position: relative;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    opacity: 0;
    transition: var(--transition);
}

.stat-card:hover::before {
    opacity: 1;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.stat-card .card-body {
    position: relative;
    z-index: 1;
}

.stat-icon {
    font-size: 2.5rem;
    opacity: 0.9;
    margin-bottom: 0.5rem;
}

.stat-card h4 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

/* Notification categories */
.notification-category {
    padding: 1.25rem;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    background: var(--light-bg);
    transition: var(--transition);
    margin-bottom: 1.5rem;
}

.notification-category:hover {
    background: white;
    border-color: var(--primary-color);
    box-shadow: var(--shadow-md);
}

.notification-category:last-child {
    margin-bottom: 0;
}

.category-header h6 {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.category-header small {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

/* Notification options */
.notification-options {
    margin-top: 1rem;
}

.option-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.option-item {
    display: flex;
    align-items: center;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 0.375rem;
    transition: var(--transition);
}

.option-item:hover {
    background: rgba(102, 126, 234, 0.1);
}

.option-item input[type="checkbox"] {
    margin-right: 0.5rem;
    width: 1.2em;
    height: 1.2em;
    accent-color: var(--primary-color);
}

.option-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-primary);
}

.frequency-selector {
    margin-top: 0.75rem;
}

.frequency-selector select {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid var(--border-color);
    border-radius: 0.375rem;
    background: white;
    font-size: 0.875rem;
}

/* Advanced settings */
.setting-section {
    padding: 1.25rem;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    background: var(--light-bg);
    margin-bottom: 1.5rem;
}

.setting-section:last-child {
    margin-bottom: 0;
}

.setting-title {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.setting-title i {
    margin-right: 0.5rem;
}

.time-inputs {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-top: 1rem;
}

.time-group label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    display: block;
}

.time-group input[type="time"] {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid var(--border-color);
    border-radius: 0.375rem;
    background: white;
}

.preferences-list .form-check {
    margin-bottom: 1rem;
}

.preferences-list .form-check:last-child {
    margin-bottom: 0;
}

.preferences-list .form-check-label {
    display: flex;
    align-items: center;
    font-weight: 500;
    color: var(--text-primary);
}

.preferences-list .form-check-label i {
    margin-right: 0.5rem;
    width: 16px;
}

/* Test buttons */
.test-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 1rem;
}

.test-buttons .btn {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
    transition: var(--transition);
}

.test-buttons .btn:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

/* Recent notifications */
.notification-item {
    border-left: 4px solid transparent;
    transition: var(--transition);
    padding: 1rem 1.5rem;
}

.notification-item:hover {
    background: var(--light-bg);
    border-left-color: var(--primary-color);
}

.notification-item.unread {
    background: rgba(102, 126, 234, 0.05);
    border-left-color: var(--primary-color);
}

.preview-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.notification-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.notification-message {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.notification-time {
    font-size: 0.8rem;
    color: var(--text-secondary);
}

/* Buttons */
.btn {
    border-radius: 0.375rem;
    font-weight: 500;
    transition: var(--transition);
    border: none;
    padding: 0.5rem 1rem;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

.btn-outline-primary {
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    background: transparent;
}

.btn-outline-primary:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-1px);
}

/* Form controls */
.form-control, .form-select {
    border: 1px solid var(--border-color);
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    transition: var(--transition);
    background: white;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

/* Responsive design */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .option-group {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
    
    .time-inputs {
        grid-template-columns: 1fr;
    }
    
    .test-buttons {
        justify-content: center;
    }
    
    .notification-item {
        padding: 1rem;
    }
    
    .preview-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .stat-card h4 {
        font-size: 1.5rem;
    }
    
    .stat-icon {
        font-size: 2rem;
    }
    
    .btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
}

/* Animation for notifications */
@keyframes slideOut {
    from {
        opacity: 1;
        transform: translateX(0);
    }
    to {
        opacity: 0;
        transform: translateX(100%);
    }
}

/* Toast notifications */
.toast-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    min-width: 300px;
    max-width: 400px;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
    border-left: 4px solid var(--primary-color);
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Utility classes */
.text-primary { color: var(--primary-color) !important; }
.text-success { color: var(--success-color) !important; }
.text-info { color: var(--info-color) !important; }
.text-warning { color: var(--warning-color) !important; }
.text-danger { color: var(--danger-color) !important; }
.text-secondary { color: var(--text-secondary) !important; }
.text-muted { color: var(--text-secondary) !important; }

.shadow-sm { box-shadow: var(--shadow-sm) !important; }
.shadow-md { box-shadow: var(--shadow-md) !important; }
.shadow-lg { box-shadow: var(--shadow-lg) !important; }
</style>

<script>
// Test route accessibility
function testRoute() {
    const token = document.querySelector('meta[name="_token"]').getAttribute('content');
    console.log('CSRF Token:', token);
    
    fetch('/account/notifications/save', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({test: true})
    })
    .then(response => {
        console.log('Test response status:', response.status);
        console.log('Test response headers:', response.headers);
        return response.text();
    })
    .then(text => {
        console.log('Test response text:', text);
        showNotification('Route test completed. Check console for details.', 'info');
    })
    .catch(error => {
        console.error('Test route error:', error);
        showNotification('Route test failed: ' + error.message, 'error');
    });
}

// Save notification settings
function saveNotificationSettings() {
    const formData = new FormData();
    
    // Collect all form data
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const selects = document.querySelectorAll('select');
    const timeInputs = document.querySelectorAll('input[type="time"]');
    
    checkboxes.forEach(checkbox => {
        const name = checkbox.name;
        if (name) {
            formData.append(name, checkbox.checked);
        }
    });
    
    selects.forEach(select => {
        const name = select.name;
        if (name) {
            formData.append(name, select.value);
        }
    });
    
    timeInputs.forEach(input => {
        const name = input.name;
        if (name) {
            formData.append(name, input.value);
        }
    });

    // Show loading state
    const saveBtn = document.querySelector('button[onclick="saveNotificationSettings()"]');
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
    saveBtn.disabled = true;

    // Debug: Log the form data being sent
    console.log('Sending form data:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }

    fetch('/account/notifications/save', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        console.log('Content-Type header:', contentType);
        
        if (!contentType || !contentType.includes('application/json')) {
            // If not JSON, get the text and log it for debugging
            return response.text().then(text => {
                console.log('Non-JSON response text:', text);
                throw new Error('Server returned non-JSON response. Status: ' + response.status + '. Content-Type: ' + contentType + '. Response: ' + text.substring(0, 200));
            });
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            showNotification('Settings saved successfully!', 'success');
        } else {
            showNotification(data.message || 'Error saving settings', 'error');
        }
    })
    .catch(error => {
        console.error('Error details:', error);
        showNotification('Error saving settings: ' + error.message, 'error');
    })
    .finally(() => {
        // Restore button state
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    });
}

// Test notification
function testNotification(type) {
    const messages = {
        price: 'Test price alert: BTC has reached $45,000',
        portfolio: 'Test portfolio update: Your portfolio grew by 5% today',
        security: 'Test security alert: New login detected from Chrome',
        system: 'Test system notification: Platform update available'
    };

    showNotification(messages[type], 'info');
}

// Mark notification as read
function markAsRead(notificationId) {
    const notificationItem = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
    if (notificationItem) {
        notificationItem.classList.remove('unread');
        const markButton = notificationItem.querySelector('.btn-outline-primary');
        if (markButton) {
            markButton.innerHTML = '<i class="fas fa-check-double"></i>';
            markButton.classList.remove('btn-outline-primary');
            markButton.classList.add('btn-outline-success');
            markButton.disabled = true;
        }
        // Update the notification's is_read status in the database
        updateNotificationStatus(notificationId, true);
    }
}

// Mark all notifications as read
function markAllAsRead() {
    const unreadItems = document.querySelectorAll('.notification-item.unread');
    if (unreadItems.length === 0) {
        showNotification('No unread notifications to mark', 'info');
        return;
    }

    unreadItems.forEach(item => {
        item.classList.remove('unread');
        const markButton = item.querySelector('.btn-outline-primary');
        if (markButton) {
            markButton.innerHTML = '<i class="fas fa-check-double"></i>';
            markButton.classList.remove('btn-outline-primary');
            markButton.classList.add('btn-outline-success');
            markButton.disabled = true;
        }
        // Update the notification's is_read status in the database
        const notificationId = item.dataset.id;
        if (notificationId) {
            updateNotificationStatus(notificationId, true);
        }
    });

    showNotification(`${unreadItems.length} notifications marked as read`, 'success');
}

// Delete notification
function deleteNotification(notificationId) {
    const notificationItem = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
    if (notificationItem) {
        notificationItem.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => {
            notificationItem.remove();
        }, 300);
        // Delete the notification from the database
        deleteNotificationFromDatabase(notificationId);
    }
}

// Update notification status (read/unread)
function updateNotificationStatus(notificationId, isRead) {
    fetch(`/account/notifications/update-status/${notificationId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').getAttribute('content')
        },
        body: JSON.stringify({ is_read: isRead })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            showNotification('Error updating notification status', 'error');
        }
    })
    .catch(error => {
        console.error('Error updating status:', error);
        showNotification('Error updating notification status', 'error');
    });
}

// Delete notification from database
function deleteNotificationFromDatabase(notificationId) {
    fetch(`/account/notifications/delete/${notificationId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            showNotification('Error deleting notification', 'error');
        }
    })
    .catch(error => {
        console.error('Error deleting notification:', error);
        showNotification('Error deleting notification', 'error');
    });
}

// Show notification toast
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.toast-notification');
    existingNotifications.forEach(notification => notification.remove());

    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'toast-notification';
    
    const iconMap = {
        success: 'check-circle',
        error: 'exclamation-circle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    
    const colorMap = {
        success: 'var(--success-color)',
        error: 'var(--danger-color)',
        warning: 'var(--warning-color)',
        info: 'var(--info-color)'
    };
    
    notification.innerHTML = `
        <div class="p-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-${iconMap[type] || 'info-circle'}" style="color: ${colorMap[type] || 'var(--info-color)'}; margin-right: 0.75rem; font-size: 1.25rem;"></i>
                <div class="flex-grow-1">
                    <div style="font-weight: 500; color: var(--text-primary);">${message}</div>
                </div>
                <button type="button" class="btn-close" onclick="this.parentElement.parentElement.parentElement.remove()" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: var(--text-secondary);">
                    ×
                </button>
            </div>
        </div>
    `;

    // Add to page
    document.body.appendChild(notification);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Add focus styles to form controls
    const formControls = document.querySelectorAll('.form-control, .form-select, input[type="checkbox"]');
    formControls.forEach(control => {
        control.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });
        
        control.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });
});
</script>
@endsection 