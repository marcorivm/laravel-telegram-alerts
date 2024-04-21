<?php

namespace Marcorivm\TelegramAlerts\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Marcorivm\TelegramAlerts\TelegramAlertsServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            TelegramAlertsServiceProvider::class,
        ];
    }
}
