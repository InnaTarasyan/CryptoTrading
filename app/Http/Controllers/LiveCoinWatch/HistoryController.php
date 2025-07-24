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
                return "<span >
                           <input type='hidden' class='id' value='".strtolower($item->code)."'/>
                           <p>".$item->code.' '.(isset($item->symbol) ? '('.$item->symbol.')' : '')."</p>
                        </span>";

            })
            ->editColumn('png64', function ($item) {
                if (!empty($item->png64)) {
                    // Check if it's already a complete data URL
                    if (strpos($item->png64, 'data:image') === 0) {
                        return '<img class="previewable-img" src="'.$item->png64.'" alt="'.$item->code.' icon" style="width: 32px; height: 32px; object-fit: contain; border-radius: 50%; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); border: 2px solid #e2e8f0; background: white; padding: 2px;">';
                    }
                    // If it's just base64 data, construct the data URL
                    else if (base64_decode($item->png64, true) !== false) {
                        $dataUrl = 'data:image/png;base64,' . $item->png64;
                        return '<img class="previewable-img" src="'.$dataUrl.'" alt="'.$item->code.' icon" style="width: 32px; height: 32px; object-fit: contain; border-radius: 50%; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); border: 2px solid #e2e8f0; background: white; padding: 2px;">';
                    }
                    // If it's a URL, use it directly
                    else if (filter_var($item->png64, FILTER_VALIDATE_URL)) {
                        return '<img class="previewable-img" src="'.$item->png64.'" alt="'.$item->code.' icon" style="width: 32px; height: 32px; object-fit: contain; border-radius: 50%; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); border: 2px solid #e2e8f0; background: white; padding: 2px;">';
                    }
                }
                // Fallback for empty or invalid data
                return '<div style="width: 32px; height: 32px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #64748b; margin: 0 auto;">🪙</div>';
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
            ->rawColumns([ 'rate',  'maxSupply', 'totalSupply', 'circulatingSupply', 'categories'])
            ->make(true);
    }
}
