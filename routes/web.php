<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Landlord\PropertyListingController;
use App\Http\Controllers\Admin\AdminController;

// Home route
Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('home');

// Static page routes
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// House routes
Route::get('/houses', [HouseController::class, 'index'])->name('houses');
Route::get('/houses/{id}', [HouseController::class, 'show'])->name('house-detail');

// Payment routes (authenticated only)
Route::middleware(['auth'])->group(function () {
    Route::get('/property/{id}/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/property/{id}/payment', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/payment/success/{id}', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
});

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Profile routes (authenticated only)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [LoginController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [LoginController::class, 'updateProfile'])->name('profile.update');
});

// Admin routes
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/properties', [AdminController::class, 'properties'])->name('admin.properties');
    Route::post('/property/{id}/approve', [AdminController::class, 'approveProperty'])->name('admin.property.approve');
    Route::post('/property/{id}/reject', [AdminController::class, 'rejectProperty'])->name('admin.property.reject');
});

// Property listing routes (authenticated only)
Route::middleware('auth')->group(function () {
    Route::get('/property/listing', [PropertyListingController::class, 'index'])->name('property.listing');
    Route::post('/property/store', [PropertyListingController::class, 'store'])->name('property.store');
    Route::get('/property/edit/{id}', [PropertyListingController::class, 'edit'])->name('property.edit');
    Route::put('/property/update/{id}', [PropertyListingController::class, 'update'])->name('property.update');
    Route::delete('/property/delete/{id}', [PropertyListingController::class, 'destroy'])->name('property.delete');
});