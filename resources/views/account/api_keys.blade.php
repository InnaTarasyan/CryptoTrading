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
                    <h3 class="mb-3">API Keys</h3>
                    <p class="text-muted">Create and manage API keys for programmatic access. (coming soon)</p>
                    <div class="alert alert-info">Security note: Keep your API keys secret. Rotate regularly.</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 