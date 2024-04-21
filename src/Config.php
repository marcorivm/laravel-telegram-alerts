<?php

namespace Marcorivm\TelegramAlerts;

use Marcorivm\TelegramAlerts\Exceptions\JobClassDoesNotExist;
use Marcorivm\TelegramAlerts\Exceptions\WebhookUrlNotValid;
use Marcorivm\TelegramAlerts\Jobs\SendToTelegramChatJob;

class Config
{
    public static function getJob(array $arguments): SendToTelegramChatJob
    {
        $jobClass = config('telegram-alerts.job');

        if (is_null($jobClass) || !class_exists($jobClass)) {
            throw JobClassDoesNotExist::make($jobClass);
        }

        return app($jobClass, $arguments);
    }

    public static function getWebhookUrl(string $name): string|null
    {
        if (filter_var($name, FILTER_VALIDATE_URL)) {
            return $name;
        }

        $url = config("telegram-alerts.webhook_urls.{$name}");

        if (!$url) {
            return null;
        }

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw WebhookUrlNotValid::make($name, $url);
        }

        return $url;
    }

    public static function getChatId(string $name): string|null
    {
        return config("telegram-alerts.chats.{$name}", null);
    }
}
