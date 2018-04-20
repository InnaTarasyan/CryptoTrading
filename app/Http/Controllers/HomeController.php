<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables as Datatables;
use App\Coinmarketcap;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function getCoinmarketcapData()
    {
        return Datatables::of(Coinmarketcap::all())
                     ->editColumn('percent_change_1h', function ($coin){
                         if(!isset($coin->percent_change_1h)){
                             return 'Not Set';
                         }
                         if($coin->percent_change_1h < 0){
                             return "<p class='danger'>$coin->percent_change_1h</p>";
                         } else {
                             return "<p class='success'>$coin->percent_change_1h</p>";
                         }
                     })
                     ->editColumn('percent_change_24h', function ($coin){
                        if(!isset($coin->percent_change_24h)){
                             return 'Not Set';
                        }
                        if($coin->percent_change_24h < 0){
                            return "<p class='danger'>$coin->percent_change_24h</p>";
                        } else {
                            return "<p class='success'>$coin->percent_change_24h</p>";
                        }
                     })
                    ->editColumn('percent_change_7d', function ($coin){
                        if(!isset($coin->percent_change_7d)){
                            return 'Not Set';
                        }
                        if($coin->percent_change_7d < 0){
                            return "<p class='danger'>$coin->percent_change_7d</p>";
                        } else {
                            return "<p class='success'>$coin->percent_change_7d</p>";
                        }
                    })
                     ->rawColumns(['percent_change_1h', 'percent_change_24h', 'percent_change_7d'])
                     ->make(true);
    }
}
