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
                return "<span style='font-size: 16px;'>
                           <input type='hidden' class='id' value='".$item->api_id."'/>
                           <p class='success'>".$item->name ."</p>
                        </span>";

            })
            ->rawColumns([
                'name'
            ])
            ->make(true);
    }

}