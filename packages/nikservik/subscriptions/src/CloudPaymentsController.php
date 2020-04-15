<?php

namespace Nikservik\Subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Nikservik\Subscriptions\Facades\Payments;

class CloudPaymentsController extends Controller
{
    public static function apiRoutes() 
    { 
        Route::post('api/cp/pay', 'Nikservik\Subscriptions\CloudPaymentsController@pay');
    }

    public function __construct()
    {
        $this->middleware(['api']);
    }

    public function pay(Request $request)
    {
        Log::debug($request);
        if (Payments::processPaymentConfirmation($request))
            return ['code' => 0];
        else
            return ['code' => 13];
    }
}