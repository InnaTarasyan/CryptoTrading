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
                return '<img src="'.$item->image.'" height=32 width=32 class="previewable-img" style="object-fit:contain;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);cursor:pointer;">';
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
              //  'image',
                'url',
                'open_interest_btc',
                'trade_volume_24h_btc',
            ])
            ->make(true);
    }

}