<?php

namespace App\Http\Controllers;

use App\Models\CoingeckoExchanges;
use App\Models\CoinGeckoMarkets;
use App\Models\CoinGeckoTrending;
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

    /**
     * Show the coinbin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexExchanges()
    {
        return view('coingeckoexchanges');
    }

    /**
     * Show the coinbin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexTrendings()
    {
        return view('coingeckotrendings');
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

    public function getCoingeckoExchangesData()
    {
        return Datatables::of(CoingeckoExchanges::all())
            ->editColumn('image', function ($item) {
                return '<img src="'.$item->image.'" height=50 width=50>';
            })
            ->editColumn('description', function($item) {
                return substr($item->description, 0, 30).'.....';
            })
            ->rawColumns(['image'])
            ->make(true);
    }

    public function getCoingeckoTrendingsData()
    {
        return Datatables::of(CoinGeckoTrending::all())
            ->editColumn('thumb', function ($item) {
                return '<img src="'.$item->thumb.'" height=50 width=50>';
            })
            ->editColumn('small', function ($item) {
                return '<img src="'.$item->small.'" height=50 width=50>';
            })
            ->editColumn('large', function ($item) {
                return '<img src="'.$item->large.'" height=50 width=50>';
            })
            ->rawColumns(['thumb', 'small', 'large'])
            ->make(true);
    }
}
