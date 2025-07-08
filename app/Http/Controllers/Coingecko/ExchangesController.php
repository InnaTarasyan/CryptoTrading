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
                return "<span style='font-size: 16px;'>
                           <input type='hidden' class='id' value='".$item->api_id."'/>
                           <p class='success'>".$item->name ."</p>
                        </span>";

            })
            ->editColumn('image', function ($image) {
                return '<img src="'.$image->image.'" height=25 width=25 class="previewable-img">';
            })
            ->editColumn('trade_volume_24h_btc_normalized', function ($item) {
                return "<p class='warning'>".
                    number_format((float)$item->trade_volume_24h_btc_normalized, 2, ',', ' ')."</p>";
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
                'url',
                'trade_volume_24h_btc_normalized',
                'api_id',
            ])
            ->make(true);
    }

}