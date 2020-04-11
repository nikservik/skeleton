<?php

namespace App\Policies;

use App\Subscriptions\Feature;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class FeaturePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function feature(User $user, $feature)
    {
        // тут будет проверка, есть ли фича в подписке пользователя
        return in_array($feature, Feature::LIST);
    }
}
