<?php

namespace App\Http\Controllers;

use App\Models\Exchanges;
use Yajra\DataTables\Facades\DataTables as Datatables;

class ExchangesController extends Controller
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
        return view('exchanges');
    }

    public function getExchangesData()
    {
        return Datatables::of(Exchanges::orderBy('code')
            ->where('markets', '>', 0)
            ->orderBy('markets', 'DESC')
            ->get())
            ->make(true);
    }

}
