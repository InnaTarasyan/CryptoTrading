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
            ->editColumn('symbol', function ($item){
                return "<span style='font-size: 16px;'>
                           <input type='hidden' class='id' value='".strtolower($item->symbol)."'/>
                           <p class='success'>$item->symbol</p>
                        </span>";

            })
            ->rawColumns([ 'symbol'])
            ->make(true);

    }

}
