<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
Route::get('/products/{id}/delete', [App\Http\Controllers\ProductController::class, 'destroy'])->name('delete');
Route::post('/products/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('update');
Route::post('/products/create', [App\Http\Controllers\ProductController::class, 'store'])->name('store');
Route::post('/upload', [App\Http\Controllers\ProductController::class, 'upload'])->name('upload');
