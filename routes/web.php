<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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
