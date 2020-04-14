<?php

namespace Nikservik\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Tariff extends Model
{
    protected $fillable = [
        'short_name', 'name', 'price', 'currency', 'period', 'prolongable'
    ];

    protected $casts = [
        'features' => 'array',
        'availability' => 'array',
        'texts' => 'array',
    ];

    public function getNameTranslation($locale)
    {
        if ($locale == config('app.locale'))
            return $this->name;
        else
            return Arr::get($this->texts, 'name.'.$locale, $this->name);
    }

    public function setNameTranslation($name, $locale)
    {
        $texts = $this->texts;
        if ($locale == config('app.locale')) {
            $texts['name']['locale'] = $locale;
        } else {
            $texts['name'][$locale] = $name;
        }
        $this->texts = $texts;
        return $name;
    }

    public function getPeriodLocaleAttribute() 
    {
        return 'period'.str_replace(' ', '', $this->period);
    }   

    public function getDefaultAttribute() 
    {
        return Arr::get($this->availability, 'default', false);
    }   

    public function setDefaultAttribute($default) 
    {
        $availability = $this->availability;
        $availability['default'] = (boolean) $default;
        $this->availability = $availability;
    }   
    
    public function getVisibleAttribute() 
    {
        return Arr::get($this->availability, 'visible', false);
    }   

    public function setVisibleAttribute($visible) 
    {
        $availability = $this->availability;
        $availability['visible'] = (boolean) $visible;
        $this->availability = $availability;
    }   
}
