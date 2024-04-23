<?php

namespace Marcorivm\TelegramAlerts\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static self to(string $text)
 * @method static self toChat(string $text)
 * @method static void message(string $text)
 *
 * @see \Marcorivm\TelegramAlerts\TelegramAlert
 */
class TelegramAlert extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-telegram-alerts';
    }
}
