<?php

namespace Lancodev\LunarBraintree;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Lancodev\LunarBraintree\Commands\LunarBraintreeCommand;

class LunarBraintreeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('lunar-braintree')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_lunar-braintree_table')
            ->hasCommand(LunarBraintreeCommand::class);
    }
}
