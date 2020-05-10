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
        Route::get('agreement', 'PlainContentController@agreement');
        Route::get('privacy', 'PlainContentController@privacy');
    }

    public function oferta()
    {
        return [
            'status' => 'success', 
            'content' => Storage::get('content/oferta.html'),
        ];
    }

    public function agreement()
    {
        return [
            'status' => 'success', 
            'content' => Storage::get('content/agreement.html'),
        ];
    }

    public function privacy()
    {
        return [
            'status' => 'success', 
            'content' => Storage::get('content/privacy.html'),
        ];
    }
}
