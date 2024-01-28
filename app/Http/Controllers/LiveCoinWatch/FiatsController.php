<?php

namespace App\Http\Controllers\LiveCoinWatch;

use App\Http\Controllers\Controller;
use App\Models\LiveCoinWatch\Fiats;
use Yajra\DataTables\Facades\DataTables as Datatables;

class FiatsController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('livecoinwatch.fiats');
    }

    public function getData()
    {
        return Datatables::of(Fiats::query()->where('countries', '<>', null)->get())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 16px;'>
                           <input type='hidden' class='id' value='".$item->code."'/>
                           <p class='success'>$item->name</p>
                        </span>";

            })
            ->editColumn('countries', function ($item) {
                if(empty($item->countries)) {
                    return '';
                }
                $countriesList = json_decode($item->countries, true);
                $str =  '<ul>';
                foreach($countriesList as $country) {
                    $str.= '<li>'.$country.'</li>';
                }
                $str.=  '</ul>';
                return $str;
            })
            ->editColumn('flag', function ($item){
                return "<p class='danger'>".$item->flag."</p>";

            })
            ->rawColumns(['countries', 'name', 'flag'])
            ->make(true);
    }

}
