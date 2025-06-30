<?php

namespace App\Http\Controllers\CoinGecko;

use App\Http\Controllers\Controller;
use App\Models\CoinGecko\DerivativesExchanges;
use Yajra\DataTables\Facades\DataTables as Datatables;

class DerivativesExchangesController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('coingecko.derivatives_exchanges');
    }

    public function getData()
    {

        return Datatables::of(DerivativesExchanges::all())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 16px;'>
                           <input type='hidden' class='id' value='".$item->api_id."'/>
                           <p class='success'>".$item->name ."</p>
                        </span>";

            })
            ->editColumn('description', function ($item) {
                return substr($item->description, 0, 100).' .... ';
            })
            ->editColumn('image', function ($item) {
                return '<img src="'.$item->image.'" height=50 width=50>';
            })
            ->editColumn('url', function($item) {
                return '<a href="'.$item->url.'">'.$item->url.'</a>';
            })
            ->editColumn('open_interest_btc', function ($item) {
                return "<p class='success'>".number_format((float)$item->open_interest_btc, 2, ',', ' ')."</p>";
            })
            ->editColumn('trade_volume_24h_btc', function ($item) {
                return "<p class='danger'>".number_format((float)$item->trade_volume_24h_btc, 2, ',', ' ')."</p>";
            })
            ->rawColumns([
                'name',
                'image',
                'url',
                'open_interest_btc',
                'trade_volume_24h_btc',
            ])
            ->make(true);
    }

}