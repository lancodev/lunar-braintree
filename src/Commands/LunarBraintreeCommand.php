<?php

namespace Lancodev\LunarBraintree\Commands;

use Illuminate\Console\Command;

class LunarBraintreeCommand extends Command
{
    public $signature = 'lunar-braintree';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
