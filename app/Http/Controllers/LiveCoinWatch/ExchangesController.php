<?php

namespace App\Http\Controllers\LiveCoinWatch;

use App\Http\Controllers\Controller;
use App\Models\LiveCoinWatch\Exchanges;
use Yajra\DataTables\Facades\DataTables as Datatables;

class ExchangesController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('livecoinwatch.exchanges');
    }

    public function getData()
    {
        return Datatables::of(Exchanges::orderBy('code')
            ->orderBy('markets', 'DESC')
            ->get())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 16px;'>
                           <input type='hidden' class='id' value='".$item->code."'/>
                           <p class='success'>$item->name</p>
                        </span>";

            })
//            ->editColumn('png128', function ($image) {
//                return '<img src="'.$image->png128.'" height=50 width=50>';
//            })
            ->editColumn('bidTotal', function ($item) {
                return "<p class='success'>".number_format((float)$item->bidTotal, 2, ',', ' ')."</p>";
            })
            ->editColumn('askTotal', function ($item) {
                return "<p class='danger'>".number_format((float)$item->askTotal, 2, ',', ' ')."</p>";
            })
            ->editColumn('depth', function ($item) {
                return "<p class='warning'>".number_format((float)$item->depth, 2, ',', ' ')."</p>";
            })
            ->editColumn('centralized', function ($item) {
                return $item->centralized ? 'Yes' : 'No';
            })
            ->editColumn('usCompliant', function ($item) {
                return $item->usCompliant ? 'Yes' : 'No';
            })
            ->editColumn('volume', function ($item) {
                return number_format((float)$item->volume, 2, ',', ' ');
            })
            ->rawColumns(['name',  'bidTotal', 'askTotal', 'depth'])
            ->make(true);
    }

}
