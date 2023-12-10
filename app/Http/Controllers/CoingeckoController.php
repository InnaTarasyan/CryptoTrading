<?php

namespace App\Http\Controllers;

use App\Models\CoinGeckoMarkets;
use Yajra\DataTables\Facades\DataTables as Datatables;

class CoingeckoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the coinbin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('coingecko');
    }

    public function getCoingeckoData()
    {
        return Datatables::of(CoinGeckoMarkets::all())
            ->editColumn('image', function ($image) {
                return '<img src="'.$image->image.'" height=50 width=50>';
            })
            ->rawColumns(['image'])
            ->make(true);
    }

}
