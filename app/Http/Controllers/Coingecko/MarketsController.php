<?php

namespace App\Http\Controllers\CoinGecko;

use App\Http\Controllers\Controller;
use App\Models\CoinGecko\CoinGeckoCoin;
use Yajra\DataTables\Facades\DataTables as Datatables;

class MarketsController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('coingecko.markets');
    }

    public function getData()
    {
        return Datatables::of( CoinGeckoCoin::join('coin_gecko_markets',
            'coin_gecko_coins.api_id', '=', 'coin_gecko_markets.api_id')->get())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 18px;'>
                           <p>".$item->symbol ."</p>
                        </span>";

            })
            ->editColumn('image', function ($image) {
                return '<img src="'.$image->image.'" height=50 width=50>';
            })
            ->editColumn('market_cap', function ($item) {
                return "<p class='success'>".number_format((float)$item->market_cap, 2, ',', ' ')."</p>";
            })
            ->editColumn('current_price', function ($item) {
                return "<p class='danger'>".number_format((float)$item->current_price, 2, ',', ' ')."</p>";
            })
            ->editColumn('circulatingSupply', function ($item) {
                return "<p class='warning'>".number_format((float)$item->circulatingSupply, 2, ',', ' ')."</p>";
            })
            ->editColumn('fully_diluted_valuation', function ($item) {
                return number_format((float)$item->fully_diluted_valuation, 2, ',', ' ');
            })
            ->editColumn('price_change_percentage_24h', function ($item) {
                return number_format((float)$item->price_change_percentage_24h, 2, ',', ' ');
            })
            ->editColumn('total_volume', function ($item) {
                return number_format((float)$item->total_volume, 2, ',', ' ');
            })
            ->editColumn('high_24h', function ($item) {
                return number_format((float)$item->high_24h, 2, ',', ' ');
            })
            ->editColumn('low_24h', function ($item) {
                return number_format((float)$item->low_24h, 2, ',', ' ');
            })
            ->editColumn('price_change_24h', function ($item) {
                return number_format((float)$item->price_change_24h, 2, ',', ' ');
            })
            ->editColumn('circulating_supply', function ($item) {
                return "<p class='danger'>".number_format((float)$item->circulating_supply, 2, ',', ' ')."</p>";
            })
            ->editColumn('market_cap_change_24h', function ($item) {
                return "<p class='warning'>".number_format((float)$item->market_cap_change_24h, 2, ',', ' ')."</p>";
            })
            ->editColumn('market_cap_change_percentage_24h', function ($item) {
                return "<p class='success'>".number_format((float)$item->market_cap_change_percentage_24h, 2, ',', ' ')."</p>";
            })
            ->editColumn('total_supply', function ($item) {
                return number_format((float)$item->total_supply, 2, ',', ' ');
            })
            ->editColumn('max_supply', function ($item) {
                return number_format((float)$item->max_supply, 2, ',', ' ');
            })
            ->editColumn('ath_change_percentage', function ($item) {
                return number_format((float)$item->ath_change_percentage, 2, ',', ' ');
            })
            ->editColumn('atl_change_percentage', function ($item) {
                return number_format((float)$item->atl_change_percentage, 2, ',', ' ');
            })
            ->editColumn('ath', function ($item) {
                return number_format((float)$item->ath, 2, ',', ' ');
            })
            ->editColumn('atl', function ($item) {
                return number_format((float)$item->atl, 2, ',', ' ');
            })
            ->editColumn('roi', function ($item) {
                if($item->roi === 'null') {
                    return ' - ';
                }

                if(!isset($item->roi)) {
                    return ' - ';
                }

                $json = json_decode($item->roi, true);
                $str = '<ul>';

                foreach ($json as $key => $inner) {
                    $str.= '<li>'.$key.' : '.$inner.'</li>';
                }

                $str.= '</ul>';

                return $str;
            })
            ->rawColumns([
                'name',
                'image',
                'market_cap',
                'current_price',
                'circulatingSupply',
                'roi',
                'circulating_supply',
                'market_cap_change_24h',
                'market_cap_change_percentage_24h',
            ])
            ->make(true);
    }
}