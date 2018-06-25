@extends('layouts.base')
@section('styles')
@endsection
@section('content')
    <div class="m-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="m-portlet m-portlet--full-height  ">
                    <div class="m-portlet__body">
                        <div class="m-card-profile">
                            <div class="m-card-profile__title m--hide">
                                Your Profile
                            </div>
                            <div class="m-card-profile__pic">
                                <div class="m-card-profile__pic-wrapper">
                                    @set($hash, Auth::user()->email)
                                    <img alt="" src="https://www.gravatar.com/avatar/{{$hash}}?d=mm&s=75"  height="75" width="75"  alt="image"/>
                                </div>
                            </div>
                            <div class="m-card-profile__details">
                            <span class="m-card-profile__name">
                                {{ Auth::user()->name }}
                            </span>
                                <a href="" class="m-card-profile__email m-link">
                                    {{ Auth::user()->email }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
