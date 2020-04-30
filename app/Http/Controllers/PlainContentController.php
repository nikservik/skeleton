<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class PlainContentController extends Controller
{
    public static function apiRoutes() 
    { 
        Route::get('oferta', 'PlainContentController@oferta');
    }

    public function oferta()
    {
        return [
            'status' => 'success', 
            'content' => 'oferta',
            // 'content' => Storage::get('oferta.html'),
        ];
    }
    //
}
