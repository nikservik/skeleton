<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public static function routes()
    {
        Route::domain('admin.'.Str::after(config('app.url'),'//'))->namespace('Admin')->group(function () {
            Route::get('dashboard', 'DashboardController@show');
            Route::get('/', 'DashboardController@show');
        });
    }

    public function __construct()
    {
        $this->middleware(['auth:web', 'isAdmin']);
    }
    
    public function show()
    {
        return view('admin.dashboard');
    }
}
