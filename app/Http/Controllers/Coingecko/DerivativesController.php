<?php

namespace App\Http\Controllers\CoinGecko;

use App\Http\Controllers\Controller;
use App\Models\CoinGecko\Derivatives;
use Yajra\DataTables\Facades\DataTables as Datatables;

class DerivativesController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('coingecko.derivatives');
    }

    public function getData()
    {
        return Datatables::of(Derivatives::all())
            ->editColumn('market', function ($item){
                return "<span style='font-size: 18px;'>
                         <input type='hidden' class='id' value='".$item->symbol."'/>
                          $item->symbol
                        </span>";

            })
            ->editColumn('volume_24h', function ($item) {
                return "<p class='warning'>".number_format((float)$item->volume_24h, 2, ',', ' ')."</p>";
            })
            ->editColumn('price_percentage_change_24h', function ($item) {
                return "<p class='success'>".number_format((float)$item->price_percentage_change_24h, 2, ',', ' ')."</p>";
            })
            ->editColumn('price', function ($item) {
                return "<p class='danger'>".number_format((float)$item->price, 2, ',', ' ')."</p>";
            })
            ->editColumn('funding_rate', function ($item) {
                return number_format((float)$item->funding_rate, 2, ',', ' ');
            })
            ->editColumn('open_interest', function ($item) {
                return number_format((float)$item->open_interest, 2, ',', ' ');
            })
            ->editColumn('spread', function ($item) {
                return number_format((float)$item->spread, 2, ',', ' ');
            })
            ->editColumn('basis', function ($item) {
                return number_format((float)$item->basis, 2, ',', ' ');
            })
            ->editColumn('index', function ($item) {
                return number_format((float)$item->index, 2, ',', ' ');
            })
            ->rawColumns([
                'market',
                'price',
                'volume_24h',
                'price_percentage_change_24h'
            ])
            ->make(true);
    }

}