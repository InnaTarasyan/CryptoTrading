@extends('layouts.base')

@section('title', 'Profile Settings - Crypto Trading')

@section('head')
<meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4 mb-4">
            @include('account._sidebar')
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9 col-md-8">
            <!-- Profile Header Card -->
            <div class="card shadow-lg border-0 mb-4 overflow-hidden">
                <div class="profile-header">
                    <div class="profile-header-bg"></div>
                    <div class="profile-header-content">
                        <!-- Profile Info Section -->
                        <div class="profile-info-section">
                            <div class="profile-name-section">
                                <h3 class="profile-name mb-2">{{ auth()->user()->name }}</h3>
                                <div class="profile-email text-white">
                                    <i class="fas fa-envelope mr-2"></i>
                                    {{ auth()->user()->email }}
                                </div>
                                <div class="profile-username text-white">
                                    <i class="fas fa-at mr-2"></i>
                                    {{ auth()->user()->username ?: 'No username set' }}
                                </div>
                            </div>
                            
                            <!-- Enhanced Stats Grid -->
                            <div class="profile-stats">
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="stat-content">
                                        <span class="stat-label">Member since</span>
                                        <span class="stat-value">{{ auth()->user()->created_at ? auth()->user()->created_at->format('M d, Y') : 'N/A' }}</span>
                                    </div>
                                </div>
                                
                                @if(auth()->user()->username)
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="stat-content">
                                        <span class="stat-label">Last updated</span>
                                        <span class="stat-value">{{ auth()->user()->updated_at ? auth()->user()->updated_at->diffForHumans() : 'Never' }}</span>
                                    </div>
                                </div>
                                @endif
                                
                                @if(auth()->user()->country)
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="stat-content">
                                        <span class="stat-label">Location</span>
                                        <span class="stat-value">{!!  auth()->user()->country !!} </span>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Quick Action Buttons -->
                            <div class="profile-actions">
                                <button class="btn btn-outline-primary btn-sm" onclick="scrollToForm()">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit Profile
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Form Card -->
            <div class="card shadow-lg border-0">
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('account.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Personal Information Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div class="section-content">
                                    <h3>Personal Information</h3>
                                    <p>Tell us about yourself</p>
                                </div>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-field">
                                    <label for="first_name" class="field-label">
                                        <i class="fas fa-user"></i>
                                        <span>First Name</span>
                                    </label>
                                    <input type="text" 
                                           class="form-input @error('first_name') is-invalid @enderror" 
                                           id="first_name" 
                                           name="first_name" 
                                           value="{{ old('first_name', auth()->user()->first_name ?? '') }}" 
                                           placeholder="Enter your first name">
                                    @error('first_name')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-field">
                                    <label for="last_name" class="field-label">
                                        <i class="fas fa-user"></i>
                                        <span>Last Name</span>
                                    </label>
                                    <input type="text" 
                                           class="form-input @error('last_name') is-invalid @enderror" 
                                           id="last_name" 
                                           name="last_name" 
                                           value="{{ old('last_name', auth()->user()->last_name ?? '') }}" 
                                           placeholder="Enter your last name">
                                    @error('last_name')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-field">
                                    <label for="username" class="field-label">
                                        <i class="fas fa-at"></i>
                                        <span>Username</span>
                                    </label>
                                    <div class="input-with-prefix">
                                        <span class="input-prefix">@</span>
                                        <input type="text" 
                                               class="form-input @error('username') is-invalid @enderror" 
                                               id="username" 
                                               name="username" 
                                               value="{{ old('username', auth()->user()->username ?? '') }}" 
                                               placeholder="username">
                                    </div>
                                    @error('username')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                    <div class="field-help">This will be your public display name</div>
                                </div>
                                
                                <div class="form-field">
                                    <label for="phone" class="field-label">
                                        <i class="fas fa-phone"></i>
                                        <span>Phone Number</span>
                                    </label>
                                    <input type="tel" 
                                           class="form-input @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', auth()->user()->phone ?? '') }}" 
                                           placeholder="+1 (555) 123-4567">
                                    @error('phone')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-field full-width">
                                    <label for="bio" class="field-label">
                                        <i class="fas fa-quote-left"></i>
                                        <span>Bio</span>
                                    </label>
                                    <textarea class="form-textarea @error('bio') is-invalid @enderror" 
                                              id="bio" 
                                              name="bio" 
                                              rows="4" 
                                              placeholder="Tell us about yourself, your trading experience, or what brings you to crypto trading...">{{ old('bio', auth()->user()->bio ?? '') }}</textarea>
                                    @error('bio')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                    <div class="field-footer">
                                        <div class="field-help">Maximum 280 characters</div>
                                        <div class="char-counter" id="bioCounter">0/280</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="section-content">
                                    <h3>Contact Information</h3>
                                    <p>Manage your contact preferences</p>
                                </div>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-field">
                                    <label for="email" class="field-label">
                                        <i class="fas fa-envelope"></i>
                                        <span>Email Address</span>
                                    </label>
                                    <input type="email" 
                                           class="form-input @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', auth()->user()->email) }}" 
                                           placeholder="your@email.com" 
                                           required>
                                    @error('email')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                    <div class="field-help">We'll send you a verification email if you change this</div>
                                </div>
                                
                                <div class="form-field">
                                    <label for="email_notifications" class="field-label">
                                        <i class="fas fa-bell"></i>
                                        <span>Email Notifications</span>
                                    </label>
                                    <select class="form-select @error('email_notifications') is-invalid @enderror" 
                                            id="email_notifications" 
                                            name="email_notifications">
                                        <option value="all" {{ (old('email_notifications', auth()->user()->email_notifications ?? 'all') == 'all') ? 'selected' : '' }}>
                                            📧 All notifications
                                        </option>
                                        <option value="important" {{ (old('email_notifications', auth()->user()->email_notifications ?? 'all') == 'important') ? 'selected' : '' }}>
                                            ⚠️ Important only
                                        </option>
                                        <option value="none" {{ (old('email_notifications', auth()->user()->email_notifications ?? 'all') == 'none') ? 'selected' : '' }}>
                                            🔕 No emails
                                        </option>
                                    </select>
                                    @error('email_notifications')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Location Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="section-content">
                                    <h3>Location</h3>
                                    <p>Set your location and timezone</p>
                                </div>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-field">
                                    <label for="country" class="field-label">
                                        <i class="fas fa-flag"></i>
                                        <span>Country</span>
                                    </label>
                                    <select class="form-select @error('country') is-invalid @enderror" 
                                            id="country" 
                                            name="country">
                                        <option value="">🌍 Select your country</option>
                                        <option value="US" {{ (old('country', auth()->user()->country ?? '') == 'US') ? 'selected' : '' }}>🇺🇸 United States</option>
                                        <option value="CA" {{ (old('country', auth()->user()->country ?? '') == 'CA') ? 'selected' : '' }}>🇨🇦 Canada</option>
                                        <option value="GB" {{ (old('country', auth()->user()->country ?? '') == 'GB') ? 'selected' : '' }}>🇬🇧 United Kingdom</option>
                                        <option value="DE" {{ (old('country', auth()->user()->country ?? '') == 'DE') ? 'selected' : '' }}>🇩🇪 Germany</option>
                                        <option value="FR" {{ (old('country', auth()->user()->country ?? '') == 'FR') ? 'selected' : '' }}>🇫🇷 France</option>
                                        <option value="JP" {{ (old('country', auth()->user()->country ?? '') == 'JP') ? 'selected' : '' }}>🇯🇵 Japan</option>
                                        <option value="AU" {{ (old('country', auth()->user()->country ?? '') == 'AU') ? 'selected' : '' }}>🇦🇺 Australia</option>
                                        <option value="RU" {{ (old('country', auth()->user()->country ?? '') == 'RU') ? 'selected' : '' }}>🇷🇺 Russia</option>
                                        <option value="CN" {{ (old('country', auth()->user()->country ?? '') == 'CN') ? 'selected' : '' }}>🇨🇳 China</option>
                                        <option value="IN" {{ (old('country', auth()->user()->country ?? '') == 'IN') ? 'selected' : '' }}>🇮🇳 India</option>
                                        <option value="BR" {{ (old('country', auth()->user()->country ?? '') == 'BR') ? 'selected' : '' }}>🇧🇷 Brazil</option>
                                        <option value="MX" {{ (old('country', auth()->user()->country ?? '') == 'MX') ? 'selected' : '' }}>🇲🇽 Mexico</option>
                                        <option value="AR" {{ (old('country', auth()->user()->country ?? '') == 'AR') ? 'selected' : '' }}>🇦🇷 Argentina</option>
                                        <option value="ZA" {{ (old('country', auth()->user()->country ?? '') == 'ZA') ? 'selected' : '' }}>🇿🇦 South Africa</option>
                                        <option value="EG" {{ (old('country', auth()->user()->country ?? '') == 'EG') ? 'selected' : '' }}>🇪🇬 Egypt</option>
                                        <option value="NG" {{ (old('country', auth()->user()->country ?? '') == 'NG') ? 'selected' : '' }}>🇳🇬 Nigeria</option>
                                        <option value="KE" {{ (old('country', auth()->user()->country ?? '') == 'KE') ? 'selected' : '' }}>🇰🇪 Kenya</option>
                                        <option value="other" {{ (old('country', auth()->user()->country ?? '') == 'other') ? 'selected' : '' }}>🌐 Other</option>
                                    </select>
                                    @error('country')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-field">
                                    <label for="timezone" class="field-label">
                                        <i class="fas fa-clock"></i>
                                        <span>Timezone</span>
                                    </label>
                                    <select class="form-select @error('timezone') is-invalid @enderror" 
                                            id="timezone" 
                                            name="timezone">
                                        <option value="">🕐 Select your timezone</option>
                                        <option value="UTC" {{ (old('timezone', auth()->user()->timezone ?? '') == 'UTC') ? 'selected' : '' }}>🌐 UTC (Coordinated Universal Time)</option>
                                        <option value="America/New_York" {{ (old('timezone', auth()->user()->timezone ?? '') == 'America/New_York') ? 'selected' : '' }}>🇺🇸 Eastern Time (ET)</option>
                                        <option value="America/Chicago" {{ (old('timezone', auth()->user()->timezone ?? '') == 'America/Chicago') ? 'selected' : '' }}>🇺🇸 Central Time (CT)</option>
                                        <option value="America/Denver" {{ (old('timezone', auth()->user()->timezone ?? '') == 'America/Denver') ? 'selected' : '' }}>🇺🇸 Mountain Time (MT)</option>
                                        <option value="America/Los_Angeles" {{ (old('timezone', auth()->user()->timezone ?? '') == 'America/Los_Angeles') ? 'selected' : '' }}>🇺🇸 Pacific Time (PT)</option>
                                        <option value="Europe/London" {{ (old('timezone', auth()->user()->timezone ?? '') == 'Europe/London') ? 'selected' : '' }}>🇬🇧 London (GMT)</option>
                                        <option value="Europe/Paris" {{ (old('timezone', auth()->user()->timezone ?? '') == 'Europe/Paris') ? 'selected' : '' }}>🇫🇷 Paris (CET)</option>
                                        <option value="Europe/Berlin" {{ (old('timezone', auth()->user()->timezone ?? '') == 'Europe/Berlin') ? 'selected' : '' }}>🇩🇪 Berlin (CET)</option>
                                        <option value="Asia/Tokyo" {{ (old('timezone', auth()->user()->timezone ?? '') == 'Asia/Tokyo') ? 'selected' : '' }}>🇯🇵 Tokyo (JST)</option>
                                        <option value="Asia/Shanghai" {{ (old('timezone', auth()->user()->timezone ?? '') == 'Asia/Shanghai') ? 'selected' : '' }}>🇨🇳 Shanghai (CST)</option>
                                        <option value="Asia/Kolkata" {{ (old('timezone', auth()->user()->timezone ?? '') == 'Asia/Kolkata') ? 'selected' : '' }}>🇮🇳 Mumbai (IST)</option>
                                        <option value="Australia/Sydney" {{ (old('timezone', auth()->user()->timezone ?? '') == 'Australia/Sydney') ? 'selected' : '' }}>🇦🇺 Sydney (AEST)</option>
                                    </select>
                                    @error('timezone')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i class="fas fa-share-alt"></i>
                                </div>
                                <div class="section-content">
                                    <h3>Social Media</h3>
                                    <p>Connect your social profiles</p>
                                </div>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-field">
                                    <label for="twitter" class="field-label">
                                        <i class="fab fa-twitter"></i>
                                        <span>Twitter</span>
                                    </label>
                                    <input type="url" 
                                           class="form-input @error('twitter') is-invalid @enderror" 
                                           id="twitter" 
                                           name="twitter" 
                                           value="{{ old('twitter', auth()->user()->twitter ?? '') }}" 
                                           placeholder="https://twitter.com/username">
                                    @error('twitter')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-field">
                                    <label for="linkedin" class="field-label">
                                        <i class="fab fa-linkedin"></i>
                                        <span>LinkedIn</span>
                                    </label>
                                    <input type="url" 
                                           class="form-input @error('linkedin') is-invalid @enderror" 
                                           id="linkedin" 
                                           name="linkedin" 
                                           value="{{ old('linkedin', auth()->user()->linkedin ?? '') }}" 
                                           placeholder="https://linkedin.com/in/username">
                                    @error('linkedin')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-field">
                                    <label for="github" class="field-label">
                                        <i class="fab fa-github"></i>
                                        <span>GitHub</span>
                                    </label>
                                    <input type="url" 
                                           class="form-input @error('github') is-invalid @enderror" 
                                           id="github" 
                                           name="github" 
                                           value="{{ old('github', auth()->user()->github ?? '') }}" 
                                           placeholder="https://github.com/username">
                                    @error('github')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-field">
                                    <label for="website" class="field-label">
                                        <i class="fas fa-globe"></i>
                                        <span>Website</span>
                                    </label>
                                    <input type="url" 
                                           class="form-input @error('website') is-invalid @enderror" 
                                           id="website" 
                                           name="website" 
                                           value="{{ old('website', auth()->user()->website ?? '') }}" 
                                           placeholder="https://yourwebsite.com">
                                    @error('website')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{--<!-- Privacy Settings Section -->--}}
                        {{--<div class="form-section">--}}
                            {{--<div class="section-header">--}}
                                {{--<div class="section-icon">--}}
                                    {{--<i class="fas fa-shield-alt"></i>--}}
                                {{--</div>--}}
                                {{--<div class="section-content">--}}
                                    {{--<h3>Privacy Settings</h3>--}}
                                    {{--<p>Control your profile visibility</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{----}}
                            {{--<div class="privacy-grid">--}}
                                {{--<div class="privacy-option">--}}
                                    {{--<div class="privacy-toggle">--}}
                                        {{--<input class="toggle-input" type="checkbox" id="profile_public" --}}
                                               {{--name="profile_public" value="1" --}}
                                               {{--{{ (old('profile_public', auth()->user()->profile_public ?? false)) ? 'checked' : '' }}>--}}
                                        {{--<label class="toggle-label" for="profile_public"></label>--}}
                                    {{--</div>--}}
                                    {{--<div class="privacy-content">--}}
                                        {{--<h4>Make profile public</h4>--}}
                                        {{--<p>Allow other users to view your profile</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{----}}
                                {{--<div class="privacy-option">--}}
                                    {{--<div class="privacy-toggle">--}}
                                        {{--<input class="toggle-input" type="checkbox" id="show_email" --}}
                                               {{--name="show_email" value="1" --}}
                                               {{--{{ (old('show_email', auth()->user()->show_email ?? false)) ? 'checked' : '' }}>--}}
                                        {{--<label class="toggle-label" for="show_email"></label>--}}
                                    {{--</div>--}}
                                    {{--<div class="privacy-content">--}}
                                        {{--<h4>Show email to public</h4>--}}
                                        {{--<p>Display your email on your public profile</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{----}}
                                {{--<div class="privacy-option">--}}
                                    {{--<div class="privacy-toggle">--}}
                                        {{--<input class="toggle-input" type="checkbox" id="show_location" --}}
                                               {{--name="show_location" value="1" --}}
                                               {{--{{ (old('show_location', auth()->user()->show_location ?? false)) ? 'checked' : '' }}>--}}
                                        {{--<label class="toggle-label" for="show_location"></label>--}}
                                    {{--</div>--}}
                                    {{--<div class="privacy-content">--}}
                                        {{--<h4>Show location</h4>--}}
                                        {{--<p>Display your country on your public profile</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{----}}
                                {{--<div class="privacy-option">--}}
                                    {{--<div class="privacy-toggle">--}}
                                        {{--<input class="toggle-input" type="checkbox" id="show_social" --}}
                                               {{--name="show_social" value="1" --}}
                                               {{--{{ (old('show_social', auth()->user()->show_social ?? false)) ? 'checked' : '' }}>--}}
                                        {{--<label class="toggle-label" for="show_social"></label>--}}
                                    {{--</div>--}}
                                    {{--<div class="privacy-content">--}}
                                        {{--<h4>Show social media</h4>--}}
                                        {{--<p>Display your social media links publicly</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <!-- Action Buttons -->
                        <div class="form-actions">
                            <button type="button" class="btn btn-outline" onclick="resetForm()">
                                <i class="fas fa-undo"></i>
                                <span>Reset Changes</span>
                            </button>
                            
                            <div class="action-group">
                                <button type="button" class="btn btn-secondary" onclick="saveAsDraft()">
                                    <i class="fas fa-save"></i>
                                    <span>Save Draft</span>
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i>
                                    <span>Save Changes</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle mr-2"></i>
            <strong class="mr-auto">Success!</strong>
            <button type="button" class="btn-close btn-close-white" data-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastMessage">
            Profile updated successfully!
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bio character counter
    const bioTextarea = document.getElementById('bio');
    const bioCounter = document.getElementById('bioCounter');
    
    if (bioTextarea && bioCounter) {
        // Set initial count
        updateBioCounter();
        
        // Add event listener
        bioTextarea.addEventListener('input', updateBioCounter);
        
        function updateBioCounter() {
            const currentLength = bioTextarea.value.length;
            const maxLength = 280;
            const remaining = maxLength - currentLength;
            
            bioCounter.textContent = `${currentLength}/${maxLength}`;
            
            // Remove existing classes
            bioCounter.classList.remove('text-warning', 'text-danger');
            
            // Add appropriate class based on remaining characters
            if (remaining <= 20 && remaining > 0) {
                bioCounter.classList.add('text-warning');
            } else if (remaining <= 0) {
                bioCounter.classList.add('text-danger');
            }
        }
    }

    // Form validation
    const form = document.getElementById('profileForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    }

    // Auto-save draft functionality
    let saveTimeout;
    const formInputs = form?.querySelectorAll('input, select, textarea');
    
    if (formInputs) {
        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(() => {
                    saveDraft();
                }, 2000); // Save after 2 seconds of inactivity
            });
        });
    }
});

// Auto-save draft to localStorage
function saveDraft() {
    const form = document.getElementById('profileForm');
    if (!form) return;
    
    const formData = new FormData(form);
    const draftData = {};
    
    for (let [key, value] of formData.entries()) {
        draftData[key] = value;
    }
    
    localStorage.setItem('profileDraft', JSON.stringify(draftData));
}

// Load draft from localStorage
function loadDraft() {
    const draftData = localStorage.getItem('profileDraft');
    if (!draftData) return;
    
    try {
        const data = JSON.parse(draftData);
        const form = document.getElementById('profileForm');
        
        if (form) {
            Object.keys(data).forEach(key => {
                const input = form.querySelector(`[name="${key}"]`);
                if (input && input.type !== 'file') {
                    input.value = data[key];
                }
            });
            
            // Update bio counter if bio field exists
            const bioTextarea = document.getElementById('bio');
            if (bioTextarea) {
                const event = new Event('input');
                bioTextarea.dispatchEvent(event);
            }
            
            showToast('Draft loaded successfully!', 'success');
        }
    } catch (error) {
        console.error('Error loading draft:', error);
        showToast('Error loading draft', 'error');
    }
}

// Reset form
function resetForm() {
    if (confirm('Are you sure you want to reset all changes? This action cannot be undone.')) {
        location.reload();
    }
}

// Save as draft manually
function saveAsDraft() {
    saveDraft();
    showToast('Draft saved successfully!', 'success');
}

// Show toast notification
function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        background: ${type === 'success' ? '#d4edda' : type === 'error' ? '#f8d7da' : '#d1ecf1'};
        color: ${type === 'success' ? '#155724' : type === 'error' ? '#721c24' : '#0c5460'};
        border: 1px solid ${type === 'success' ? '#c3e6cb' : type === 'error' ? '#f5c6cb' : '#bee5eb'};
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        max-width: 300px;
        font-weight: 500;
    `;
    
    toast.textContent = message;
    document.body.appendChild(toast);
    
    // Remove toast after 3 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 3000);
}

// Load draft when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Check if there's a draft to load
    const hasDraft = localStorage.getItem('profileDraft');
    if (hasDraft) {
        const loadDraftBtn = document.createElement('button');
        loadDraftBtn.type = 'button';
        loadDraftBtn.className = 'btn btn-outline btn-sm';
        loadDraftBtn.innerHTML = '<i class="fas fa-download mr-2"></i>Load Draft';
        loadDraftBtn.onclick = loadDraft;
        
        // Insert after the form title
        const formTitle = document.querySelector('.section-header h3');
        if (formTitle) {
            formTitle.parentNode.insertBefore(loadDraftBtn, formTitle.nextSibling);
        }
    }
});

// Function to scroll to the form
function scrollToForm() {
    const form = document.getElementById('profileForm');
    if (form) {
        form.scrollIntoView({ behavior: 'smooth' });
    }
}
</script>
@endsection

<style>
/* Modern Form Design - Inspired by contemporary web applications */

/* Base Form Structure */
.form-section {
    padding: 2rem;
    border-bottom: 1px solid #f1f3f4;
    background: #ffffff;
}

.form-section:last-of-type {
    border-bottom: none;
}

.form-section:hover {
    background: #fafbfc;
}

/* Section Headers */
.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f3f4;
}

.section-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.section-content h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1.2;
}

.section-content p {
    margin: 0.25rem 0 0 0;
    color: #5f6368;
    font-size: 0.95rem;
    line-height: 1.4;
}

/* Form Grid Layout */
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    align-items: start;
}

.form-field.full-width {
    grid-column: 1 / -1;
}

/* Form Fields */
.form-field {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.field-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
    color: #1a1a1a;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.field-label i {
    color: #5f6368;
    font-size: 0.9rem;
    width: 16px;
    text-align: center;
}

/* Form Inputs */
.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e8eaed;
    border-radius: 12px;
    font-size: 1rem;
    line-height: 1.5;
    color: #1a1a1a;
    background: #ffffff;
    transition: all 0.2s ease;
    font-family: inherit;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    background: #ffffff;
}

.form-input:hover,
.form-select:hover,
.form-textarea:hover {
    border-color: #dadce0;
    background: #fafbfc;
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
    font-family: inherit;
}

/* Input with Prefix */
.input-with-prefix {
    position: relative;
    display: flex;
    align-items: center;
}

.input-prefix {
    position: absolute;
    left: 1rem;
    color: #5f6368;
    font-weight: 600;
    font-size: 1rem;
    z-index: 2;
}

.input-with-prefix .form-input {
    padding-left: 2.5rem;
}

/* Field Help Text */
.field-help {
    font-size: 0.875rem;
    color: #5f6368;
    line-height: 1.4;
    margin-top: 0.25rem;
}

/* Field Errors */
.field-error {
    color: #d93025;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.field-error::before {
    content: "⚠️";
    font-size: 0.75rem;
}

/* Field Footer */
.field-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0.5rem;
}

.char-counter {
    font-size: 0.875rem;
    font-weight: 600;
    padding: 0.25rem 0.75rem;
    background: #f1f3f4;
    border-radius: 20px;
    color: #5f6368;
}

.char-counter.text-warning {
    background: #fef7e0;
    color: #b06000;
}

.char-counter.text-danger {
    background: #fce8e6;
    color: #c5221f;
}

/* Privacy Settings */
.privacy-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.privacy-option {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.5rem;
    background: #fafbfc;
    border: 2px solid transparent;
    border-radius: 16px;
    transition: all 0.2s ease;
}

.privacy-option:hover {
    background: #f1f3f4;
    border-color: #dadce0;
    transform: translateY(-1px);
}

.privacy-toggle {
    flex-shrink: 0;
}

.toggle-input {
    display: none;
}

.toggle-label {
    display: block;
    width: 48px;
    height: 24px;
    background: #dadce0;
    border-radius: 12px;
    position: relative;
    cursor: pointer;
    transition: all 0.2s ease;
}

.toggle-label::after {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 20px;
    height: 20px;
    background: #ffffff;
    border-radius: 50%;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.toggle-input:checked + .toggle-label {
    background: #667eea;
}

.toggle-input:checked + .toggle-label::after {
    transform: translateX(24px);
}

.privacy-content h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
    font-weight: 600;
    color: #1a1a1a;
}

.privacy-content p {
    margin: 0;
    font-size: 0.875rem;
    color: #5f6368;
    line-height: 1.4;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 2rem;
    background: #fafbfc;
    border-top: 1px solid #f1f3f4;
    gap: 1rem;
}

.action-group {
    display: flex;
    gap: 1rem;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.5rem;
    border: 2px solid transparent;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    font-family: inherit;
    line-height: 1.5;
}

.btn:focus {
    outline: none;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-secondary {
    background: #5f6368;
    color: white;
    border-color: transparent;
}

.btn-secondary:hover {
    background: #4a4d51;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(95, 99, 104, 0.3);
}

.btn-outline {
    background: transparent;
    color: #5f6368;
    border-color: #dadce0;
}

.btn-outline:hover {
    background: #f1f3f4;
    border-color: #dadce0;
    transform: translateY(-1px);
}

/* Card Styling */
.card {
    border-radius: 20px;
    border: none;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

/* Profile Header Styles */
.profile-header {
    position: relative;
    min-height: 280px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px 20px 0 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    padding: 2rem 1rem;
}

.profile-header-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    background-size: 100px 100px;
    opacity: 0.3;
    z-index: -1;
}

.profile-header-content {
    position: relative;
    z-index: 1;
    text-align: center;
    padding: 1rem;
    width: 100%;
    max-width: 800px;
}

.profile-info-section {
    text-align: center;
}

.profile-name-section {
    margin-bottom: 1.5rem;
}

.profile-name {
    font-size: 2.8rem;
    font-weight: 800;
    color: white;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    line-height: 1.2;
}

.profile-email {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.profile-username {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.8);
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.profile-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: rgba(255, 255, 255, 0.1);
    padding: 1rem;
    border-radius: 12px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.stat-item:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
}

.stat-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: white;
    flex-shrink: 0;
}

.stat-content {
    display: flex;
    flex-direction: column;
    text-align: left;
}

.stat-label {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.7);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.stat-value {
    font-size: 1rem;
    font-weight: 700;
    color: white;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.profile-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.profile-actions .btn {
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.profile-actions .btn-light {
    background: rgba(255, 255, 255, 0.9);
    color: #667eea;
    border-color: rgba(255, 255, 255, 0.9);
}

.profile-actions .btn-light:hover {
    background: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
}

.profile-actions .btn-outline-light {
    background: transparent;
    color: white;
    border-color: rgba(255, 255, 255, 0.6);
}

.profile-actions .btn-outline-light:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
}

/* Responsive Design for Profile Header */
@media (max-width: 768px) {
    .profile-header {
        min-height: 240px;
        padding: 1.5rem 1rem;
    }
    
    .profile-header-content {
        padding: 0.5rem;
    }
    
    .profile-name {
        font-size: 2.2rem;
    }
    
    .profile-email {
        font-size: 1rem;
    }
    
    .profile-username {
        font-size: 0.9rem;
    }
    
    .profile-stats {
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-item {
        padding: 0.75rem;
    }
    
    .profile-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .profile-actions .btn {
        width: 100%;
        max-width: 200px;
    }
}

@media (max-width: 576px) {
    .profile-header {
        min-height: 220px;
        padding: 1rem 0.5rem;
    }
    
    .profile-name {
        font-size: 1.8rem;
    }
    
    .profile-email {
        font-size: 0.9rem;
    }
    
    .profile-username {
        font-size: 0.8rem;
    }
    
    .stat-item {
        padding: 0.5rem;
    }
    
    .stat-icon {
        width: 35px;
        height: 35px;
        font-size: 1rem;
    }
}

/* Responsive Design for Form Sections */
@media (max-width: 1024px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }
    
    .privacy-grid {
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }
}

@media (max-width: 768px) {
    .form-section {
        padding: 1.5rem;
    }
    
    .section-header {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }
    
    .section-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .section-content h3 {
        font-size: 1.25rem;
    }
    
    .form-actions {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .action-group {
        justify-content: center;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .form-section {
        padding: 1rem;
    }
    
    .form-grid {
        gap: 1rem;
    }
    
    .privacy-grid {
        gap: 1rem;
    }
    
    .privacy-option {
        padding: 1rem;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
    
    .privacy-toggle {
        align-self: flex-start;
    }
    
    .section-header {
        margin-bottom: 1.5rem;
    }
    
    .section-content h3 {
        font-size: 1.125rem;
    }
    
    .section-content p {
        font-size: 0.875rem;
    }
}

/* Enhanced Focus States */
.form-input:focus-visible,
.form-select:focus-visible,
.form-textarea:focus-visible,
.btn:focus-visible {
    outline: 2px solid #667eea;
    outline-offset: 2px;
}

/* Loading States */
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

/* Smooth Animations */
.form-section,
.form-field,
.privacy-option,
.btn {
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .form-section {
        background: #1a1a1a;
        border-bottom-color: #2d2d2d;
    }
    
    .form-section:hover {
        background: #2d2d2d;
    }
    
    .section-content h3 {
        color: #ffffff;
    }
    
    .section-content p {
        color: #9aa0a6;
    }
    
    .field-label {
        color: #ffffff;
    }
    
    .field-label i {
        color: #9aa0a6;
    }
    
    .form-input,
    .form-select,
    .form-textarea {
        background: #2d2d2d;
        border-color: #3c4043;
        color: #ffffff;
    }
    
    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        background: #2d2d2d;
    }
    
    .form-input:hover,
    .form-select:hover,
    .form-textarea:hover {
        background: #3c4043;
        border-color: #5f6368;
    }
    
    .field-help {
        color: #9aa0a6;
    }
    
    .privacy-option {
        background: #2d2d2d;
    }
    
    .privacy-option:hover {
        background: #3c4043;
        border-color: #5f6368;
    }
    
    .privacy-content h4 {
        color: #ffffff;
    }
    
    .privacy-content p {
        color: #9aa0a6;
    }
    
    .form-actions {
        background: #2d2d2d;
        border-top-color: #3c4043;
    }
    
    .char-counter {
        background: #3c4043;
        color: #9aa0a6;
    }
    
    .char-counter.text-warning {
        background: #3c2f05;
        color: #f29900;
    }
    
    .char-counter.text-danger {
        background: #3c0a0a;
        color: #ea4335;
    }
}

/* Accessibility Improvements */
@media (prefers-reduced-motion: reduce) {
    .form-section,
    .form-field,
    .privacy-option,
    .btn {
        transition: none;
    }
}

/* High Contrast Mode */
@media (prefers-contrast: high) {
    .form-input,
    .form-select,
    .form-textarea {
        border-width: 3px;
    }
    
    .btn {
        border-width: 3px;
    }
}

/* Progress bar styling */
.progress {
    height: 8px;
    border-radius: 4px;
    background-color: #f1f3f4;
    overflow: hidden;
}

.progress-bar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 4px;
}
</style> 
