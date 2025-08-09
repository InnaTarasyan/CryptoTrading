<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('account.index');
    }

    public function profile()
    {
        return view('account.profile');
    }

    public function security()
    {
        return view('account.security');
    }

    public function notifications()
    {
        return view('account.notifications');
    }

    public function connections()
    {
        return view('account.connections');
    }

    public function apiKeys()
    {
        return view('account.api_keys');
    }

    public function billing()
    {
        return view('account.billing');
    }

    public function support()
    {
        return view('account.support');
    }
} 