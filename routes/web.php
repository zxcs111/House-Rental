<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HouseController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Landlord\PropertyListingController;
use App\Http\Controllers\Admin\AdminController;

// Home route
Route::get('/', function () {
    return view('welcome'); // Make sure you have a view file named 'welcome.blade.php'
})->name('home');


// Additional routes for other pages
Route::get('/about', function () {
    return view('about'); // Replace with your actual view
})->name('about');

Route::get('/services', function () {
    return view('services'); // Replace with your actual view
})->name('services');

Route::get('/pricing', function () {
    return view('pricing'); // Replace with your actual view
})->name('pricing');

Route::get('/houses', function () {
    return view('houses'); // Replace with your actual view
})->name('houses');

Route::get('/blog', function () {
    return view('blog'); // Replace with your actual view
})->name('blog');

Route::get('/contact', function () {
    return view('contact'); // Replace with your actual view
})->name('contact');

// Login and Registration routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/profile', [LoginController::class, 'profile'])->name('profile')->middleware('auth');
Route::post('/profile/update', [LoginController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

Route::get('/house-detail', [HouseController::class, 'showHouseDetail'])->name('house-detail');

Route::get('/blog-details', function () {
    return view('blog-details'); 
})->name('blog-details');


Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

// Admin Logout Route
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin Dashboard Route
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');


Route::middleware('auth')->group(function () {
    // Property Listing Routes
    Route::get('/property/listing', [PropertyListingController::class, 'index'])->name('property.listing');
    Route::post('/property/store', [PropertyListingController::class, 'store'])->name('property.store');
    Route::get('/property/edit/{id}', [PropertyListingController::class, 'edit'])->name('property.edit');
    Route::put('/property/update/{id}', [PropertyListingController::class, 'update'])->name('property.update');
    Route::delete('/property/delete/{id}', [PropertyListingController::class, 'destroy'])->name('property.delete');
});
