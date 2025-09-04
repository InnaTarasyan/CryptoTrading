@extends('layouts.base')
@section('title','Contact | CryptoTrading')
@section('meta_description','Contact CryptoTrading — questions, feedback, or partnership inquiries.')
@section('content')
<div class="m-content">
    <div class="m-portlet" style="padding:2em;">
        <div class="m-portlet__head">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">Contact</h3>
            </div>
        </div>
        <div class="m-portlet__body">
            <p>Have suggestions or want to say hi? I'd love to hear from you!</p>
            <form action="mailto:innatarasyanmail@gmail.com" method="post" enctype="text/plain">
                <div class="form-group m-form__group">
                    <input type="text" class="form-control m-input" name="name" placeholder="Your Name" required>
                </div>
                <div class="form-group m-form__group">
                    <input type="email" class="form-control m-input" name="email" placeholder="Your Email" required>
                </div>
                <div class="form-group m-form__group">
                    <textarea name="message" class="form-control m-input" rows="6" placeholder="Your Message" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>
</div>
@endsection 