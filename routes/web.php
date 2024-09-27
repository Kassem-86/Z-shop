<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Http\Controllers\Auth\GoogleController;
use App\Models\Order;

// Payment Routes
Route::get('/payment', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');


Route::get('/orders', function () {
    $orders = Order::where('user_id', auth()->id())->get();
    return view('orders', compact('orders'));
})->middleware('auth')->name('orders');

// Home Page Route
Route::get('/', function () {
    return view('index'); // Ensure this view file exists
})->name('index');

// Google Authentication Routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Test Email Route
Route::get('/test-email', function() {
    $name = 'kassem';
    Mail::to('ziadkassem54@gmail.com')->send(new WelcomeMail($name));
    return 'Email Sent';
});

// Shopping Routes
Route::get('/shop', [ItemController::class, 'shop'])->name('shop');

// Cart Routes
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::middleware('auth')->group(function () {
    Route::post('/cart/add/{item}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');
});

// Wishlist Routes
Route::get('/wishlist', [WishlistController::class, 'show'])->name('wishlist.show');
Route::middleware('auth')->group(function () {
    Route::post('/wishlist/add/{item}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{wishlist}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Item and Category Routes
Route::resource('items', ItemController::class);
Route::resource('categories', CategoryController::class)->except(['create', 'edit']);
Route::get('/category/{id}', [CategoryController::class, 'showItems'])->name('category.items');

// Admin Routes
Route::middleware('auth')->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/add', [AdminController::class, 'create'])->name('admin.create');
});

// Ensure Auth Routes are required
require __DIR__.'/auth.php';
