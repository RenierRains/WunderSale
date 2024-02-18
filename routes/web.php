<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SearchController;

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

Route::get('/', [ItemController::class, 'index'])->name('home');

Route::resource('items', ItemController::class);

Route::resource('categories', CategoryController::class);

Route::get('/dashboard', [ItemController::class, 'index'])
->middleware(['auth', 'verified'])->name('home');

//IMPORTANT - make 
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');


//IMPORTNANT - make 
Route::middleware('auth')->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
});

Route::get('/messages/{userId}', [MessageController::class, 'show'])->name('messages.show');
Route::get('/messages/fetch/{userId}', [MessageController::class, 'fetchMessages'])->name('messages.fetch');

Route::get('/messages/compose/{user}', [MessageController::class, 'compose'])->name('messages.compose')->middleware('auth');

Route::get('/search', [SearchController::class, 'index'])->name('search');

require __DIR__.'/auth.php';
