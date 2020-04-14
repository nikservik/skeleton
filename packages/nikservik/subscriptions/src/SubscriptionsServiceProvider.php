<?php

namespace Nikservik\Subscriptions;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Nikservik\Subscriptions\Models\Feature;
use Nikservik\Subscriptions\Models\Tariff;
use Nikservik\Subscriptions\PaymentsManager;
use Nikservik\Subscriptions\Policies\FeaturePolicy;
use Nikservik\Subscriptions\Policies\TariffPolicy;
use Nikservik\Subscriptions\SubscriptionsManager;

class SubscriptionsServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Tariff::class => TariffPolicy::class,
        Feature::class => FeaturePolicy::class,
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('subscriptions',function() {
            return new SubscriptionsManager;
        });
        $this->app->bind('payments',function() {
            return new PaymentsManager;
        });
        $this->mergeConfigFrom(__DIR__.'/../config/subscriptions.php', 'subscriptions');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/subscriptions.php' => config_path('subscriptions.php'),
        ], 'config');
        $this->loadFactoriesFrom(__DIR__.'/../factories');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'subscriptions');
        $this->loadViewsFrom(__DIR__.'/../views', 'subscriptions');
        $this->registerPolicies();
    }
}
