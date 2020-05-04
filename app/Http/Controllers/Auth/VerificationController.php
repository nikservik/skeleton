<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerifyRequest;
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
            Route::post('email/verify', 'VerificationController@verify');
        });
    }

    public function verify(EmailVerifyRequest $request)
    {
        $user = User::find($request->user);

        if ($user->hasVerifiedEmail()) 
            return [ 
                'status' => 'success', 
            ];

        if(! hash_equals((string) $request->hash, sha1($user->email)))
            return response()->json([ 
                'status' => 'error', 
                'errors' => [ 'verify' => 'badLink' ],
            ], 403);

        if ($user->markEmailAsVerified()) 
            event(new Verified($user));

        return [ 
            'status' => 'success', 
        ];
    }

    public function resend()
    {
        
        Mail::to(Auth::user()->email)->queue(new VerifyEmail(Auth::user()));

        return [ 'status' => 'success' ];
    }
}
