@extends('layouts.base')
@section('styles')
@endsection
@section('content')
  <div class="m-content">
    <!--Begin::Section-->
    <div class="m-portlet" >
      <div class="m-portlet__body  m-portlet__body--no-padding">
          <!--begin::Preview-->
          <div class="m-demo">
            <div class="m-demo__preview">
              <div class="m-list-timeline">
                <div class="m-scrollable mCustomScrollbar _mCS_3 mCS-autoHide" data-scrollbar-shown="true" data-scrollable="true" data-max-height="200" style="max-height: 200px; height: 200px; position: relative; overflow: visible;">
                  <div class="m-list-timeline__items" id="timeline">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--end::Preview-->

        <div id="content"></div>
          <span id="status">Connecting...</span>
        <div class="col-lg-12" style="padding-top: 30px;">
          <textarea name="content" class="form-control" data-provide="markdown" rows="10" id="textarea" ></textarea>
          <button type="button" class="btn btn-primary" id="user_message">
            Submit
          </button>
        </div>

      </div>
    </div>
    <!--End::Section-->
  </div>
@endsection
@section('scripts')
  <script>
     var user_id =  '{{Auth::id()}}';
     var user_name = '{{Auth::user()->name}}';
  </script>
  <script src="{{ url('js/chat.js') }}"></script>
@endsection
