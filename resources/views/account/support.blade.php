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
                    <h3 class="mb-3">Support</h3>
                    <p class="text-muted">Need help? Contact us and we’ll get back to you.</p>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" placeholder="Briefly describe your issue"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="5" placeholder="Tell us more..."></textarea>
                        </div>
                        <button type="button" class="btn btn-primary" disabled>Send (coming soon)</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 