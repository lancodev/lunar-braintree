<?php

namespace Lancodev\LunarBraintree;

use Illuminate\Support\Facades\Blade;
use Lancodev\LunarBraintree\Components\PaymentForm;
use Livewire\Livewire;
use Lunar\Facades\Payments;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LunarBraintreeServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        parent::boot();

        Payments::extend('braintree', function ($app) {
            return $app->make(BraintreePaymentType::class);
        });

        Blade::directive('braintreeScripts', function () {
            return <<<'EOT'
                <script src="https://js.braintreegateway.com/web/dropin/1.34.0/js/dropin.min.js"></script>
            EOT;
        });

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'lunar-braintree');

        // Register the stripe payment component.
        Livewire::component('braintree.payment-form', PaymentForm::class);
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('lunar-braintree')
            ->hasRoutes(['web'])
            ->hasConfigFile();
    }
}
