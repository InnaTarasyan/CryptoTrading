<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables as Datatables;
use App\Coinbin;

class CoinbinController extends Controller
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
        return view('coinbin');
    }

    public function getCoinbinData()
    {
        return Datatables::of(Coinbin::all())
            ->make(true);
    }

}
