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
        return Datatables::of(Fiats::all())
            ->make(true);
    }

}
