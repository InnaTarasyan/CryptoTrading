<?php

namespace App\Http\Controllers\CoinGecko;

use App\Http\Controllers\Controller;
use App\Models\CoinGecko\CoingeckoExchanges;
use Yajra\DataTables\Facades\DataTables as Datatables;

class ExchangesController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('coingecko.exchanges');
    }

    public function getData()
    {
        return Datatables::of(CoingeckoExchanges::all())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 18px;'>
                           <p class='pointer' data-id='".$item->api_id."'>".$item->name ."</p>
                        </span>";

            })
            ->editColumn('trade_volume_24h_btc_normalized', function ($item) {
                return "<p class='warning'>".
                    number_format((float)$item->trade_volume_24h_btc_normalized, 2, ',', ' ')."</p>";
            })
            ->editColumn('image', function ($item) {
                return '<img src="'.$item->image.'" height=50 width=50>';
            })
            ->editColumn('description', function($item) {
                return substr($item->description, 0, 150).'.....';
            })
            ->editColumn('url', function($item) {
                return '<a href="'.$item->url.'">'.$item->url.'</a>';
            })
            ->editColumn('country', function($item) {
                return isset($item->country) ? $item->country : ' - ';
            })
            ->editColumn('has_trading_incentive', function($item) {
                return $item->has_trading_incentive ? 'Yes' : 'No';
            })
            ->rawColumns([
                'name',
                'image',
                'url',
                'trade_volume_24h_btc_normalized',
                'api_id',
            ])
            ->make(true);
    }

}