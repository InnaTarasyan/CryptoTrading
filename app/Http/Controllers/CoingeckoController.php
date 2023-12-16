<?php

namespace App\Http\Controllers;

use App\Models\CoinGeckoExchangeRates;
use App\Models\CoingeckoExchanges;
use App\Models\CoinGeckoMarkets;
use App\Models\CoinGeckoTrending;
use App\Models\Derivatives;
use App\Models\DerivativesExchanges;
use App\Models\Nfts;
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
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('coingecko');
    }

    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function indexExchanges()
    {
        return view('coingeckoexchanges');
    }

    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function indexTrendings()
    {
        return view('coingeckotrendings');
    }

    public function indexRates()
    {
        return view('coingeckoexchangesrates');
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


    public function getCoingeckoExchangeRatesData()
    {
        return Datatables::of(CoinGeckoExchangeRates::all())
            ->make(true);
    }

    public function indexNfts()
    {
        return view('nfts');
    }

    public function getCoingeckoNftsData()
    {
        return Datatables::of(Nfts::all())
            ->make(true);
    }

    public function indexDerivatives()
    {
        return view('derivatives');
    }

    public function getDerivativesData()
    {
        return Datatables::of(Derivatives::all())
            ->make(true);
    }

    public function indexDerivativesExchanges()
    {
        return view('derivativesExchanges');
    }

    public function getDerivativesExchangesData()
    {
        return Datatables::of(DerivativesExchanges::all())
            ->editColumn('description', function ($item) {
                return substr($item->description, 0, 30).' .... ';
            })
            ->make(true);
    }
}
