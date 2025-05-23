<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;

use App\Http\Controllers\HouseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MessageController;

use App\Http\Controllers\tenant\AboutController;
use App\Http\Controllers\tenant\ServicesController;
use App\Http\Controllers\tenant\ContactController;

use App\Http\Controllers\Landlord\PropertyListingController;
use App\Http\Controllers\Landlord\CancellationController; 
use App\Http\Controllers\Landlord\FinancialReportingController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\TotalUserController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\TransactionController;


Broadcast::routes(['middleware' => ['auth']]);


Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('home');

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/services', [ServicesController::class, 'index'])->name('services');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'sendMessage'])->name('contact.send');

Route::get('/houses', [HouseController::class, 'index'])->name('houses');
Route::get('/houses/{id}', [HouseController::class, 'show'])->name('house-detail');
Route::get('/messages/unread-count', [MessageController::class, 'unreadCount'])->name('messages.unread-count');

Route::post('/properties/{property}/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::get('/property/{id}/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/property/{id}/payment', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/payment/success/{id}', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/verify-email', [LoginController::class, 'showVerifyEmailForm'])->name('verify.email.form');
Route::post('/verify-email', [LoginController::class, 'verifyEmail'])->name('verify.email');

Route::get('/password/reset', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/password/email', [LoginController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [LoginController::class, 'showResetPasswordForm'])->name('password.reset.form');
Route::post('/password/reset', [LoginController::class, 'resetPassword'])->name('password.reset');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/tenant/payments/{id}/hide', [ProfileController::class, 'hidePayment'])->name('tenant.payment.hide');
});

Route::middleware('auth')->group(function () {
    Route::get('/property/listing', [PropertyListingController::class, 'index'])->name('property.listing');
    Route::post('/property/store', [PropertyListingController::class, 'store'])->name('property.store');
    Route::get('/property/edit/{id}', [PropertyListingController::class, 'edit'])->name('property.edit');
    Route::put('/property/update/{id}', [PropertyListingController::class, 'update'])->name('property.update');
    Route::delete('/property/delete/{id}', [PropertyListingController::class, 'destroy'])->name('property.delete');
});

Route::post('/payments/{payment}/cancel', [PaymentController::class, 'requestCancellation'])
    ->name('payment.cancel')
    ->middleware('auth');

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

    Route::post('/messages/mark-as-read', [MessageController::class, 'markAsRead'])->name('messages.mark-as-read');
    Route::post('/messages/mark-conversation-read/{user}', [MessageController::class, 'markConversationAsRead'])
        ->name('messages.mark-conversation-read');
        
});

Route::group(['prefix' => 'landlord', 'middleware' => ['auth']], function() {
    Route::get('/financial-reporting', [FinancialReportingController::class, 'index'])
        ->name('landlord.financial-reporting');
        
    Route::delete('/financial-reporting/{payment}', [FinancialReportingController::class, 'destroy'])
        ->name('landlord.financial-reporting.destroy');
});


Route::get('/payments/{payment}/receipt', [PaymentController::class, 'receipt'])
    ->middleware('auth')
    ->name('payments.receipt');

Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/profile-update', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/notifications/mark-as-read', [DashboardController::class, 'markNotificationsAsRead'])->name('notifications.markAsRead');

    Route::get('/properties', [PropertyController::class, 'property'])->name('properties');
    Route::post('/properties/{property}/approve', [PropertyController::class, 'approve'])->name('properties.approve');
    Route::post('/properties/{property}/disapprove', [PropertyController::class, 'disapprove'])->name('properties.disapprove');
    
    Route::get('/total-users', [TotalUserController::class, 'totaluser'])->name('total-users');
    Route::get('/total-users/{id}', [TotalUserController::class, 'show'])->name('user-detail');
    Route::get('/total-users/create', [TotalUserController::class, 'create'])->name('create-user');
    Route::post('/total-users/store', [TotalUserController::class, 'store'])->name('store-user');
    Route::get('/total-users/edit/{id}', [TotalUserController::class, 'edit'])->name('edit-user');
    Route::put('/total-users/update/{id}', [TotalUserController::class, 'update'])->name('update-user'); 
    Route::delete('/total-users/delete/{id}', [TotalUserController::class, 'destroy'])->name('delete-user'); 

    Route::get('/transactions', [TransactionController::class, 'transactions'])->name('transactions');

    Route::get('/reports', [ReportsController::class, 'reports'])->name('reports');
    Route::get('/reports/download', [ReportsController::class, 'download'])->name('reports.download');
});