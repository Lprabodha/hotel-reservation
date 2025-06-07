<?php

use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\HotelController as AdminHotelController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Users\ClerksController;
use App\Http\Controllers\Admin\Users\ManagersController;
use App\Http\Controllers\Admin\Users\TravelCompaniesController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReservationController as ControllersReservationController;
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

Route::middleware(['auth', 'check_role:customer'])->group(function () {
    Route::get('/hotels/{hotel}/reserve', [HomeController::class, 'reservation'])->name('hotels.reserve');
});

Route::controller(ControllersReservationController::class)->group(function () {
    Route::post('/reservation', 'store')->name('reservation.store');
    Route::get('/check-availability', 'checkAvailability');
    Route::get('/reservation-confirmed/{reservation}', 'reservationConfirmed')->name('reservation.confirmed');
    Route::get('/reservations/{reservation}/download', 'downloadInvoice')->name('reservation.download');
});

Route::controller(HotelController::class)->group(function () {
    Route::get('/hotels', 'index')->name('hotels');
    Route::get('/hotel/{slug}', 'view')->name('hotel');
});

// Authentication routes
Route::group(['middleware' => ['role_or_permission:customer|travel-company']], function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/dashboard/reservations', 'reservations')->name('dashboard.reservations');
        Route::get('/dashboard/user-profile', 'getUserProfile')->name('view.profile');
        Route::post('/show/reservations', 'showReservation')->name('show.reservations');
        Route::get('/reservations/view/{id}', 'viewReservation')->name('view.reservations');
        Route::get('/request-reservations', 'requestReservation')->name('request.reservations');
        Route::post('/store-reservations', 'storeRequestReservation')->name('store.request.reservations');
        Route::post('/cancel-reservations/{id}', 'cancelReservation')->name('cancel.reservations');
        Route::get('/user-profile', 'getUserProfile')->name('view.profile');
    });
});

