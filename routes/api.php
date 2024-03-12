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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Item routes
Route::apiResource('items', ItemAPIController::class);
// for user specific items
Route::get('user/items', [ItemController::class, 'userItems'])->middleware('auth:api');

// Profile routes
Route::middleware('auth:api')->group(function () {
    Route::get('profile/edit', [ProfileController::class, 'edit']);
    Route::put('profile/update', [ProfileController::class, 'update']);
    Route::delete('profile/delete', [ProfileController::class, 'destroy']);
    Route::get('seller/{user}/profile', [ProfileController::class, 'showSellerProfile']);
});

// Category routes
Route::get('categories', [CategoryController::class, 'index']);
Route::post('categories', [CategoryController::class, 'store'])->middleware('auth:api');


// Cart routes
Route::middleware('auth:api')->group(function () {
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart/add', [CartController::class, 'add']);
    Route::delete('cart/remove', [CartController::class, 'remove']);
    Route::post('cart/change-quantity', [CartController::class, 'changeQuantity']);
});

// Admin routes 
Route::middleware(['auth:api', 'is_admin'])->group(function () {
    Route::get('admin/users', [AdminController::class, 'users']);
    Route::get('admin/items', [AdminController::class, 'items']);
    Route::delete('admin/user/{user}', [AdminController::class, 'destroyUser']);
});

// Login
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Registration
Route::post('/register', [RegisteredUserController::class, 'store']);