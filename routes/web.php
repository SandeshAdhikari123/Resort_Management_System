<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AboutusController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;

// Public routes
Route::get('/', [HomeController::class, 'home'])->name('home.index');
Route::get('/room-details/{id}', [DetailsController::class, 'room_details']);
Route::get('/rooms', [RoomController::class, 'show_room'])->name('rooms.show_room');
Route::get('/about-us', [AboutusController::class, 'view'])->name('aboutus.view');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.us.form');
Route::post('/order', [FoodOrderController::class, 'order'])->name('order.place');
Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.index');
Route::get('/dashboardview', [DashboardController::class, 'index'])->name('dashboardview');

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin dashboard
    // Room management
    Route::get('admin/add_room', [AdminController::class, 'add_room']);
    Route::post('/store_room', [AdminController::class, 'store_room']);
    Route::get('/view_room', [AdminController::class, 'view_room']);
    Route::delete('/delete_room/{id}', [AdminController::class, 'delete_room'])->name('rooms.delete');
    Route::get('/admin/edit_room/{id}', [AdminController::class, 'edit'])->name('admin.rooms.edit');
    Route::post('/admin/update_room/{id}', [AdminController::class, 'update'])->name('admin.rooms.update');

    // Food management
    Route::prefix('admin/food')->name('admin.food.')->group(function () {
        Route::get('/', [FoodController::class, 'index'])->name('index');
        Route::get('/create', [FoodController::class, 'create'])->name('create');
        Route::post('/', [FoodController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [FoodController::class, 'edit'])->name('edit');
        Route::put('/{id}', [FoodController::class, 'update'])->name('update');
        Route::delete('/{id}', [FoodController::class, 'destroy'])->name('destroy');
        Route::get('/orders', [FoodController::class, 'showFoodOrders'])->name('orders');
        Route::get('/completed-orders', [FoodController::class, 'showCompletedOrders'])->name('completed.orders');
        Route::post('/food/order/status/{id}', [FoodController::class, 'FoodStatusUpdate'])->name('food.status.update');
    });
    

    // Booked rooms
    Route::get('/admin/bookedrooms', [DetailsController::class, 'bookedRooms'])->name('admin.bookedrooms');

    // About Us management
    Route::get('/aboutus', [AboutusController::class, 'aboutus']);
    Route::post('/updateaboutus', [AboutusController::class, 'aboutusupdate'])->name('updateaboutus');

    // Banner management
    Route::prefix('banners')->name('banners.')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('index');
        Route::get('/add', [BannerController::class, 'create'])->name('create');
        Route::post('/insert', [BannerController::class, 'insert'])->name('insert');
        Route::get('/edit/{id}', [BannerController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [BannerController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [BannerController::class, 'destroy'])->name('delete'); 
    });
    

    // Contact management
    Route::prefix('admin/contacts')->name('admin.contacts.')->group(function () {
        Route::get('/', [ContactController::class, 'adminIndex'])->name('index');
    });
});

// Authenticated users can post contact forms
Route::middleware(['auth'])->post('contact-us', [ContactController::class, 'store'])->name('contact.us.store');
Route::post('/booking/{id}', [DetailsController::class, 'doBooking'])->name('booking.submit');

// Deletebookings at end date//
Route::get('/admin/expired-bookings', [DetailsController::class, 'expiredBookings'])->name('expired.bookings');

//Bookings
Route::get('/admin/approved-bookings', [DetailsController::class, 'approvedBookings'])->name('admin.approvedBookings');
Route::post('/booking/update-status/{id}', [DetailsController::class, 'updateBookingStatus'])->name('booking.update-status');


Route::middleware('auth')->group(function () {
    Route::get('/food', [FoodController::class, 'show'])->name('food.view');
    Route::post('/order', [FoodController::class, 'order'])->name('order.place');
    Route::get('/my-orders', [FoodController::class, 'myFoodOrders'])->name('orders.myfoodorders');
});

//AddStaff
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin views the staff registration form
    Route::get('/admin/register-staff', [AdminController::class, 'showRegisterForm'])->name('admin.registerStaffForm');
    
    // Admin registers a new staff
    Route::post('/admin/register-staff', [AdminController::class, 'registerStaff'])->name('admin.registerStaff');

    Route::get('/staff-users', [AdminController::class, 'showStaffUsers'])->name('staff.users');
    Route::delete('/staff/{id}', [AdminController::class, 'deleteStaff'])->name('staff.delete');
});
Route::get('/paysuccess', [DetailsController::class, 'paySuccess'])->name('paysuccess');
Route::get('/khaltipay/{roomId}', [DetailsController::class, 'khalticheck'])->name('khaltipay');
Route::get('/generate-report', [ReportController::class, 'generateReport'])->name('generate.report');

Route::get('user/{userId}/previous-bookings', [DetailsController::class, 'previousBookings'])->name('user.previous_bookings');
