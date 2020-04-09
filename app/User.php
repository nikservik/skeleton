<?php

namespace App;

use App\Mail\PasswordReset;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'settings' => 'array',
    ];
    
    protected $appends = ['locale'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    public function sendPasswordResetNotification($token)
    {
        $message = (new PasswordReset($this, $token))->onQueue('emails');
        Mail::to($this->email)->queue($message);
    }    

    public function getLocaleAttribute() 
    {
        return Arr::get($this->settings, 'locale', App::getLocale());
    }   

    public function setLocaleAttribute($locale) 
    {
        if (! in_array($locale, config('app.locales')))
            return;

        $settings = $this->settings;
        $settings['locale'] = $locale;
        $this->settings = $settings;
    }   

}
