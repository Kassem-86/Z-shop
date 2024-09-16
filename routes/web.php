<?php
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('index'); // Ensure this view file exists in resources/views/index.blade.php
})->name('index');

Route::get('/cart', function () {
    return view('cart');
});
Route::get('/shop', function () {
    return view('items.shop');
});

Route::get('/wishlist', function () {
    return view('wishlist');
});


Route::middleware('auth')->group(function () {
    Route::get('admin/dashboard', [ItemController::class, 'index'])->name('admin.dashboard');
});
Route::middleware('auth')->group(function () {
    Route::get('admin/add', [ItemController::class, 'create'])->name('admin.create');
});

route::get('/shop', [ItemController::class, 'shop'])->name('shop');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

route::resource('items', ItemController::class);
// Category routes
Route::resource('categories', CategoryController::class)->except(['create', 'edit']);

route::get('/shop', [ItemController::class, 'shop'])->name('shop');


Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add/{item}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/wishlist/add/{item}', [WishlistController::class, 'add'])->name('wishlist.add');
});
route::get('/category/{id}', [CategoryController::class, 'showItems'])->name('category.items');

route::middleware(['auth'])->group(function () {  
      Route::get('/cart', [CartController::class, 'show'])->name('cart.show');   
       Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');});

       route::middleware(['auth'])->group(function () {   
         Route::get('/wishlist', [WishlistController::class, 'show'])->name('wishlist.show');    
        Route::delete('/wishlist/remove/{wishlist}', [WishlistController::class, 'remove'])->name('wishlist.remove');});

        route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
require __DIR__.'/auth.php';
