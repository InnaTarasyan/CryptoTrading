<?php

namespace App\Http\Controllers;

use App\Models\Coinmarketcal;
use Yajra\DataTables\Facades\DataTables as Datatables;

class CoinMarketCalController extends Controller
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
        return view('coinmarketcal');
    }

    public function getCoinMarketCalData()
    {
        return Datatables::eloquent(Coinmarketcal::query())
            ->orderColumn('rank', false)
            ->toJson();

    }

}
