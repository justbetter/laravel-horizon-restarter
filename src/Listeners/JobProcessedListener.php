<?php

namespace JustBetter\HorizonRestarter\Listeners;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redis;

class JobProcessedListener
{
    public function handle(): void
    {
        /** @var string $key */
        $key = config('horizon-restarter.key');

        /** @var int $incr */
        $incr = Redis::command('INCR', [$key]);

        /** @var int $threshold */
        $threshold = config('horizon-restarter.threshold');

        if ($incr >= $threshold) {
            Redis::command('DEL', [$key]);

            Artisan::call('horizon:terminate');
        }
    }
}
