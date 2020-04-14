<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Nikservik\Subscriptions\Models\Feature;

class DemoController extends Controller
{
    public static function apiRoutes() 
    { 
        Route::get('books', 'DemoController@books');
        Route::get('money', 'DemoController@money');
    }

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function books()
    {
        $this->authorize('use', [Feature::class, 'read-books']);
        return ['status' => 'success', 'books' => ['Первая книга', 'Вторая книга']];
    }

    public function money()
    {
        $this->authorize('use', [Feature::class, 'earn-money']);
        return ['status' => 'success', 'money' => 1000000];
    }
}
