<?php

namespace App\Http\Controllers;

use App\Models\Fiats;
use Yajra\DataTables\Facades\DataTables as Datatables;

class FiatsController extends Controller
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
        return view('fiats');
    }

    public function getFiatsData()
    {
        return Datatables::of(Fiats::query()->where('countries', '<>', null)->get())
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
            ->editColumn('code', function ($item){
                return "<span style='font-size: 20px;'>
                           <p class='success'>$item->code</p>
                           <p>".(isset($item->symbol) ? '('.$item->symbol.')' : '')."</p>
                        </span>";

            })
            ->editColumn('flag', function ($item){
                return "<p class='danger'>".$item->flag."</p>";

            })
            ->rawColumns(['countries', 'code', 'flag'])
            ->make(true);
    }

}
