<?php

namespace App\Http\Controllers\Admin;

use Albakov\LaravelCloudPayments\LaravelCloudPayments;
use Albakov\LaravelCloudPayments\Notifications;
use App\Http\Controllers\Controller;
use App\Subscriptions\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Nikservik\Subscriptions\Models\Tariff;

class PaymentTestController extends Controller
{
    use Notifications; 

    static function routes()
    {
        Route::domain('admin.'.Str::after(config('app.url'),'//'))->middleware(['auth:web', 'isAdmin'])->namespace('Admin')->group(function () {
            Route::get('test', 'PaymentTestController@test');
            // Route::get('test/subscribe/{subscription}', 'PaymentTestController@subscribe');
            Route::get('test/charge', 'PaymentTestController@charge');
        });
    }

    public function test()
    {
        $tariff = Tariff::where('price','>',0)->first();
        return view('admin.test', ['tariff' => $tariff]);
    }

    public function charge()
    {
        $subscription = Auth::user()->subscription();
        if (! Auth::user()->token or $subscription->price <= 0)
            abort(404);
        $array = [
            'Amount' => $subscription->price, 
            'Currency' => $subscription->currency, 
            'InvoiceId' => $subscription->id, 
            'Token' => Auth::user()->token, 
            'Description' => 'Recharge by token',
            'AccountId' => Auth::user()->id,
            'Email' => Auth::user()->email,
        ];

        // Trying to do Payment
        try {
            (new LaravelCloudPayments)->tokensCharge($array);
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }

        return redirect('/test');
    }
}
