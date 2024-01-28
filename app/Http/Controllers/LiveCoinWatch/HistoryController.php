<?php

namespace App\Http\Controllers\LiveCoinWatch;

use App\Http\Controllers\Controller;
use App\Models\LiveCoinWatch\LiveCoinWatch;
use Yajra\DataTables\Facades\DataTables as Datatables;

class HistoryController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('livecoinwatch.history');
    }

    public function getData()
    {
        return Datatables::of(LiveCoinWatch::query()
            ->join('live_coin_histories', 'live_coin_histories.code', '=', 'live_coin_watches.code')
            ->where('rate', '>', 0)->orderBy('rate', 'DESC')->get())
            ->editColumn('rate', function ($item) {
                return  "<p class='success'>".number_format((float)$item->rate, 2, '.', '')."</p>";
            })
            ->editColumn('code', function ($item){
                return "<span style='font-size: 20px;'>
                           <input type='hidden' class='id' value='".$item->code."'/>
                           <p style='text-decoration: underline solid ". $item->color." 4px'>$item->code</p>
                           <p>".(isset($item->symbol) ? '('.$item->symbol.')' : '')."</p>
                        </span>";

            })
            ->editColumn('png64', function ($image) {
                return '<img src="'.$image->png64.'" height=50 width=50>';
            })
            ->editColumn('volume', function ($item) {
                return number_format((float)$item->volume, 2, ',', ' ');
            })
            ->editColumn('cap', function ($item) {
                return number_format((float)$item->cap, 2, ',', ' ');
            })
            ->editColumn('maxSupply', function ($item) {
                return "<p class='success'>".number_format((float)$item->maxSupply, 2, ',', ' ')."</p>";
            })
            ->editColumn('totalSupply', function ($item) {
                return "<p class='danger'>".number_format((float)$item->totalSupply, 2, ',', ' ')."</p>";
            })
            ->editColumn('circulatingSupply', function ($item) {
                return "<p class='warning'>".number_format((float)$item->circulatingSupply, 2, ',', ' ')."</p>";
            })
            ->editColumn('allTimeHighUSD', function ($item) {
                return number_format((float)$item->allTimeHighUSD, 2, ',', ' ');
            })
            ->editColumn('categories', function ($item) {
                if(empty($item->categories)) {
                    return '';
                }
                $categoriesList = json_decode($item->categories, true);
                $str =  '<ul>';
                  foreach($categoriesList as $category) {
                      $str.= '<li>'.$category.'</li>';
                  }
                $str.=  '</ul>';
                return $str;
            })
            ->rawColumns(['code', 'rate', 'png64', 'maxSupply', 'totalSupply', 'circulatingSupply', 'categories'])
            ->make(true);
    }
}
