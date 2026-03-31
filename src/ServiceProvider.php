<?php

declare(strict_types=1);

namespace JustBetter\HorizonRestarter;

use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use JustBetter\HorizonRestarter\Listeners\JobProcessedListener;

class ServiceProvider extends BaseServiceProvider
{
    #[\Override]
    public function register(): void
    {
        $this->registerConfig();
    }

    protected function registerConfig(): static
    {
        $this->mergeConfigFrom(__DIR__.'/../config/horizon-restarter.php', 'horizon-restarter');

        return $this;
    }

    public function boot(): void
    {
        $this
            ->bootConfig()
            ->bootListeners();
    }

    protected function bootConfig(): static
    {
        $this->publishes([
            __DIR__.'/../config/horizon-restarter.php' => config_path('horizon-restarter.php'),
        ], 'config');

        return $this;
    }

    protected function bootListeners(): static
    {
        Event::listen(JobProcessed::class, JobProcessedListener::class);

        return $this;
    }
}
