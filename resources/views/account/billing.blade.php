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
                    <h3 class="mb-3">Billing</h3>
                    <p class="text-muted">Manage your subscription and payment methods. (coming soon)</p>
                    <ul>
                        <li>Plan: Free</li>
                        <li>Next Invoice: -</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 