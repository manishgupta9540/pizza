<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pizza\PizzaController;
use App\Http\Controllers\Order\OrderController;

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

// Route::get('/', function () {
//     return view('welcome');
// });




Route::get('/', [PizzaController::class, 'index'])->name('order.form');

Route::post('/calculate-price', [PizzaController::class, 'calculatePrice'])->name('calculate.price');
Route::post('/place-order', [OrderController::class, 'store'])->name('order.store');
