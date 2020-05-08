<?php

namespace App;

use App\Mail\PasswordReset;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Nikservik\LaravelJwtAuth\Interfaces\RoleBased;
use Nikservik\LaravelJwtAuth\Traits\JwtAuth;
use Nikservik\SimpleSupport\Traits\SimpleSupport;
use Nikservik\Subscriptions\Traits\Subscription;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail, HasLocalePreference, RoleBased
{
    use Notifiable, Subscription, JwtAuth, SimpleSupport;

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'settings' => 'array',
    ];
    
    protected $appends = ['locale'];
    
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
    
    public function preferredLocale()
    {
        return $this->locale;
    }
}
