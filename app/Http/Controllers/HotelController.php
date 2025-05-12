<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        return view('hotel.index');
    }
    public function view($slug)
    {
        return view('hotel.view');
    }
}
