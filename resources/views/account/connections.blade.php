@extends('layouts.base')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">@include('account._sidebar')</div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="mb-3">Connected Accounts</h3>
                    <p class="text-muted">Link your exchange or social accounts for enhanced features. (coming soon)</p>
                    <ul>
                        <li>Binance, Coinbase, Kraken API connections</li>
                        <li>Twitter/Telegram account linking</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 