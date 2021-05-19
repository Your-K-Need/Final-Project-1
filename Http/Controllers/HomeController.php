<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * the main home page application
     * will shown login dashboard
     * @return void
     */
    public function __construct()
    {
        $this->middleware('IsLogin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dasrhboard.index');
    }
}
