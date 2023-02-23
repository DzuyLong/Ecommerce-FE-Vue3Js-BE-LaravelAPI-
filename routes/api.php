<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProductInventoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\IndexConCustomerProfileControllertroller;
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

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/user', [\App\Http\Controllers\Api\AuthController::class, 'getUser']);
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    
    Route::apiResource('productCategory', ProductCategoryController::class);
    Route::apiResource('productInventory', ProductInventoryController::class);
    Route::apiResource('products', ProductController::class);
});
Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware(['customerOrVerified'])->group(function () {
    Route::get('get-products', [IndexController::class, 'index']);
    Route::get('get-product-slides', [IndexController::class, 'slides']);
    Route::get('get-listPC', [IndexController::class, 'listCate']);
    Route::get('danh-muc/{slug}', [IndexController::class, 'Category']);
    Route::get('product-detail/{slug}', [IndexController::class, 'ProductDetail']);
});

Route::middleware(['auth:sanctum','customerVerified'])->group(function () {
    Route::get('/customer', [\App\Http\Controllers\Api\CustomerController::class, 'getCustomer']);
    Route::post('/logoutCustomer', [\App\Http\Controllers\Api\CustomerController::class, 'logoutCustomer']);
    Route::post('add-cart',[\App\Http\Controllers\Api\CartController::class, 'addCart']);
    Route::post('get-cart',[\App\Http\Controllers\Api\CartController::class, 'Cart']);
    Route::post('update-cart-quantity',[\App\Http\Controllers\Api\CartController::class, 'updateCartQuantity']);
    Route::post('remove-from-cart',[\App\Http\Controllers\Api\CartController::class, 'removeFromCart']);
    Route::get('fetch-provinces',[\App\Http\Controllers\Api\CustomerProfileController::class, 'fetchProvinces']);
    Route::get('fetch-districts/{idProvince}',[\App\Http\Controllers\Api\CustomerProfileController::class, 'fetchDistricts']);
    Route::get('fetch-wards/{idDistrict}',[\App\Http\Controllers\Api\CustomerProfileController::class, 'fetchWards']);
    Route::post('add-address',[\App\Http\Controllers\Api\CustomerProfileController::class, 'addAddress']);
    Route::get('get-address',[\App\Http\Controllers\Api\CustomerProfileController::class, 'getAddress']);
    Route::delete('delete-address/{addressId}',[\App\Http\Controllers\Api\CustomerProfileController::class, 'deleteAddress']);
    Route::post('update-profile',[\App\Http\Controllers\Api\CustomerProfileController::class, 'updateProfile']);
    Route::post('checkout',[\App\Http\Controllers\Api\CustomerProfileController::class, 'checkout']);
});
Route::post('/loginCustomer', [\App\Http\Controllers\Api\CustomerController::class, 'loginCustomer']);
Route::post('/registerCustomer', [\App\Http\Controllers\Api\CustomerController::class, 'registerCustomer']);




    


