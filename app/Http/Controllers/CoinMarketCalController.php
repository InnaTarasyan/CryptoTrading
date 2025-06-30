<?php

namespace App\Http\Controllers;

use App\Models\CoinMarketCal\CoinMarketCal;
use Yajra\DataTables\Facades\DataTables as Datatables;

class CoinMarketCalController extends Controller
{
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
