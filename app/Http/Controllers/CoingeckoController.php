<?php

namespace App\Http\Controllers;

use App\Models\CoinGeckoCategories;
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
            ->editColumn('name', function ($item){
                return "<span style='font-size: 18px;'>
                           <p>".$item->name .'('.$item->api_id.')'."</p>
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

    public function getCoingeckoExchangesData()
    {
        return Datatables::of(CoingeckoExchanges::all())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 18px;'>
                           <p>".$item->name .'('.$item->api_id.')'."</p>
                        </span>";

            })
            ->editColumn('trade_volume_24h_btc_normalized', function ($item) {
                return "<p class='warning'>".
                    number_format((float)$item->trade_volume_24h_btc_normalized, 2, ',', ' ')."</p>";
            })
            ->editColumn('image', function ($item) {
                return '<img src="'.$item->image.'" height=50 width=50>';
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
                'image',
                'url',
                'trade_volume_24h_btc_normalized',
                'api_id',
                ])
            ->make(true);
    }

    public function getCoingeckoTrendingsData()
    {
        return Datatables::of(CoinGeckoTrending::all())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 18px;'>
                           <p>".$item->name .'('.$item->api_id.')'."</p>
                        </span>";

            })
            ->editColumn('small', function ($item) {
                return '<img src="'.$item->small.'" height=50 width=50>';
            })
            ->editColumn('price_btc', function ($item) {
                return "<p class='warning'>".$item->price_btc."</p>";
            })
            ->editColumn('data', function ($item) {
                if(empty($item->data)) {
                    return ' - ';
                }
                $json = json_decode($item->data, true);
                $str = '<ul>';

                foreach ($json as $key => $inner) {
                    $innerValue = $inner;
                    if(is_array($inner)) {
                       $innerValue = '<ul>';
                       $counter = 1;
                       foreach ($inner as  $value) {
                           $innerValue.= '<li>'.substr($value, 0, 150).'.....'.'</li>';
                           if($counter >= 5) {
                               $innerValue.= '......';
                               break;
                           }
                           $counter++;
                       }
                       $innerValue.= '</ul>';
                    }
                    $str.= '<li>'.$key.' : '.$innerValue.'</li>';
                }

                $str.= '</ul>';
                return $str;
            })
            ->rawColumns([
                'name',
                'small',
                'price_btc',
                'data'
            ])
            ->make(true);
    }


    public function getCoingeckoExchangeRatesData()
    {
        return Datatables::of(CoinGeckoExchangeRates::all())
            ->editColumn('symbol', function ($item){
                return "<span style='font-size: 18px;'>
                          $item->symbol
                        </span>";

            })
            ->editColumn('value', function ($item) {
                return "<p class='warning'>".
                    number_format((float)$item->value, 2, ',', ' ')."</p>";
            })
            ->editColumn('type', function ($item) {
                return "<p class='success'>".$item->type."</p>";
            })
            ->rawColumns([
                'symbol',
                'value',
                'type'
            ])
            ->make(true);
    }

    public function indexNfts()
    {
        return view('nfts');
    }

    public function getCoingeckoNftsData()
    {
        return Datatables::of(Nfts::all())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 18px;'>
                           <p>".$item->name .'('.$item->api_id.')'."</p>
                        </span>";

            })
            ->rawColumns([
               'name'
            ])
            ->make(true);
    }

    public function indexDerivatives()
    {
        return view('derivatives');
    }

    public function getDerivativesData()
    {
        return Datatables::of(Derivatives::all())
            ->editColumn('market', function ($item){
                return "<span style='font-size: 18px;'>
                          $item->market
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

    public function indexCategories()
    {
        return view('coingeckocategories');
    }

    public function getCategoriesData()
    {
        return Datatables::of(CoinGeckoCategories::all())
            ->make(true);
    }
}
