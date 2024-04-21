<?php

return [
    /*
     * The webhook URLs that we'll use to send a message to Telegram.
     */
    'webhook_urls' => [
        'default' => env('TELEGRAM_ALERT_WEBHOOK'),
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
