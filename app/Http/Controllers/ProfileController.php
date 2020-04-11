<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileEmailSaveRequest;
use App\Http\Requests\ProfileNameSaveRequest;
use App\Http\Requests\ProfilePasswordSaveRequest;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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

        return ['status' => 'success', 'message' => 'nameSaved'];
    }

    public function email(ProfileEmailSaveRequest $request) 
    {
        $reverify = Auth::user()->email != $request->email;

        Auth::user()->email = $request->email;
        Auth::user()->save();

        if ($reverify) 
            Mail::to(Auth::user()->email)->queue(new VerifyEmail(Auth::user()));

        return ['status' => 'success', 'message' => 'emailSaved', 'needVerification' => $reverify];
    }

    public function password(ProfilePasswordSaveRequest $request) 
    {
        Auth::user()->password = Hash::make($request->password);
        Auth::user()->save();

        return ['status' => 'success', 'message' => 'passwordSaved'];
    }
}
