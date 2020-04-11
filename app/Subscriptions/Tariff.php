<?php

namespace App\Subscriptions;

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

    public static $periods = ['15 days', '1 month', '1 year', 'endless'];

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
