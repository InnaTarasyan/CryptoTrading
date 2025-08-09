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
                    <h3 class="mb-3">Profile</h3>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 