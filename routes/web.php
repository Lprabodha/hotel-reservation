<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();


Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/about-us', 'aboutUs')->name('about-us');
    Route::get('/contact-us', 'contact')->name('contact-us');
});

Route::controller(HotelController::class)->group(function () {
    Route::get('/hotels', 'index')->name('hotels');
    Route::get('/hotel/{slug}', 'view')->name('hotel');
});
