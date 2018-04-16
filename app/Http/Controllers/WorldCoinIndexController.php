<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables as Datatables;
use App\WorldCoinIndex;

class WorldCoinIndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the coinbin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('worldcoinindex');
    }

    public function getWorldCoinIndexData(){
        return Datatables::of(WorldCoinIndex::all())
            ->make(true);
    }
}
