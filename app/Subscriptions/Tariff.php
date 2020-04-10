<?php

namespace App\Subscriptions;

use Illuminate\Database\Eloquent\Model;

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
    
}
