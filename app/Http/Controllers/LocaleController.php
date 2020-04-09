<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LocaleController extends Controller
{
    public static function apiRoutes() 
    { 
        Route::post('locale', 'LocaleController@locale')->middleware('auth:api');
    }

    public function locale(Request $request)
    {
        if(! in_array($request->locale, config('app.locales')))
            return ['error' => 'locale not exist'];

        Auth::user()->locale = $request->locale;
        Auth::user()->save();

        return ['status' => 'success'];
    }
}
