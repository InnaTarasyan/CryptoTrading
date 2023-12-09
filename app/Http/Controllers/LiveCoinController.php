<?php

namespace App\Http\Controllers;

use App\Models\LiveCoinWatch;
use Yajra\DataTables\Facades\DataTables as Datatables;

class LiveCoinController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the coinbin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('livecoinwatch');
    }

    public function getLiveCoinData()
    {
        return Datatables::of(LiveCoinWatch::query()
            ->join('love_coin_histories', 'love_coin_histories.code', '=', 'live_coin_watches.code')
            ->where('rate', '>', 0)->get())
            ->make(true);
    }

}
