<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermPolicyController extends Controller
{
    /**
     * This is used to get terms
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTerms()
    {
        return view('terms-of-service');
    }

    /**
     * This is used to get privacy policy
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPrivacyPolicy()
    {
        return view('privacy-policy');
    }
}