// Admin routes
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['role_or_permission:hotel-clerk|hotel-manager|super-admin']], function () {

    Route::controller(UserController::class)->group(function () {
        // Users
        Route::name('users.')->group(function () {
            Route::group(['middleware' => ['role_or_permission:super-admin']], function () {
                Route::get('/users', 'users')->name('index');
                Route::post('/get-users', 'getUsers')->name('get');
                Route::post('/change-role', 'changeUserRole')->name('role.change');
                Route::post('/delete-users', 'deleteUser')->name('delete');
                Route::get('/user-profile', 'getUserProfile')->name('view.profile');

                Route::name('role.')->group(function () {
                    Route::get('/users/roles', 'userRoles')->name('index');
                    Route::post('/users/get-roles', 'getUserRole')->name('get');
                    Route::get('/users/create-roles', 'createRole')->name('create');
                    Route::post('/users/save-roles', 'saveRole')->name('save');
                    Route::get('/users/update-roles/{id}', 'updateRole')->name('update');
                    Route::post('/users/edit-roles', 'editRole')->name('edit');
                    Route::post('/users/delete-role', 'deleteRole')->name('delete');
                });

                Route::name('permissions.')->group(function () {
                    Route::get('/users/permissions', 'userPermission')->name('index');
                    Route::post('/users/get-permissions', 'getPermissions')->name('get');
                    Route::get('/users/create-permissions', 'createPermissions')->name('create');
                    Route::post('/users/save-permissions', 'savePermissions')->name('save');
                    Route::get('/users/update-permissions/{id}', 'updatePermissions')->name('update');
                    Route::post('/users/edit-permissions', 'editPermissions')->name('edit');
                    Route::post('/users/delete-permissions', 'deletePermissions')->name('delete');
                });
            });
        });
    });

    Route::controller(ManagersController::class)->group(function () {
        Route::name('managers.')->group(function () {
            Route::group(['middleware' => ['role_or_permission:super-admin']], function () {
                Route::get('/managers', 'index')->name('index');
                Route::post('/show-managers', 'show')->name('show');
                Route::get('/managers/create', 'create')->name('create');
                Route::post('/managers/store', 'store')->name('store');
                Route::get('/managers/{id}', 'edit')->name('edit');
                Route::post('/managers/update', 'update')->name('update');
                Route::post('/managers/destroy', 'destroy')->name('destroy');
            });
        });
    });

    Route::controller(ClerksController::class)->group(function () {
        Route::name('hotel-clerks.')->group(function () {
            Route::group(['middleware' => ['role_or_permission:super-admin']], function () {
                Route::get('/hotel-clerks', 'index')->name('index');
                Route::post('/show-hotel-clerks', 'show')->name('show');
                Route::get('/hotel-clerks/create', 'create')->name('create');
                Route::post('/hotel-clerks/store', 'store')->name('store');
                Route::get('/hotel-clerks/{id}', 'edit')->name('edit');
                Route::post('/hotel-clerks/update', 'update')->name('update');
                Route::post('/hotel-clerks/destroy', 'destroy')->name('destroy');
            });
        });
    });

    Route::controller(TravelCompaniesController::class)->group(function () {
        Route::name('travel-companies.')->group(function () {
            Route::group(['middleware' => ['role_or_permission:super-admin']], function () {
                Route::get('/travel-companies', 'index')->name('index');
                Route::post('/show-travel-companies', 'show')->name('show');
                Route::get('/travel-companies/create', 'create')->name('create');
                Route::post('/travel-companies/store', 'store')->name('store');
                Route::get('/travel-companies/{id}', 'edit')->name('edit');
                Route::post('/travel-companies/update', 'update')->name('update');
                Route::post('/travel-companies/destroy', 'destroy')->name('destroy');
            });
        });
    });

    Route::controller(ReservationController::class)->group(function () {
        Route::name('reservation.')->group(function () {
            Route::get('/reservations', 'index')->name('index');
            Route::post('/reservations', 'show')->name('show');
            Route::get('/reservations/create', 'create')->name('create');
            Route::post('/reservations/store', 'store')->name('store');
            Route::get('/reservations/{id}', 'edit')->name('edit');
            Route::post('/reservations/update', 'update')->name('update');
            Route::post('/reservations/destroy', 'destroy')->name('destroy');
            Route::get('/reservations/filter', 'fetchRooms')->name('filter');
            Route::get('/reservations/view/{id}', 'view')->name('view');
            Route::get('/reservations/payment/{id}', 'payment')->name('payment');
            Route::post('/reservations/{id}/change-status', 'changeStatus')->name('changeStatus');
            Route::get('/admin/reservations/{reservation}/download', 'downloadInvoice')->name('download');
        });
    });

    Route::controller(PaymentController::class)->group(function () {
        Route::name('payments.')->group(function () {
            Route::get('/payments', 'index')->name('index');
            Route::post('/payments', 'show')->name('show');
            Route::post('/payments/{reservation}/cash-payment', 'cashPayment')->name('cashPayment');
            Route::post('/payments/{reservation}/stripe-payment', 'stripePayment')->name('stripePayment');
            Route::get('payments/stripe-success/{reservation}', 'stripeSuccess')->name('stripe.success');
        });
    });

    Route::controller(ReportController::class)->group(function () {
        Route::group(['middleware' => ['role_or_permission:hotel-manager']], function () {
            Route::name('reports.')->group(function () {
                Route::get('/reports', 'index')->name('index');
                Route::get('/reports-payments', 'payments')->name('payments');
                Route::post('/past-bill', 'bill')->name('bill');
                Route::post('/latest-reservation', 'latestReservation')->name('latest-reservation');
                Route::post('/past-reservation', 'pastReservation')->name('past-reservation');
                Route::post('/noshow-reservation', 'noShowReservation')->name('noshow-reservation');
            });
        });
    });

    Route::controller(CustomersController::class)->group(function () {
        Route::name('customers.')->group(function () {
            Route::get('/customers', 'index')->name('index');
            Route::post('/customers', 'show')->name('show');
        });
    });

    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/room-filter', [AdminDashboardController::class, 'fetchRooms'])->name('room-filter');
    Route::get('/get-customers', [AdminDashboardController::class, 'getCustomers'])->name('customers.list');
    Route::get('/get-travel-companies', [AdminDashboardController::class, 'getTravelCompany'])->name('list.travel-companies');
    /* Routes for hotels */
    Route::get('hotels', [AdminHotelController::class, 'index'])->name('hotels');
    Route::get('hotels/create', [AdminHotelController::class, 'create'])->name('hotels.create');
    Route::post('hotels/store', [AdminHotelController::class, 'store'])->name('hotels.store');
    Route::get('hotels/{slug}', [AdminHotelController::class, 'show'])->name('hotels.show');
    Route::get('hotels/{hotel}/edit', [AdminHotelController::class, 'edit'])->name('hotels.edit');
    Route::patch('hotels/{hotel}', [AdminHotelController::class, 'update'])->name('hotels.update');
    Route::delete('hotels/{hotel}', [AdminHotelController::class, 'destroy'])->name('hotels.destroy');
    /* Routes for rooms */

    Route::controller(RoomController::class)->prefix('rooms')->name('rooms.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{room}', 'show')->name('show');
        Route::get('/get', 'getRooms')->name('get');
        Route::put('/{room}', 'update')->name('update');
        Route::get('/{room}/edit', 'edit')->name('edit');
        Route::delete('/{room}', 'destroy')->name('destroy');
    });
});
