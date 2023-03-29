<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Route::post('/dashboard/callback', [\App\Http\Controllers\TransactionController::class, 'store']);
Route::get('/dashboard/cart', [CartController::class, 'index'])->middleware(['auth'])->name('cart');
Route::get('/add-to-cart', [CartController::class, 'store'])->middleware(['auth'])->name('cart.add');
Route::get('/cart-delete-item', [CartController::class, 'detach'])->middleware(['auth'])->name('cart.destroy');
Route::get('/cart-fetch-total-price', [CartController::class, 'show'])->middleware(['auth'])->name('cart.show');
Route::get('/dashboard/add-address', [ContactController::class, 'show'])->middleware(['auth'])->name('card.verify');
Route::post('/dashboard/pay', [OrderController::class, 'show'])->middleware(['auth'])->name('pay');
//Route::get('/dashboard/callback', [TransactionController::class,'index']);
Route::get('/dashboard/callback', [TransactionController::class,'index']);
Route::post('/dashboard/callback',[TransactionController::class,'store']);


Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/api.php';
