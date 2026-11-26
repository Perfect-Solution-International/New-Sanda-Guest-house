<?php

use App\Http\Controllers\Admin\AddonAdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BookingAdminController;
use App\Http\Controllers\Admin\CustomerAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryAdminController;
use App\Http\Controllers\Admin\ReportAdminController;
use App\Http\Controllers\Admin\ReviewAdminController;
use App\Http\Controllers\Admin\RoomAdminController;
use App\Http\Controllers\Admin\RoomTypeAdminController;
use App\Http\Controllers\Admin\SettingAdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/facilities', [HomeController::class, 'facilities'])->name('facilities');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitInquiry'])->name('contact.submit');

// Rooms
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{slug}', [RoomController::class, 'show'])->name('rooms.show');

// Reservation & Tracking
Route::get('/book', [BookingController::class, 'create'])->name('booking.create');
Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking-confirmation/{code}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
Route::get('/track-booking', [BookingController::class, 'track'])->name('booking.track');
Route::post('/track-booking', [BookingController::class, 'checkStatus'])->name('booking.track.check');
Route::post('/track-booking/cancel', [BookingController::class, 'requestCancellation'])->name('booking.track.cancel');
Route::post('/track-booking/modify', [BookingController::class, 'requestModification'])->name('booking.track.modify');
Route::match(['get', 'post'], '/api/availability', [BookingController::class, 'checkLiveAvailability'])->name('api.availability');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Protected Admin Portal Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/timeline', [DashboardController::class, 'timeline'])->name('timeline');

    // Bookings
    Route::get('/bookings', [BookingAdminController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingAdminController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingAdminController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingAdminController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [BookingAdminController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingAdminController::class, 'update'])->name('bookings.update');
    Route::post('/bookings/{booking}/cancel', [BookingAdminController::class, 'cancel'])->name('bookings.cancel');
    Route::delete('/bookings/{booking}', [BookingAdminController::class, 'destroy'])->name('bookings.destroy');
    Route::get('/bookings/{booking}/invoice', [BookingAdminController::class, 'invoice'])->name('bookings.invoice');

    // Customer CRM, History & Blacklist
    Route::get('/customers', [CustomerAdminController::class, 'index'])->name('customers.index');
    Route::get('/customers/{customer}', [CustomerAdminController::class, 'show'])->name('customers.show');
    Route::put('/customers/{customer}', [CustomerAdminController::class, 'update'])->name('customers.update');
    Route::post('/customers/{customer}/toggle-blacklist', [CustomerAdminController::class, 'toggleBlacklist'])->name('customers.toggle-blacklist');
    Route::post('/customers/{customer}/toggle-vip', [CustomerAdminController::class, 'toggleVip'])->name('customers.toggle-vip');
    Route::delete('/customers/{customer}', [CustomerAdminController::class, 'destroy'])->name('customers.destroy');

    // Room Types (Categories)
    Route::resource('room-types', RoomTypeAdminController::class);

    // Physical Rooms
    Route::get('/rooms', [RoomAdminController::class, 'index'])->name('rooms.index');
    Route::post('/rooms', [RoomAdminController::class, 'store'])->name('rooms.store');
    Route::put('/rooms/{room}', [RoomAdminController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomAdminController::class, 'destroy'])->name('rooms.destroy');

    // Addons / Safari & Tour Packages
    Route::get('/addons', [AddonAdminController::class, 'index'])->name('addons.index');
    Route::post('/addons', [AddonAdminController::class, 'store'])->name('addons.store');
    Route::put('/addons/{addon}', [AddonAdminController::class, 'update'])->name('addons.update');
    Route::delete('/addons/{addon}', [AddonAdminController::class, 'destroy'])->name('addons.destroy');

    // Inquiries
    Route::get('/inquiries', [InquiryAdminController::class, 'index'])->name('inquiries.index');
    Route::post('/inquiries/{inquiry}/toggle', [InquiryAdminController::class, 'toggleReplied'])->name('inquiries.toggle');
    Route::delete('/inquiries/{inquiry}', [InquiryAdminController::class, 'destroy'])->name('inquiries.destroy');

    // Reviews
    Route::get('/reviews', [ReviewAdminController::class, 'index'])->name('reviews.index');
    Route::post('/reviews', [ReviewAdminController::class, 'store'])->name('reviews.store');
    Route::post('/reviews/{review}/toggle', [ReviewAdminController::class, 'toggleApproval'])->name('reviews.toggle');
    Route::delete('/reviews/{review}', [ReviewAdminController::class, 'destroy'])->name('reviews.destroy');

    // Reports, Analytics & Exports
    Route::get('/reports', [ReportAdminController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-bookings', [ReportAdminController::class, 'exportBookingsCsv'])->name('reports.export-bookings');
    Route::get('/reports/export-revenue', [ReportAdminController::class, 'exportRevenueCsv'])->name('reports.export-revenue');
    Route::get('/reports/export-rooms', [ReportAdminController::class, 'exportRoomsCsv'])->name('reports.export-rooms');
    Route::get('/reports/print', [ReportAdminController::class, 'printReport'])->name('reports.print');

    // Settings
    Route::get('/settings', [SettingAdminController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingAdminController::class, 'update'])->name('settings.update');
});
