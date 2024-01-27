<?php

namespace App\Http\Controllers\CoinGecko;

use App\Http\Controllers\Controller;
use App\Models\CoinGecko\Nfts;
use Yajra\DataTables\Facades\DataTables as Datatables;

class NftsController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('coingecko.nfts');
    }

    public function getData()
    {
        return Datatables::of(Nfts::all())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 18px;'>
                           <p class='pointer' data-id='".$item->api_id."'>".$item->name .'('.$item->api_id.')'."</p>
                        </span>";

            })
            ->rawColumns([
                'name'
            ])
            ->make(true);
    }

}