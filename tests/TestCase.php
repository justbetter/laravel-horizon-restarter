<?php

namespace JustBetter\HorizonRestarter\Tests;

use JustBetter\HorizonRestarter\ServiceProvider;
use Laravel\Horizon\HorizonServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
            HorizonServiceProvider::class,
        ];
    }
}
