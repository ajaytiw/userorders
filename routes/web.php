<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\OrderController;

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
//     return view('frontend.login');
// })->name('login');



Route::get('/', [AuthController::class, 'index'])->name('login.view')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');


Route::group(['middleware' => 'auth'], function () {


    Route::get('/dashboard/{fromDate?}/{toDate?}/{filters?}', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::resource('users', UserController::class);
    Route::resource('orders', OrderController::class);

    // Route::get('/orders/create', [OrderController::class, 'create'])->name('order.form');


});