<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables as Datatables;
use App\Solume;

class SolumeController extends Controller
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
     * Show the solume dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('solume');
    }

    public function getSolumeData()
    {
        return Datatables::of(Solume::all())
                   ->editColumn('change_24h', function ($coin){
                       if($coin->change_24h < 0){
                           return "<p class='danger'>$coin->change_24h</p>";
                       } else {
                           return "<p class='success'>$coin->change_24h</p>";
                       }
                   })
                   ->editColumn('reddit_change_24h', function ($coin){
                       if($coin->reddit_change_24h < 0){
                           return "<p class='danger'>$coin->reddit_change_24h</p>";
                       } else {
                           return "<p class='success'>$coin->reddit_change_24h</p>";
                       }
                   })
                   ->editColumn('sentiment_change_24h', function ($coin){
                       if($coin->sentiment_change_24h < 0){
                           return "<p class='danger'>$coin->sentiment_change_24h</p>";
                       } else {
                           return "<p class='success'>$coin->sentiment_change_24h</p>";
                       }
                   })
                   ->editColumn('twitter_change_24h', function ($coin){
                        if($coin->twitter_change_24h < 0){
                            return "<p class='danger'>$coin->twitter_change_24h</p>";
                        } else {
                            return "<p class='success'>$coin->twitter_change_24h</p>";
                        }
                   })
                   ->rawColumns(['change_24h', 'reddit_change_24h', 'sentiment_change_24h', 'twitter_change_24h'])
                   ->make(true);
    }
}
