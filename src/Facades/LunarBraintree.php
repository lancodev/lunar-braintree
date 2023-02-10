<?php

namespace Lancodev\LunarBraintree\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Lancodev\LunarBraintree\LunarBraintree
 */
class LunarBraintree extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Lancodev\LunarBraintree\LunarBraintree::class;
    }
}
