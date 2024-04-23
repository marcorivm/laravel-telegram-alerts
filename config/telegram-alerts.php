<?php

return [
    'bot_config' => [
        'token' => env('TELEGRAM_ALERT_BOT_TOKEN'),
    ],

    'chats' => [
        'default' => env('TELEGRAM_ALERT_DEFAULT_CHAT'),
    ],

    /*
     * This job will send the message to Telegram. You can extend this
     * job to set timeouts, retries, etc...
     */
    'job' => Marcorivm\TelegramAlerts\Jobs\SendToTelegramChatJob::class,
];
