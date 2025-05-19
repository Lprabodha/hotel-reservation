<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/about-us', 'aboutUs')->name('about-us');
    Route::get('/contact-us', 'contact')->name('contact-us');
    Route::get('/faq', 'faq')->name('faq');
});

Route::controller(DashboardController::class)->group(function () {

    Route::get('/dashboard', 'index')->name('dashboard');
    Route::get('/dashboard/reservations', 'reservations')->name('dashboard.reservations');
});

Route::controller(HotelController::class)->group(function () {
    Route::get('/hotels', 'index')->name('hotels');
    Route::get('/hotel/{slug}', 'view')->name('hotel');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['checkRole:hotel-clerk,hotel-manager,super-admin']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reservations', [DashboardController::class, 'reservations'])->name('reservations');
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels');
    Route::get('/hotel/{slug}', [HotelController::class, 'view'])->name('hotel');
});

Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
