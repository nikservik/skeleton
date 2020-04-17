<?php

namespace Nikservik\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Nikservik\Subscriptions\TranslatableField;

class Tariff extends Model
{
    protected $fillable = [
        'slug', 'name', 'price', 'currency', 'period', 'prolongable'
    ];

    protected $casts = [
        'features' => 'array',
        'availability' => 'array',
        'texts' => 'array',
        'name' => TranslatableField::class,
    ];

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