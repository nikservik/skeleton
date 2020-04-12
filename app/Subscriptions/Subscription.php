<?php

namespace App\Subscriptions;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'short_name', 'name', 'price', 'currency', 'period', 'prolongable'
    ];

    protected $casts = [
        'features' => 'array',
        'availability' => 'array',
        'texts' => 'array',
        'last_transaction_date' => 'date',
        'next_transaction_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isEndless()
    {
        return $this->period == 'endless';
    }

    public function isPaid()
    {
        return $this->price > 0;
    }

    public function isTrial()
    {
        return !$this->isEndless() and !$this->prolongable;
    }
}
