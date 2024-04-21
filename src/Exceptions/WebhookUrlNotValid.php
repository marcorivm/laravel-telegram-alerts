<?php

namespace Marcorivm\TelegramAlerts\Exceptions;

use RuntimeException;

class WebhookUrlNotValid extends RuntimeException
{
    public static function make(string $name, string $url): self
    {
        return new self("The name `{$name}` webhook contains an invalid url `{$url}`. Make sure you specify a valid URL in the `webhook_urls.{$name}` key of the telegram-alerts.php config file.");
    }
}
