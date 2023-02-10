<?php

namespace Lancodev\LunarBraintree;

use Lancodev\LunarBraintree\Commands\LunarBraintreeCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
