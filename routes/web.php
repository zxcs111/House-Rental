<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\PaymentController;

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Broadcast;

use App\Http\Controllers\tenant\AboutController;
use App\Http\Controllers\tenant\ServicesController;
use App\Http\Controllers\tenant\BlogController;
use App\Http\Controllers\tenant\ContactController;

use App\Http\Controllers\Landlord\PropertyListingController;
use App\Http\Controllers\Landlord\CancellationController; 
use App\Http\Controllers\Landlord\FinancialReportingController;

use App\Http\Controllers\Admin\AdminController;


Broadcast::routes(['middleware' => ['auth']]);


// Home route
Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/services', [ServicesController::class, 'index'])->name('services');
    Route::get('/blog', [BlogController::class, 'index'])->name('blog');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
});

// House routes
Route::get('/houses', [HouseController::class, 'index'])->name('houses');
Route::get('/houses/{id}', [HouseController::class, 'show'])->name('house-detail');
Route::get('/messages/unread-count', [MessageController::class, 'unreadCount'])->name('messages.unread-count');

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
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
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

// Cancel payment/rent request
Route::post('/payments/{payment}/cancel', [PaymentController::class, 'requestCancellation'])
    ->name('payment.cancel')
    ->middleware('auth');

// Landlord routes
Route::middleware('auth')->group(function () {
    Route::get('/cancellation-requests', [CancellationController::class, 'cancellationRequests'])
        ->name('landlord.cancellation-requests');
    
    Route::post('/cancellation-requests/{payment}/approve', [CancellationController::class, 'approveCancellation'])
        ->name('landlord.cancellation.approve');
    
    Route::post('/cancellation-requests/{payment}/reject', [CancellationController::class, 'rejectCancellation'])
        ->name('landlord.cancellation.reject');
});


Route::group(['middleware' => 'auth'], function() {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/conversation/{user}', [MessageController::class, 'conversation'])->name('messages.conversation');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

    Route::post('/messages/delete-conversation', [MessageController::class, 'deleteConversation'])
    ->name('messages.delete-conversation');

    Route::get('/messages/new/{user}', [MessageController::class, 'getNewMessages'])->name('messages.new');

    // Mark as read routes
    Route::post('/messages/mark-as-read', [MessageController::class, 'markAsRead'])->name('messages.mark-as-read');
    Route::post('/messages/mark-conversation-read/{user}', [MessageController::class, 'markConversationAsRead'])
        ->name('messages.mark-conversation-read');
        
});


// Financial Reporting Routes
Route::group(['prefix' => 'landlord', 'middleware' => ['auth']], function() {
    Route::get('/financial-reporting', [FinancialReportingController::class, 'index'])
        ->name('landlord.financial-reporting');
        
    Route::delete('/financial-reporting/{payment}', [FinancialReportingController::class, 'destroy'])
        ->name('landlord.financial-reporting.destroy');
});


Route::get('/payments/{payment}/receipt', [PaymentController::class, 'receipt'])
    ->middleware('auth')
    ->name('payments.receipt');