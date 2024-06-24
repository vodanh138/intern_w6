<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController1;


Route::get('/', [ShopController1::class, 'index']);
Route::get('/register', [ShopController1::class, 'register']);
Route::post('/RegisterProcessing', [ShopController1::class, 'RegisterProcessing']);
Route::post('/RegisterProcessingAdmin', [ShopController1::class, 'RegisterProcessingAdmin']);
Route::get('/login', [ShopController1::class, 'login'])->name('login');
Route::get('/logout', [ShopController1::class, 'logout'])->name('logout')->middleware('auth');
Route::post('/LoginProcessing', [ShopController1::class, 'LoginProcessing']);
Route::get('/PagingProduct', [ShopController1::class, 'PagingProduct'])->middleware('auth');
Route::get('/AddProduct', [ShopController1::class, 'AddProduct'])->middleware('admin');
Route::post('/AddProcessing', [ShopController1::class, 'AddProcessing']);
Route::get('/product/{product}', [ShopController1::class, 'item_info'])->middleware('auth');
Route::get('/product/{product}/edit', [ShopController1::class, 'edit_item'])->middleware('admin');
Route::put('/product/{product}', [ShopController1::class, 'update']);
Route::delete('/product/{product}', [ShopController1::class, 'delete'])->middleware('admin');
Route::get('/MyProduct', [ShopController1::class, 'MyProduct'])->middleware('auth');


