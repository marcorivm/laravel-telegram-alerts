<?php

namespace Marcorivm\TelegramAlerts\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendToTelegramChatJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 0;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     */
    public int $maxExceptions = 3;

    public function __construct(
        public string $text,
        public string $chatId,
    ) {
    }

    public function handle(): void
    {
        $payload = [
            'chat_id' => $this->chatId,
            'text' => $this->text,
        ];

        $telegram = $this->getTelegramBot();

        $response = $telegram->sendMessage(
            $payload
        );
    }

    protected function getTelegramBot(): \Telegram\Bot\Api
    {
        $config = config('telegram');
        $config['bots'] = ['telegram-alerts' => config('telegram-alerts.bot_config')];
        $botManager = new \Telegram\Bot\BotsManager($config);
        return $botManager->bot('telegram-alerts');
    }
}
