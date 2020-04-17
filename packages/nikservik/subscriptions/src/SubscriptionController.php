<?php

namespace Nikservik\Subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Nikservik\Subscriptions\Facades\Subscriptions;
use Nikservik\Subscriptions\Models\Tariff;
use Nikservik\Subscriptions\Requests\ActivateSubscriptionRequest;

class SubscriptionController extends Controller
{
    public static function apiRoutes() 
    { 
        Route::get('api/subscriptions', 'Nikservik\Subscriptions\SubscriptionController@index');
        Route::post('api/subscriptions', 'Nikservik\Subscriptions\SubscriptionController@activate')->middleware('auth:api');
    }

    public function __construct()
    {
        $this->middleware(['api']);
    }

    public function index()
    {
        return [
            'status' => 'success',
            'data' => Subscriptions::list(),
        ];
    }

    public function activate(ActivateSubscriptionRequest $request)
    {
        $result = Subscriptions::activate(Auth::user(), Tariff::find($request->tariff));

        if (! $result)
            return ['status' => 'error'];

        return [
            'status' => 'success',
            'data' => [
                'subscription' => $result
            ]
        ];
    }
}