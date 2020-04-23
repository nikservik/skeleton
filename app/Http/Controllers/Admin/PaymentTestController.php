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
            Route::get('testcrypt', 'PaymentTestController@testCrypt');
            Route::get('test/charge', 'PaymentTestController@charge');
            Route::post('test/charge', 'PaymentTestController@chargeCrypt');
        });
        Route::post('cp/frame', 'Admin\PaymentTestController@testFrame');
    }

    public function test()
    {
        $tariff = Tariff::where('price','>',0)->first();
        return view('admin.test', ['tariff' => $tariff]);
    }

    public function testCrypt()
    {
        $tariff = Tariff::where('price','>',0)->first();
        return view('admin.testcrypt', ['tariff' => $tariff]);
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

    public function chargeCrypt()
    {
        $request->validate(['tariff' => 'required', 'crypt' => 'required']);

        $tariff = Tariff::findOrFail($request->tariff);

        $array = [
            'Amount' => $tariff->price, 
            'Currency' => $tariff->currency, 
            'InvoiceId' => $tariff->id, 
            'IpAddress' => $request->ip(), 
            'Name' => 'test', 
            'CardCryptogramPacket' => Auth::user()->token, 
            'Description' => 'Charge by crypt',
            'AccountId' => Auth::user()->id,
        ];

        // Trying to do Payment
        try {
            (new LaravelCloudPayments)->tokensCharge($array);
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }

        return redirect('/test');
    }

    public function testFrame(Request $request)
    {
        return '<script>parent.closeFrame()</script>';
    }
}
