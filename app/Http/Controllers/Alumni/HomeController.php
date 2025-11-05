<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\NewsDetail;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $news = NewsDetail::orderBy('date', 'desc')->take(3)->get();
        return view('alumni.portal.home.homepage', compact('news'));
    }

    public function show($id)
    {
        $newsItem = NewsDetail::findOrFail($id);
        return view('alumni.portal.home.home-view', compact('newsItem'));
    }
}
