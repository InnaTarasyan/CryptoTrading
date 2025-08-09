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
                    <h3 class="mb-3">Security</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Change Password (coming soon)</li>
                        <li class="list-group-item">Two-Factor Authentication (coming soon)</li>
                        <li class="list-group-item">Active Sessions (coming soon)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 