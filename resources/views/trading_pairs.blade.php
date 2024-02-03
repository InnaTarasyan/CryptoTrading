@extends('layouts.base')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <link href="{{url('css/trading_pairs.css')}}" rel="stylesheet">
@endsection
@section('content')

    <div class="m-content">
        <button type="button" class="btn m-btn--pill btn-primary m-btn m-btn--custom add" data-toggle="modal" data-target="#m_modal_1">
            Add Coin Info
        </button>
    </div>

    <div class="m-content">
        <!--Begin::Section-->
        <div class="m-portlet" >
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <input type="hidden" id="tradingPair_route" value="{{ route('datatable.gettradingPairs') }}">
                <div class="table-responsive">
                    <table id="tradingPair" class="table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                        <thead>
                        <tr>
                            <th>Coin</th>
                            <th>Trading Pair</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!--End::Section-->
    </div>


    <!--begin::Modal-->
    <div class="modal fade" id="m_modal_1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Trading Pairs
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="coin_id" >
                    <form>
                        <div class="form-group">
                            <label class="form-control-label">
                                Coin:
                            </label>
                            <input type="hidden" id="coin" style="width: 100%" class="input-xlarge" />
                            {{--<select  name="state" id="coin" style="width: 100%">--}}
                                {{--@foreach($coins as $coin)--}}
                                    {{--<option value="{{$coin->symbol}}"> {{$coin->name}}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">
                                Trading Pair:
                            </label>
                            <input type="text" class="form-control" id="trading_pair">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary account_action">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>
    <script src="{{ url('assets/demo/default/custom/components/base/sweetalert2.js') }}" type="text/javascript" defer></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('js/trading_pairs.js') }}"></script>
@endsection
