<?php

namespace App\Http\Controllers\CoinGecko;

use App\Http\Controllers\Controller;
use App\Models\CoinGecko\CoinGeckoTrending;
use Yajra\DataTables\Facades\DataTables as Datatables;

class TrendingsController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('coingecko.trendings');
    }

    public function getData()
    {
        return Datatables::of(CoinGeckoTrending::all())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 18px;'>
                           <input type='hidden' class='id' value='".$item->api_id."'/>
                           <p class='success'>".$item->name ."</p>
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
}