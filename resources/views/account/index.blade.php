@extends('layouts.base')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                @include('account._sidebar')
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="mb-3">Welcome, {{ auth()->user()->name }}</h3>
                    <p class="text-muted">This is your personal cabinet. Use the left menu to navigate your account settings and tools.</p>
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <div class="fw-bold">Email</div>
                                <div>{{ auth()->user()->email }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <div class="fw-bold">Member Since</div>
                                <div>{{ auth()->user()->created_at ? auth()->user()->created_at->format('M d, Y') : '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <div class="fw-bold">Status</div>
                                <div><span class="badge bg-success">Active</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 