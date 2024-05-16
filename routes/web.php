<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Auth\AuthenticationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[FrontController::class,'index']);
Route::get('/products/detail/{slug}',[FrontController::class,'productDetail'])->name('product.detail');
Route::get('/cart-view',[FrontController::class,'cartView'])->name('cart-view');
Route::get('/cart',[FrontController::class,'cart'])->name('cart');
Route::post('/add-to-cart',[FrontController::class,'addToCart'])->name('add-to-cart');
Route::post('/remove-from-cart',[FrontController::class,'removeFromCart'])->name('remove.from.cart');
Route::post('/update-cart',[FrontController::class,'updateCart'])->name('update.cart');
Route::get('/search',[FrontController::class,'searchProduct'])->name('search');

Route::get('/login',[AuthenticationController::class , 'login'])->name('login');
Route::post('/login-process',[AuthenticationController::class , 'loginProcess'])->name('login.process');

Route::get('/register',[AuthenticationController::class , 'register'])->name('register');
Route::get('/logout',[AuthenticationController::class , 'logout'])->name('logout');

