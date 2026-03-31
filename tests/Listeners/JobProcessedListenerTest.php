<?php

declare(strict_types=1);

namespace JustBetter\HorizonRestarter\Tests\Listeners;

use Illuminate\Support\Facades\Redis;
use JustBetter\HorizonRestarter\Tests\Fakes\Jobs\Job;
use JustBetter\HorizonRestarter\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class JobProcessedListenerTest extends TestCase
{
    #[Test]
    public function it_can_listen_to_processed_jobs(): void
    {
        /** @var string $key */
        $key = config('horizon-restarter.key');

        Redis::command('DEL', [$key]);

        Job::dispatch();

        $count = Redis::command('GET', [$key]);

        $this->assertEquals(1, $count);

        Job::dispatch();

        $count = Redis::command('GET', [$key]);

        $this->assertEquals(2, $count);
    }

    #[Test]
    public function it_can_restart_horizon(): void
    {
        /** @var string $key */
        $key = config('horizon-restarter.key');

        config()->set('horizon-restarter.threshold', 2);

        Redis::command('DEL', [$key]);

        Job::dispatch();

        $count = Redis::command('GET', [$key]);

        $this->assertEquals(1, $count);

        Job::dispatch();

        $count = Redis::command('GET', [$key]);

        $this->assertFalse($count);
    }
}
