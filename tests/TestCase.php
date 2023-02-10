<?php

namespace Lancodev\LunarBraintree\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lancodev\LunarBraintree\LunarBraintreeServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Lancodev\\LunarBraintree\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LunarBraintreeServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_lunar-braintree_table.php.stub';
        $migration->up();
        */
    }
}
