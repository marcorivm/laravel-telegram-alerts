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

    public static function getChatId(string $name): string|null
    {
        return config("telegram-alerts.chats.{$name}", null);
    }
}
