<?php

use App\Http\Controllers\Admin\HotelController as AdminHotelController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::controller(SocialController::class)->group(function () {
    Route::get('login/{provider}', 'redirect')->name('social.login');
    Route::get('login/{provider}/callback', 'callback');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/about-us', 'aboutUs')->name('about-us');
    Route::get('/contact-us', 'contact')->name('contact-us');
    Route::get('/faq', 'faq')->name('faq');
});

Route::controller(HotelController::class)->group(function () {
    Route::get('/hotels', 'index')->name('hotels');
    Route::get('/hotel/{slug}', 'view')->name('hotel');
});

// Authentication routes
Route::middleware(['auth'])->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/dashboard/reservations', 'reservations')->name('dashboard.reservations');
    });
});

// Admin routes
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['check_role:hotel-clerk,hotel-manager,super-admin']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reservations', [DashboardController::class, 'reservations'])->name('reservations');
    // Route::get('/hotels', [HotelController::class, 'index'])->name('hotels');
    Route::get('hotels', [AdminHotelController::class, 'index'])->name('hotels');
    Route::get('hotels/create', [AdminHotelController::class, 'create'])->name('hotels.create');
    Route::post('hotels/store', [AdminHotelController::class, 'store'])->name('hotels.store');
    Route::get('/hotels/{hotel}', [AdminHotelController::class, 'show'])->name('hotels.show');
    Route::get('/hotel/{slug}', [HotelController::class, 'view'])->name('hotel');
});
