<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthNewPasswordRequest;
use App\Http\Requests\AuthRemindRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

class PasswordRemindController extends Controller
{
    public static function apiRoutes() 
    {
        Route::prefix('auth')->namespace('Auth')->group(function () {
            Route::post('remind', 'PasswordRemindController@remind');
            Route::post('checkToken', 'PasswordRemindController@checkToken');
            Route::post('newPassword', 'PasswordRemindController@newPassword');
        });
    }

    public function remind(AuthRemindRequest $request)
    {
        $response = Password::broker()->sendResetLink($request->only('email'));
        if ($response == Password::RESET_LINK_SENT)
            return [
                'status' => 'success', 
                'message' => 'link.sent'
            ];
        else
            return [ 
                'status' => 'error', 
                'message' => $response
            ];
    }

    public function checkToken(Request $request)
    {
        if (! $request->has('token') or ! $request->has('email'))
            return response()->json([
                'status' => 'error',
                'message' => 'errors.email'
            ], 403);

        if (is_null($user = Password::broker()->getUser($request->only('email'))))
            return response()->json([
                'status' => 'error',
                'message' => 'errors.email'
            ], 403);

        if (! Password::broker()->tokenExists($user, $request->token))
            return response()->json([
                'status' => 'error',
                'message' => 'errors.token'
            ], 403);

        return response()->json(['status' => 'success']);
    }

    public function newPassword(AuthNewPasswordRequest $request)
    {
        $response = Password::broker()->reset(
            $request->only(
                'email', 'password', 'password_confirmation', 'token'
            ), function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
                event(new PasswordReset($user));
            }
        );
        if ($response == Password::PASSWORD_RESET) {
            return response()->json([
                'status' => 'success',
                'message' => $response
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $response
            ]);
        }
    }
}
