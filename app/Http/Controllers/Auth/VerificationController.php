<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class VerificationController extends Controller
{

    public static function apiRoutes() 
    {
        Route::namespace('Auth')->group(function () {
            Route::get('email/resend', 'VerificationController@resend')
            ->middleware('auth:api');
        });
    }

    public static function routes() 
    {
        Route::get('email/verify/{user}/{hash}', 'Auth\VerificationController@verify')
            ->middleware('throttle:6,1');
    }

    public function verify(User $user, $hash)
    {
        if ($user->hasVerifiedEmail()) 
            return redirect('/dashboard');

        if(! hash_equals((string) $hash, sha1($user->email)))
            return redirect('/login');

        if ($user->markEmailAsVerified()) 
            event(new Verified($user));

        return redirect('/dashboard');
    }

    public function resend()
    {
        
        Mail::to(Auth::user()->email)->queue(new VerifyEmail(Auth::user()));

        return [ 'status' => 'success' ];
    }
}
