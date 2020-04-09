<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthNewPasswordRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthRemindRequest;
use App\Mail\VerifyEmail;
use App\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public static function apiRoutes() 
    { 
        Route::prefix('auth')->namespace('Auth')->group(function () {
            Route::post('register', 'AuthController@register');
            Route::post('login', 'AuthController@login');
            Route::group(['middleware' => 'auth:api'], function(){
                Route::get('refresh', 'AuthController@refresh');
                Route::get('user', 'AuthController@user');
                Route::post('logout', 'AuthController@logout');
            });
        });
    }

    public function register(AuthRegisterRequest $request)
    {
        $user = new User($request->all());
        $user->password = Hash::make($request->password);
        $user->save();
        event(new Registered($user));

        return response()->json(['status' => 'success'], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        }
        return response()->json(['error' => 'login_error'], 401);
    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json(['status' => 'success'], 200);
    }

    public function user()
    {
        return response()->json([
            'status' => 'success',
            'data' => Auth::user()
        ]);
    }

    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    private function guard()
    {
        return Auth::guard('api');
    }
}
