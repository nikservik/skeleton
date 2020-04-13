<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordRemindController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

VerificationController::apiRoutes();
PasswordRemindController::apiRoutes();
AuthController::apiRoutes();
LocaleController::apiRoutes();
ProfileController::apiRoutes();
DemoController::apiRoutes();
