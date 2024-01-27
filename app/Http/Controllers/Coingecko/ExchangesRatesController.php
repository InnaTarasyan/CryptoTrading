<?php

namespace App\Http\Controllers\CoinGecko;

use App\Http\Controllers\Controller;
use App\Models\CoinGecko\CoinGeckoExchangeRates;
use Yajra\DataTables\Facades\DataTables as Datatables;

class ExchangesRatesController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('coingecko.exchanges_rates');
    }

    public function getData()
    {
        return Datatables::of(CoinGeckoExchangeRates::all())
            ->editColumn('symbol', function ($item){
                return "<span style='font-size: 18px;'>
                          $item->symbol
                        </span>";

            })
            ->editColumn('value', function ($item) {
                return "<p class='warning'>".
                    number_format((float)$item->value, 2, ',', ' ')."</p>";
            })
            ->editColumn('type', function ($item) {
                return "<p class='success'>".$item->type."</p>";
            })
            ->rawColumns([
                'symbol',
                'value',
                'type'
            ])
            ->make(true);
    }
}