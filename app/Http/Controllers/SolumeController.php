<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables as Datatables;
use App\Solume;

class SolumeController extends Controller
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
     * Show the solume dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('solume');
    }

    public function getSolumeData()
    {
        return Datatables::of(Solume::all())
                   ->make(true);
    }
}
