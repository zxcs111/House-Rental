<?php

use Illuminate\Support\Facades\Route;

// Home route
Route::get('/', function () {
    return view('welcome'); // Make sure you have a view file named 'welcome.blade.php'
})->name('home');

// You can add additional routes for other pages as needed
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