<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    /**
     * Display the Terms of Use page
     */
    public function termsOfUse()
    {
        return view('terms-of-use');
    }

    /**
     * Display the Privacy Policy page
     */
    public function privacyPolicy()
    {
        return view('privacy-policy');
    }
} 