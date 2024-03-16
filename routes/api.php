<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ItemAPIController;
use App\Http\Controllers\API\ProfileAPIController;
use App\Http\Controllers\API\CategoryAPIController;
use App\Http\Controllers\API\CartAPIController;
use App\Http\Controllers\API\AdminAPIController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\API\OrderAPIController;

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

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});


// Item routes
Route::apiResource('items', ItemAPIController::class);

// Profile routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile/', [ProfileAPIController::class, 'index']);
    Route::put('profile/update', [ProfileAPIController::class, 'update']);
    Route::delete('profile/delete', [ProfileAPIController::class, 'destroy']);
    Route::get('seller/{user}/profile', [ProfileAPIController::class, 'showSellerProfile']);

    Route::post('/items/create', [ItemAPIController::class, 'store']);
    Route::put('/items/{item}', [ItemController::class, 'update']);
    Route::delete('/items/{item}', [ItemApiController::class, 'destroy']);
    Route::get('user/items', [ItemController::class, 'userItems']);

});

// Category routes
Route::get('categories', [CategoryAPIController::class, 'index']);
Route::post('categories', [CategoryAPIController::class, 'store'])->middleware('auth:sanctum');


// Cart routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('cart', [CartAPIController::class, 'index']);
    Route::post('cart/add', [CartAPIController::class, 'add']);
    Route::delete('cart/remove', [CartAPIController::class, 'remove']);
    Route::post('cart/change-quantity', [CartAPIController::class, 'changeQuantity']);
});

// Admin routes 
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('admin/users', [AdminController::class, 'users']);
    Route::get('admin/items', [AdminController::class, 'items']);
    Route::delete('admin/user/{user}', [AdminController::class, 'destroyUser']);
});

// Login
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/finalize-checkout', [OrderAPIController::class, 'finalizeCheckout']);
    Route::get('/preview-checkout', [OrderAPIController::class, 'previewCheckout']);
    Route::get('/user-orders', [OrderAPIController::class, 'userOrders']);
});