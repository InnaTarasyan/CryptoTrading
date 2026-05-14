@php
  use Illuminate\Support\Str;
@endphp
@extends('layouts.base')

@section('title', 'Facebook - Crypto Trading')

@section('styles')
    <link href="{{ asset('css/facebook.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="m-content">
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="facebook-icon me-3">
                                <i class="fab fa-facebook fa-3x text-primary"></i>
                            </div>
                            <div>
                                <h1 class="mb-1">Facebook Cryptocurrency Dashboard</h1>
                                <p class="text-muted mb-0">Monitor cryptocurrency dfiscussions from Facebook groups</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- API Status -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">API Configuration Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="status-item">
                                    <span class="status-label">App ID:</span>
                                    <span class="status-value {{ $apiStatus['app_id'] ? 'text-success' : 'text-danger' }}">
                                        {{ $apiStatus['app_id'] ? 'Configured' : 'Missing' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="status-item">
                                    <span class="status-label">App Secret:</span>
                                    <span class="status-value {{ $apiStatus['app_secret'] ? 'text-success' : 'text-danger' }}">
                                        {{ $apiStatus['app_secret'] ? 'Configured' : 'Missing' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="status-item">
                                    <span class="status-label">Access Token:</span>
                                    <span class="status-value {{ $apiStatus['access_token'] ? 'text-success' : 'text-danger' }}">
                                        {{ $apiStatus['access_token'] ? 'Configured' : 'Missing' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="status-item">
                                    <span class="status-label">Overall Status:</span>
                                    <span class="status-value {{ $apiStatus['fully_configured'] ? 'text-success' : 'text-warning' }}">
                                        {{ $apiStatus['fully_configured'] ? 'Ready' : 'Needs Configuration' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        @if(!$apiStatus['fully_configured'])
                        <div class="alert alert-warning mt-3">
                            <h6>Facebook API Configuration Required</h6>
                            <p class="mb-2">To fetch real data from Facebook, you need to configure the following environment variables:</p>
                            <ul class="mb-0">
                                <li><code>FACEBOOK_CLIENT_ID</code> - Your Facebook App ID</li>
                                <li><code>FACEBOOK_CLIENT_SECRET</code> - Your Facebook App Secret</li>
                                <li><code>FACEBOOK_ACCESS_TOKEN</code> - Your Facebook Access Token</li>
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users text-primary"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ number_format($stats['total_groups']) }}</h3>
                        <p>Facebook Groups</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-user-friends text-success"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ number_format($stats['total_users']) }}</h3>
                        <p>Active Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-comments text-info"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ number_format($stats['total_posts']) }}</h3>
                        <p>Total Posts</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-reply text-warning"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ number_format($stats['total_comments']) }}</h3>
                        <p>Comments</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Search Cryptocurrency Posts</h5>
                    </div>
                    <div class="card-body">
                        <form id="searchForm">
                            <div class="mb-3">
                                <label for="searchQuery" class="form-label">Search Term</label>
                                <input type="text" class="form-control" id="searchQuery" placeholder="e.g., bitcoin, ethereum, defi" value="bitcoin">
                            </div>
                            <div class="mb-3">
                                <label for="searchLimit" class="form-label">Number of Results</label>
                                <select class="form-select" id="searchLimit">
                                    <option value="10">10</option>
                                    <option value="25" selected>25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Search Posts
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Fetch Latest Data</h5>
                    </div>
                    <div class="card-body">
                        <form id="fetchForm">
                            <div class="mb-3">
                                <label for="fetchCoin" class="form-label">Cryptocurrency</label>
                                <input type="text" class="form-control" id="fetchCoin" placeholder="e.g., bitcoin" value="bitcoin">
                            </div>
                            <div class="mb-3">
                                <label for="fetchLimit" class="form-label">Number of Posts</label>
                                <select class="form-select" id="fetchLimit">
                                    <option value="25" selected>25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-download me-2"></i>Fetch Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Results</h5>
                    </div>
                    <div class="card-body">
                        <div id="resultsContainer">
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-search fa-3x mb-3"></i>
                                <p>Use the search or fetch forms above to get started</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Posts -->
        @if($stats['recent_posts']->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Posts</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($stats['recent_posts'] as $post)
                            <div class="col-md-6 mb-3">
                                <div class="post-card">
                                    <div class="post-header">
                                        <div class="post-author">
                                            <strong>{{ $post->author->name ?? 'Unknown User' }}</strong>
                                            <small class="text-muted">in {{ $post->group->name ?? 'Unknown Group' }}</small>
                                        </div>
                                        <div class="post-time">
                                            {{ $post->posted_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        {{ Str::limit($post->message, 150) }}
                                    </div>
                                    <div class="post-stats">
                                        <span class="stat-item">
                                            <i class="fas fa-heart text-danger"></i>
                                            {{ $post->likes_count }}
                                        </span>
                                        <span class="stat-item">
                                            <i class="fas fa-comment text-info"></i>
                                            {{ $post->comments_count }}
                                        </span>
                                        <span class="stat-item">
                                            <i class="fas fa-share text-success"></i>
                                            {{ $post->shares_count }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search form handler
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const query = document.getElementById('searchQuery').value;
        const limit = document.getElementById('searchLimit').value;
        
        searchPosts(query, limit);
    });

    // Fetch form handler
    document.getElementById('fetchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const coin = document.getElementById('fetchCoin').value;
        const limit = document.getElementById('fetchLimit').value;
        
        fetchData(coin, limit);
    });
});

function searchPosts(query, limit) {
    const resultsContainer = document.getElementById('resultsContainer');
    resultsContainer.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Searching...</p></div>';
    
    fetch('/facebook/search', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').getAttribute('content')
        },
        body: JSON.stringify({ query, limit })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            displayResults(data.data, 'Search Results for: ' + query);
        } else {
            resultsContainer.innerHTML = '<div class="alert alert-danger">Error: ' + data.message + '</div>';
        }
    })
    .catch(error => {
        resultsContainer.innerHTML = '<div class="alert alert-danger">Error: ' + error.message + '</div>';
    });
}

function fetchData(coin, limit) {
    const resultsContainer = document.getElementById('resultsContainer');
    resultsContainer.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Fetching data...</p></div>';
    
    fetch('/facebook/fetch-data', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').getAttribute('content')
        },
        body: JSON.stringify({ coin, limit })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);

        if (data.status === 'success') {
            displayResults(data.data, 'Fetched Data for: ' + coin);
        } else {
            resultsContainer.innerHTML = '<div class="alert alert-danger">Error: ' + data.message + '</div>';
        }
    })
    .catch(error => {
        resultsContainer.innerHTML = '<div class="alert alert-danger">Error: ' + error.message + '</div>';
    });
}

function displayResults(data, title) {
    const resultsContainer = document.getElementById('resultsContainer');
    
    if (!data.data || data.data.length === 0) {
        resultsContainer.innerHTML = '<div class="text-center text-muted py-4"><i class="fas fa-info-circle fa-3x mb-3"></i><p>No results found</p></div>';
        return;
    }
    
    let html = `<h6 class="mb-3">${title}</h6>`;
    
    data.data.forEach(post => {
        html += `
        <div class="post-card mb-3">
            <div class="post-header">
                <div class="post-author">
                    <strong>${post.author.name}</strong>
                    <small class="text-muted">in ${post.group.name}</small>
                </div>
                <div class="post-time">
                    ${new Date(post.created_time).toLocaleDateString()}
                </div>
            </div>
            <div class="post-content">
                ${post.message}
            </div>
            <div class="post-stats">
                <span class="stat-item">
                    <i class="fas fa-heart text-danger"></i>
                    ${post.likes_count}
                </span>
                <span class="stat-item">
                    <i class="fas fa-comment text-info"></i>
                    ${post.comments_count}
                </span>
                <span class="stat-item">
                    <i class="fas fa-share text-success"></i>
                    ${post.shares_count}
                </span>
            </div>
        </div>
        `;
    });
    
    if (data.note) {
        html += `<div class="alert alert-info mt-3">${data.note}</div>`;
    }
    
    resultsContainer.innerHTML = html;
}
</script>
@endsection 