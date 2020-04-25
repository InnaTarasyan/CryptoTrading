<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    public function index()
    {
        if(view()->exists('profile')){
            return view('profile')->with([
                'title' => 'Profile']);
        }
        abort(404);
    }
}
