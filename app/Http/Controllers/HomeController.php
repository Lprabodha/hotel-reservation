<?php

namespace App\Http\Controllers;

use App\Models\Hotel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hotels = Hotel::all();

        return view('index', compact('hotels'));
    }

    public function aboutUs()
    {
        return view('pages.about-us');
    }

    public function contact()
    {
        return view('pages.contact-us');
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function reservation()
    {
        return view('reservation');
    }
}
