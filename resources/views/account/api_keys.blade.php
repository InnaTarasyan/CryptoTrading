@extends('layouts.base')

@section('styles')
<style>
    .api-key-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }
    
    .api-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 2rem;
        background: white;
    }
    
    .api-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.18);
    }
    
    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem;
        border: none;
    }
    
    .card-header-modern h5 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .permissions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }
    
    .permission-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.25rem;
        border-left: 4px solid;
    }
    
    .permission-section.coingecko { border-left-color: #f7931e; }
    .permission-section.coinmarketcal { border-left-color: #28a745; }
    .permission-section.livecoinwatch { border-left-color: #17a2b8; }
    .permission-section.social { border-left-color: #ffc107; }
    
    .permission-section h6 {
        margin-bottom: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .form-check {
        margin-bottom: 0.75rem;
        padding-left: 1.75rem;
    }
    
    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
    
    .btn-modern {
        border-radius: 25px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-primary.btn-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-primary.btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
    }
    
    .api-keys-table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .table thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        font-weight: 600;
        padding: 1rem;
    }
    
    .table tbody tr {
        transition: background-color 0.3s ease;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .api-key-display {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 8px 12px;
        font-family: 'Courier New', monospace;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        max-width: 200px;
    }
    
    .copy-btn {
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
        padding: 2px 6px;
        border-radius: 4px;
        transition: color 0.3s ease;
    }
    
    .copy-btn:hover {
        color: #495057;
        background: #e9ecef;
    }
    
    .status-badge {
        border-radius: 20px;
        padding: 6px 12px;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .permissions-collapse {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 8px;
        margin-top: 8px;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .api-docs-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        padding: 1.5rem;
    }
    
    .endpoint-list {
        background: white;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
    }
    
    .alert-modern {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
    }
    
    .alert-info.alert-modern {
        background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
        color: #0c5460;
    }
    
    .alert-warning.alert-modern {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        color: #856404;
    }
    
    /* Mobile Card Layout for API Keys */
    .api-key-card {
        display: none;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        margin-bottom: 1rem;
        padding: 1.25rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .api-key-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }
    
    .api-key-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }
    
    .api-key-name {
        font-weight: 600;
        font-size: 1.1rem;
        color: #495057;
        margin: 0;
    }
    
    .api-key-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .api-key-details {
        display: grid;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .api-key-detail {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .api-key-detail-label {
        font-weight: 500;
        color: #667eea;
        font-size: 0.9rem;
    }
    
    .api-key-detail-value {
        color: #495057;
        font-size: 0.9rem;
    }
    
    .api-key-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .api-key-actions .btn {
        flex: 1;
        min-width: 120px;
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
    }
    
    .mobile-key-display {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 6px 10px;
        font-family: 'Courier New', monospace;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        max-width: 180px;
    }
    
    .mobile-permissions-toggle {
        background: none;
        border: none;
        color: #667eea;
        font-size: 0.8rem;
        text-decoration: underline;
        padding: 0;
        cursor: pointer;
    }
    
    .mobile-permissions-list {
        margin-top: 0.5rem;
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 6px;
        display: none;
    }
    
    .mobile-permissions-list.show {
        display: block;
    }
    
    .mobile-permissions-list .badge {
        font-size: 0.7rem;
        margin-right: 0.25rem;
        margin-bottom: 0.25rem;
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .api-key-page {
            padding: 10px 0;
        }
        
        .container-fluid {
            padding: 0 15px;
        }
        
        .permissions-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .api-card {
            margin-bottom: 1.5rem;
        }
        
        .card-header-modern {
            padding: 1rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .table-responsive {
            border-radius: 10px;
        }
        
        .api-key-display {
            max-width: 150px;
            font-size: 0.8rem;
        }
        
        .btn-group-sm {
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .btn-group-sm .btn {
            width: 100%;
            margin-bottom: 0.25rem;
        }
        
        .empty-state {
            padding: 2rem 1rem;
        }
        
        .empty-state i {
            font-size: 3rem;
        }
        
        /* Show mobile cards, hide table */
        .api-keys-table {
            display: none;
        }
        
        .api-key-card {
            display: block;
        }
    }
    
    @media (max-width: 576px) {
        .card-header-modern h5 {
            font-size: 1.1rem;
        }
        
        .permission-section {
            padding: 1rem;
        }
        
        .btn-modern {
            padding: 10px 20px;
            width: 100%;
        }
        
        .api-key-actions {
            flex-direction: column;
        }
        
        .api-key-actions .btn {
            width: 100%;
            min-width: auto;
        }
        
        .api-key-detail {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        
        .mobile-key-display {
            max-width: 160px;
            font-size: 0.75rem;
        }
    }
</style>
@endsection

@section('content')
<div class="api-key-page">
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="api-card">
                    @include('account._sidebar')
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9 col-md-8">
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('new_api_key'))
                    <div class="alert alert-warning alert-modern alert-dismissible fade show" role="alert">
                        <i class="fas fa-key me-2"></i>
                        <strong>Your new API key:</strong><br>
                        <div class="api-key-display mt-2">
                            <code class="fs-6">{{ session('new_api_key') }}</code>
                            <button class="copy-btn" onclick="copyToClipboard('{{ session('new_api_key') }}')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                        <small class="text-muted d-block mt-2">Please copy this key now as you won't be able to see it again.</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Generate API Key Card -->
                <div class="api-card">
                    <div class="card-header card-header-modern">
                        <h5 class="mb-0">
                            <i class="fas fa-plus-circle"></i>
                            Generate New API Key
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('account.api_keys.generate') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-tag me-2"></i>API Key Name
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
                                       placeholder="e.g. My Trading Bot" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-shield-alt me-2"></i>Permissions
                                </label>
                                <div class="permissions-grid">
                                    <!-- CoinGecko -->
                                    <div class="permission-section coingecko">
                                        <h6 class="text-warning">
                                            <i class="fab fa-bitcoin"></i>CoinGecko
                                        </h6>
                                        @foreach(['coingecko_exchanges', 'coin_gecko_coins', 'coin_gecko_exchange_rates', 'coin_gecko_markets', 'coin_gecko_trendings', 'derivatives', 'derivatives_exchanges', 'nfts'] as $permission)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                       value="{{ $permission }}" id="{{ $permission }}"
                                                       {{ is_array(old('permissions')) && in_array($permission, old('permissions')) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $permission }}">
                                                    {{ ucwords(str_replace('_', ' ', $permission)) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- CoinMarketCal -->
                                    <div class="permission-section coinmarketcal">
                                        <h6 class="text-success">
                                            <i class="fas fa-calendar-alt"></i>CoinMarketCal
                                        </h6>
                                        @foreach(['coinmarketcals', 'events'] as $permission)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                       value="{{ $permission }}" id="{{ $permission }}"
                                                       {{ is_array(old('permissions')) && in_array($permission, old('permissions')) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $permission }}">
                                                    {{ ucwords(str_replace('_', ' ', $permission)) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- LiveCoinWatch -->
                                    <div class="permission-section livecoinwatch">
                                        <h6 class="text-info">
                                            <i class="fas fa-chart-line"></i>LiveCoinWatch
                                        </h6>
                                        @foreach(['fiats', 'live_coin_histories', 'live_coin_watches'] as $permission)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                       value="{{ $permission }}" id="{{ $permission }}"
                                                       {{ is_array(old('permissions')) && in_array($permission, old('permissions')) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $permission }}">
                                                    {{ ucwords(str_replace('_', ' ', $permission)) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Social -->
                                    <div class="permission-section social">
                                        <h6 class="text-warning">
                                            <i class="fas fa-share-alt"></i>Social
                                        </h6>
                                        @foreach(['telegram_messages', 'twitter_messages'] as $permission)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                       value="{{ $permission }}" id="{{ $permission }}"
                                                       {{ is_array(old('permissions')) && in_array($permission, old('permissions')) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $permission }}">
                                                    {{ ucwords(str_replace('_', ' ', $permission)) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @error('permissions')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-modern">
                                <i class="fas fa-key me-2"></i>Generate API Key
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Existing API Keys Card -->
                <div class="api-card">
                    <div class="card-header card-header-modern">
                        <h5 class="mb-0">
                            <i class="fas fa-list"></i>
                            Your API Keys
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($apiKeys->count() > 0)
                            <!-- Desktop Table View -->
                            <div class="table-responsive api-keys-table">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th><i class="fas fa-tag me-1"></i>Name</th>
                                            <th><i class="fas fa-key me-1"></i>Key</th>
                                            <th><i class="fas fa-shield-alt me-1"></i>Permissions</th>
                                            <th><i class="fas fa-toggle-on me-1"></i>Status</th>
                                            <th><i class="fas fa-clock me-1"></i>Last Used</th>
                                            <th><i class="fas fa-calendar me-1"></i>Created</th>
                                            <th><i class="fas fa-cog me-1"></i>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($apiKeys as $apiKey)
                                            <tr>
                                                <td data-label="Name">
                                                    <strong>{{ $apiKey->name }}</strong>
                                                </td>
                                                <td data-label="Key">
                                                    <div class="api-key-display">
                                                        <code class="small">{{ substr($apiKey->key, 0, 16) }}...</code>
                                                        <button class="copy-btn" onclick="copyToClipboard('{{ $apiKey->key }}')">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td data-label="Permissions">
                                                    <span class="badge bg-secondary status-badge">{{ count($apiKey->permissions ?? []) }} permissions</span>
                                                    <button class="btn btn-sm btn-link p-0 ms-1" type="button" 
                                                            data-bs-toggle="collapse" data-bs-target="#permissions-{{ $apiKey->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <div class="collapse permissions-collapse" id="permissions-{{ $apiKey->id }}">
                                                        @if($apiKey->permissions)
                                                            @foreach($apiKey->permissions as $permission)
                                                                <span class="badge bg-light text-dark me-1 mb-1">{{ $permission }}</span>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </td>
                                                <td data-label="Status">
                                                    @if($apiKey->is_active)
                                                        <span class="badge bg-success status-badge">
                                                            <i class="fas fa-check me-1"></i>Active
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger status-badge">
                                                            <i class="fas fa-times me-1"></i>Inactive
                                                        </span>
                                                    @endif
                                                </td>
                                                <td data-label="Last Used">
                                                    @if($apiKey->last_used_at)
                                                        <small><i class="fas fa-clock me-1"></i>{{ $apiKey->last_used_at->diffForHumans() }}</small>
                                                    @else
                                                        <small class="text-muted"><i class="fas fa-minus me-1"></i>Never</small>
                                                    @endif
                                                </td>
                                                <td data-label="Created">
                                                    <small><i class="fas fa-calendar me-1"></i>{{ $apiKey->created_at->format('M j, Y') }}</small>
                                                </td>
                                                <td data-label="Actions">
                                                    <div class="btn-group btn-group-sm">
                                                        <form method="POST" action="{{ route('account.api_keys.toggle', $apiKey) }}" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-outline-{{ $apiKey->is_active ? 'warning' : 'success' }}">
                                                                <i class="fas fa-{{ $apiKey->is_active ? 'pause' : 'play' }} me-1"></i>
                                                                {{ $apiKey->is_active ? 'Disable' : 'Enable' }}
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('account.api_keys.delete', $apiKey) }}" 
                                                              class="d-inline" onsubmit="return confirm('Are you sure you want to delete this API key?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger">
                                                                <i class="fas fa-trash me-1"></i>Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile Card View -->
                            @foreach($apiKeys as $apiKey)
                                <div class="api-key-card">
                                    <div class="api-key-card-header">
                                        <h6 class="api-key-name">{{ $apiKey->name }}</h6>
                                        <div class="api-key-status">
                                            @if($apiKey->is_active)
                                                <span class="badge bg-success status-badge">
                                                    <i class="fas fa-check me-1"></i>Active
                                                </span>
                                            @else
                                                <span class="badge bg-danger status-badge">
                                                    <i class="fas fa-times me-1"></i>Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="api-key-details">
                                        <div class="api-key-detail">
                                            <span class="api-key-detail-label">
                                                <i class="fas fa-key me-1"></i>API Key
                                            </span>
                                            <div class="mobile-key-display">
                                                <code>{{ substr($apiKey->key, 0, 12) }}...</code>
                                                <button class="copy-btn" onclick="copyToClipboard('{{ $apiKey->key }}')">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="api-key-detail">
                                            <span class="api-key-detail-label">
                                                <i class="fas fa-shield-alt me-1"></i>Permissions
                                            </span>
                                            <div class="api-key-detail-value">
                                                <span class="badge bg-secondary">{{ count($apiKey->permissions ?? []) }} permissions</span>
                                                <button class="mobile-permissions-toggle" onclick="toggleMobilePermissions('{{ $apiKey->id }}')">
                                                    View Details
                                                </button>
                                                <div class="mobile-permissions-list" id="mobile-permissions-{{ $apiKey->id }}">
                                                    @if($apiKey->permissions)
                                                        @foreach($apiKey->permissions as $permission)
                                                            <span class="badge bg-light text-dark me-1 mb-1">{{ $permission }}</span>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="api-key-detail">
                                            <span class="api-key-detail-label">
                                                <i class="fas fa-clock me-1"></i>Last Used
                                            </span>
                                            <span class="api-key-detail-value">
                                                @if($apiKey->last_used_at)
                                                    {{ $apiKey->last_used_at->diffForHumans() }}
                                                @else
                                                    Never
                                                @endif
                                            </span>
                                        </div>
                                        
                                        <div class="api-key-detail">
                                            <span class="api-key-detail-label">
                                                <i class="fas fa-calendar me-1"></i>Created
                                            </span>
                                            <span class="api-key-detail-value">
                                                {{ $apiKey->created_at->format('M j, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="api-key-actions">
                                        <form method="POST" action="{{ route('account.api_keys.toggle', $apiKey) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-{{ $apiKey->is_active ? 'warning' : 'success' }}">
                                                <i class="fas fa-{{ $apiKey->is_active ? 'pause' : 'play' }} me-1"></i>
                                                {{ $apiKey->is_active ? 'Disable' : 'Enable' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('account.api_keys.delete', $apiKey) }}" 
                                              class="d-inline" onsubmit="return confirm('Are you sure you want to delete this API key?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fas fa-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="fas fa-key"></i>
                                <h5 class="mt-3">No API Keys Yet</h5>
                                <p class="text-muted">You haven't created any API keys yet. Generate your first one above to get started!</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- API Documentation Card -->
                <div class="api-card">
                    <div class="card-header card-header-modern">
                        <h5 class="mb-0">
                            <i class="fas fa-book"></i>
                            API Documentation
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="api-docs-section">
                            <div class="alert alert-info alert-modern">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Base URL:</strong> <code>{{ url('/api') }}</code>
                            </div>

                            <h6><i class="fas fa-lock me-2"></i>Authentication</h6>
                            <p>Include your API key in requests using one of these methods:</p>
                            <div class="endpoint-list">
                                <ul class="mb-0">
                                    <li><strong>Header:</strong> <code>X-API-Key: your_api_key_here</code></li>
                                    <li><strong>Query parameter:</strong> <code>?api_key=your_api_key_here</code></li>
                                </ul>
                            </div>

                            <h6 class="mt-4"><i class="fas fa-plug me-2"></i>Available Endpoints</h6>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <div class="endpoint-list">
                                        <h6 class="text-warning"><i class="fab fa-bitcoin me-1"></i>CoinGecko</h6>
                                        <ul class="list-unstyled small">
                                            <li><code>GET /api/coingecko/exchanges</code></li>
                                            <li><code>GET /api/coingecko/coins</code></li>
                                            <li><code>GET /api/coingecko/exchange-rates</code></li>
                                            <li><code>GET /api/coingecko/markets</code></li>
                                            <li><code>GET /api/coingecko/trendings</code></li>
                                            <li><code>GET /api/coingecko/derivatives</code></li>
                                            <li><code>GET /api/coingecko/derivatives-exchanges</code></li>
                                            <li><code>GET /api/coingecko/nfts</code></li>
                                        </ul>

                                        <h6 class="text-success mt-3"><i class="fas fa-calendar-alt me-1"></i>CoinMarketCal</h6>
                                        <ul class="list-unstyled small">
                                            <li><code>GET /api/coinmarketcal/coinmarketcals</code></li>
                                            <li><code>GET /api/coinmarketcal/events</code></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="endpoint-list">
                                        <h6 class="text-info"><i class="fas fa-chart-line me-1"></i>LiveCoinWatch</h6>
                                        <ul class="list-unstyled small">
                                            <li><code>GET /api/livecoinwatch/fiats</code></li>
                                            <li><code>GET /api/livecoinwatch/live-coin-histories</code></li>
                                            <li><code>GET /api/livecoinwatch/live-coin-watches</code></li>
                                        </ul>

                                        <h6 class="text-warning mt-3"><i class="fas fa-share-alt me-1"></i>Social</h6>
                                        <ul class="list-unstyled small">
                                            <li><code>GET /api/telegram/messages</code></li>
                                            <li><code>GET /api/twitter/messages</code></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <h6 class="mt-4"><i class="fas fa-search me-2"></i>Query Parameters</h6>
                            <div class="endpoint-list">
                                <ul class="mb-0">
                                    <li><code>per_page</code> - Number of results per page (max 100, default 50)</li>
                                    <li><code>page</code> - Page number for pagination</li>
                                </ul>
                            </div>

                            <div class="alert alert-warning alert-modern mt-4">
                                <i class="fas fa-shield-alt me-2"></i>
                                <strong>Security Notes:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Keep your API keys secret and secure</li>
                                    <li>Rotate keys regularly</li>
                                    <li>Only grant necessary permissions</li>
                                    <li>Monitor API key usage in the Last Used column</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    // Check if the modern clipboard API is available
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function() {
            showToast('API key copied to clipboard!', 'success');
        }).catch(function(err) {
            console.error('Clipboard API failed:', err);
            fallbackCopyToClipboard(text);
        });
    } else {
        // Use fallback method
        fallbackCopyToClipboard(text);
    }
}

function fallbackCopyToClipboard(text) {
    try {
        // Create a temporary textarea element
        const textArea = document.createElement('textarea');
        textArea.value = text;
        
        // Make the textarea invisible but not display: none
        textArea.style.position = 'fixed';
        textArea.style.top = '-9999px';
        textArea.style.left = '-9999px';
        textArea.style.opacity = '0';
        textArea.style.pointerEvents = 'none';
        textArea.style.tabIndex = '-1';
        
        document.body.appendChild(textArea);
        
        // Select and copy the text
        textArea.focus();
        textArea.select();
        textArea.setSelectionRange(0, 99999); // For mobile devices
        
        const successful = document.execCommand('copy');
        document.body.removeChild(textArea);
        
        if (successful) {
            showToast('API key copied to clipboard!', 'success');
        } else {
            showToast('Failed to copy API key. Please copy manually.', 'warning');
        }
    } catch (err) {
        console.error('Fallback copy failed:', err);
        showToast('Copy not supported. Please copy manually.', 'warning');
    }
}

function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px;';
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check' : type === 'warning' ? 'exclamation-triangle' : 'info'}-circle me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 4 seconds for warning messages, 3 seconds for others
    const timeout = type === 'warning' ? 4000 : 3000;
    setTimeout(() => {
        if (toast.parentNode) {
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 150); // Wait for fade animation
        }
    }, timeout);
}

function toggleMobilePermissions(apiKeyId) {
    const permissionsList = document.getElementById('mobile-permissions-' + apiKeyId);
    const button = permissionsList.previousElementSibling;
    
    if (permissionsList.classList.contains('show')) {
        permissionsList.classList.remove('show');
        button.textContent = 'View Details';
    } else {
        permissionsList.classList.add('show');
        button.textContent = 'Hide Details';
    }
}
</script>
@endsection 