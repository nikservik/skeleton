<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PaymentTestController;
use App\Http\Controllers\Admin\TariffController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\VerificationController;
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

// Admin routes
LoginController::routes();
DashboardController::routes();
UserController::routes();
TariffController::routes();
PaymentTestController::routes();

// SPA route
Route::get('/{any?}', function (){
    return view('app');
})->where('any', '^(?!api\/|cp\/|email\/|auth\/)[\/\w\.-]*');

// Email verification
VerificationController::routes();


