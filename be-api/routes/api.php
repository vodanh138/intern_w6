<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopController1;


Route::get('/', [ShopController::class, 'index']);
Route::get('/register', [ShopController::class, 'register']);
Route::post('/RegisterProcessing', [ShopController::class, 'RegisterProcessing']);
Route::post('/RegisterProcessingAdmin', [ShopController::class, 'RegisterProcessingAdmin']);
Route::get('/login', [ShopController::class, 'login'])->name('login');
Route::get('/logout', [ShopController::class, 'logout'])->name('logout');
Route::post('/LoginProcessing', [ShopController::class, 'LoginProcessing']);
Route::get('/PagingProduct', [ShopController::class, 'PagingProduct']);
Route::get('/product/{product}/edit', [ShopController1::class, 'edit_item']);
Route::get('/AddProduct', [ShopController::class, 'AddProduct']);
Route::post('/AddProcessing', [ShopController::class, 'AddProcessing']);
Route::get('/product/{product}', [ShopController::class, 'item_info']);
Route::put('/product/{product}', [ShopController::class, 'update']);
Route::delete('/product/{product}', [ShopController::class, 'delete']);
Route::get('/MyProduct', [ShopController::class, 'MyProduct']);


