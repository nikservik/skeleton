<?php

namespace App;

use App\Mail\PasswordReset;
use App\Subscriptions\Subscription;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail, HasLocalePreference
{
    use Notifiable;

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
    
    protected $appends = ['locale', 'features'];

    public const ROLE_USER = 1;
    public const ROLE_EDITOR = 2;
    public const ROLE_ADMIN = 3;
    public const ROLE_SUPERADMIN = 4;

    public static $roles = [
        self::ROLE_USER,
        self::ROLE_EDITOR,
        self::ROLE_ADMIN,
        self::ROLE_SUPERADMIN,
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function subscription()
    {
        return $this->subscriptions()->where('status', 'Active')->first();
    }
    
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

    public function getFeaturesAttribute() 
    {
        if ($this->subscription() and $this->subscription()->features)
            return $this->subscription()->features;

        return [];
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
