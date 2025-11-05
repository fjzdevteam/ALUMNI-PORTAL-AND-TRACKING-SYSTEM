<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestController extends Controller
{
    public function showWelcomePage()
    {
        return view('alumni.welcome');
    }

    public function showTermsAndPrivacy(): View
    {
        return view('alumni.terms');
    }
}
