<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileEmailSaveRequest;
use App\Http\Requests\ProfileNameSaveRequest;
use App\Http\Requests\ProfilePasswordSaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Nikservik\LaravelJwtAuth\Mail\VerifyEmail;

class ProfileController extends Controller
{
    public static function apiRoutes() 
    { 
        Route::post('user/name', 'ProfileController@name');
        Route::post('user/email', 'ProfileController@email');
        Route::post('user/password', 'ProfileController@password');
    }

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function name(ProfileNameSaveRequest $request) 
    {
        Auth::user()->name = $request->name;
        Auth::user()->save();

        return ['status' => 'success'];
    }

    public function email(ProfileEmailSaveRequest $request) 
    {
        if (Auth::user()->email == $request->email)
            return ['status' => 'success'];

        Auth::user()->email = $request->email;
        Auth::user()->email_verified_at = null;
        Auth::user()->save();

        Mail::to(Auth::user()->email)->queue(new VerifyEmail(Auth::user()));

        return ['status' => 'success'];
    }

    public function password(ProfilePasswordSaveRequest $request) 
    {
        Auth::user()->password = Hash::make($request->password);
        Auth::user()->save();

        return ['status' => 'success'];
    }
}
