@extends('layouts.base')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">@include('account._sidebar')</div>
        </div>
        <div class="col-md-9">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('new_api_key'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Your new API key:</strong><br>
                    <code class="fs-6">{{ session('new_api_key') }}</code><br>
                    <small class="text-muted">Please copy this key now as you won't be able to see it again.</small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Generate API Key Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Generate New API Key</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('account.api_keys.generate') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">API Key Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="e.g. My Trading Bot" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Permissions</label>
                            <div class="row">
                                <!-- CoinGecko -->
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-primary">CoinGecko</h6>
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

                                <!-- Other Services -->
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-success">CoinMarketCal</h6>
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

                                    <h6 class="text-info mt-3">LiveCoinWatch</h6>
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

                                    <h6 class="text-warning mt-3">Social</h6>
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
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Generate API Key</button>
                    </form>
                </div>
            </div>

            <!-- Existing API Keys Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Your API Keys</h5>
                </div>
                <div class="card-body">
                    @if($apiKeys->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Key</th>
                                        <th>Permissions</th>
                                        <th>Status</th>
                                        <th>Last Used</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($apiKeys as $apiKey)
                                        <tr>
                                            <td>{{ $apiKey->name }}</td>
                                            <td>
                                                <code class="small">{{ substr($apiKey->key, 0, 16) }}...</code>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ count($apiKey->permissions ?? []) }} permissions</span>
                                                <button class="btn btn-sm btn-link p-0" type="button" 
                                                        data-bs-toggle="collapse" data-bs-target="#permissions-{{ $apiKey->id }}">
                                                    View
                                                </button>
                                                <div class="collapse mt-1" id="permissions-{{ $apiKey->id }}">
                                                    <small class="text-muted">
                                                        @if($apiKey->permissions)
                                                            @foreach($apiKey->permissions as $permission)
                                                                <span class="badge bg-light text-dark me-1">{{ $permission }}</span>
                                                            @endforeach
                                                        @endif
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($apiKey->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($apiKey->last_used_at)
                                                    <small>{{ $apiKey->last_used_at->diffForHumans() }}</small>
                                                @else
                                                    <small class="text-muted">Never</small>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $apiKey->created_at->format('M j, Y') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <form method="POST" action="{{ route('account.api_keys.toggle', $apiKey) }}" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-outline-{{ $apiKey->is_active ? 'warning' : 'success' }}">
                                                            {{ $apiKey->is_active ? 'Disable' : 'Enable' }}
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('account.api_keys.delete', $apiKey) }}" 
                                                          class="d-inline" onsubmit="return confirm('Are you sure you want to delete this API key?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-key fa-3x text-muted mb-3"></i>
                            <p class="text-muted">You haven't created any API keys yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- API Documentation Card -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">API Documentation</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Base URL:</strong> <code>{{ url('/api') }}</code>
                    </div>

                    <h6>Authentication</h6>
                    <p>Include your API key in requests using one of these methods:</p>
                    <ul>
                        <li>Header: <code>X-API-Key: your_api_key_here</code></li>
                        <li>Query parameter: <code>?api_key=your_api_key_here</code></li>
                    </ul>

                    <h6 class="mt-4">Available Endpoints</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">CoinGecko</h6>
                            <ul class="list-unstyled">
                                <li><code>GET /api/coingecko/exchanges</code></li>
                                <li><code>GET /api/coingecko/coins</code></li>
                                <li><code>GET /api/coingecko/exchange-rates</code></li>
                                <li><code>GET /api/coingecko/markets</code></li>
                                <li><code>GET /api/coingecko/trendings</code></li>
                                <li><code>GET /api/coingecko/derivatives</code></li>
                                <li><code>GET /api/coingecko/derivatives-exchanges</code></li>
                                <li><code>GET /api/coingecko/nfts</code></li>
                            </ul>

                            <h6 class="text-success">CoinMarketCal</h6>
                            <ul class="list-unstyled">
                                <li><code>GET /api/coinmarketcal/coinmarketcals</code></li>
                                <li><code>GET /api/coinmarketcal/events</code></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-info">LiveCoinWatch</h6>
                            <ul class="list-unstyled">
                                <li><code>GET /api/livecoinwatch/fiats</code></li>
                                <li><code>GET /api/livecoinwatch/live-coin-histories</code></li>
                                <li><code>GET /api/livecoinwatch/live-coin-watches</code></li>
                            </ul>

                            <h6 class="text-warning">Social</h6>
                            <ul class="list-unstyled">
                                <li><code>GET /api/telegram/messages</code></li>
                                <li><code>GET /api/twitter/messages</code></li>
                            </ul>
                        </div>
                    </div>

                    <h6 class="mt-4">Query Parameters</h6>
                    <ul>
                        <li><code>per_page</code> - Number of results per page (max 100, default 50)</li>
                        <li><code>page</code> - Page number for pagination</li>
                    </ul>

                    <div class="alert alert-warning mt-3">
                        <strong>Security Notes:</strong>
                        <ul class="mb-0">
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
@endsection 