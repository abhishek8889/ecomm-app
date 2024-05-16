<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Admin\ProductController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function(){
    Route::post('/register','register');
    Route::post('/login','login');
});
Route::any('/logout', [AuthController::class,'logout'])->middleware('auth:api');

Route::group(['middleware' => ['auth:api']],function(){
    Route::prefix('/product')->group(function(){
        Route::controller(ProductController::class)->group(function(){
            Route::post('/store','store')->middleware('is_admin');
            Route::get('/list','list');
            Route::get('/details/{slug}','detail');
            Route::get('/search','findProduct');
        });
    });
});
Route::fallback(function () {
    throw new NotFoundHttpException();
});