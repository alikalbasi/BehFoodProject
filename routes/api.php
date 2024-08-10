<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\CartController;
use \App\Http\Controllers\AddressController;
use \App\Http\Controllers\OrderController;

//Route::group([],function ($router){
//    $router->post('register', [\App\Http\Controllers\AuthController::class,'register']);
//    $router->post('login', [\App\Http\Controllers\AuthController::class,'login']);
//});
//
//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
//Route::get('/',[HomeController::class,'index'])->middleware('auth:sanctum')->name('home');
//Route::get('/show_product/{id}',[HomeController::class,'showProduct'])->middleware('auth:sanctum')->name('showProduct');
//Route::post('/add_to_cart',[CartController::class,'store'])->middleware('auth:sanctum')->name('add_to_cart');
//Route::get('/show_cart',[CartController::class,'showCart'])->middleware('auth:sanctum')->name('showCart');
//Route::post('/cart_less_item',[CartController::class,'lessItem'])->middleware('auth:sanctum')->name('lessItem');
//Route::post('/cart_more_item',[CartController::class,'moreItem'])->middleware('auth:sanctum')->name('moreItem');
//Route::delete('/destroy_cart',[CartController::class,'destroyCart'])->middleware('auth:sanctum')->name('destroyCart');
//Route::get('/show_address',[AddressController::class,'Show'])->middleware('auth:sanctum')->name('showAddress');
//Route::post('/add_address',[AddressController::class,'Add'])->middleware('auth:sanctum')->name('addAddress');
//Route::delete('/remove_address/{id}',[AddressController::class,'Remove'])->middleware('auth:sanctum')->name('removeAddress');
//Route::get('/show_orders',[OrderController::class,'Show'])->middleware('auth:sanctum')->name('showOrders');
//Route::post('/add_order',[OrderController::class,'Add'])->middleware('auth:sanctum')->name('addOrder');
//Route::delete('/remove_order/{id}',[OrderController::class,'Remove'])->middleware('auth:sanctum')->name('removeOrder');
//Route::get('/logout', function (){
//    \request()->user()->tokens()->delete();
//    return response([], 204);
//})->middleware('auth:sanctum');
//Route::post('/login', [AuthController::class, 'login'])->name('login');;
//Route::post('/verify', [AuthController::class, 'verify'])->name('verify');
//Route::post('/register', [AuthController::class, 'register'])->name('register');
//Route::get('/test',[HomeController::class,'test'])->middleware('auth:sanctum')->name('home');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Show product
    Route::get('/show_product/{id}', [HomeController::class, 'showProduct'])->name('showProduct');

    // Add To Cart
    Route::post('/add_to_cart', [CartController::class, 'store'])->name('add_to_cart');

    // Show Cart
    Route::get('/show_cart', [CartController::class, 'showCart'])->name('showCart');

    // Less Count Product
    Route::post('/cart_less_item', [CartController::class, 'lessItem'])->name('lessItem');

    // More Count Product
    Route::post('/cart_more_item', [CartController::class, 'moreItem'])->name('moreItem');

    // Destroy Cart
    Route::delete('/destroy_cart', [CartController::class, 'destroyCart'])->name('destroyCart');

    // Show Addresses
    Route::get('/show_address', [AddressController::class, 'Show'])->name('showAddress');

    // Add Address
    Route::post('/add_address', [AddressController::class, 'Add'])->name('addAddress');

    // Remove Address
    Route::delete('/remove_address/{id}', [AddressController::class, 'Remove'])->name('removeAddress');

    // Show Orders
    Route::get('/show_orders', [OrderController::class, 'Show'])->name('showOrders');

    // Add Order
    Route::post('/add_order', [OrderController::class, 'Add'])->name('addOrder');

    // LogOut User
    Route::get('/logout', function () {
        \request()->user()->tokens()->delete();
        return response([], 204);
    });
});

// Login User
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Verify User With Phone Number
Route::post('/verify', [AuthController::class, 'verify'])->name('verify');

// Register New User
Route::post('/register', [AuthController::class, 'register'])->name('register');
