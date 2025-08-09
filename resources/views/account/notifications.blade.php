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
                    <h3 class="mb-3">Notifications</h3>
                    <p class="text-muted">Configure email and in-app alerts for price changes and portfolio updates. (coming soon)</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 