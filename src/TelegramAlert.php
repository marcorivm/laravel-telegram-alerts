<?php

namespace Marcorivm\TelegramAlerts;

class TelegramAlert
{
    protected string $webhookUrlName = 'default';
    protected ?string $chatName = null;

    public function to(string $webhookUrlName): self
    {
        $this->webhookUrlName = $webhookUrlName;

        return $this;
    }

    public function toChat(string $chatName): self
    {
        $this->chatName = $chatName;

        return $this;
    }

    public function message(string $text): void
    {
        $chatId = $this->chatName ? Config::getChatId($this->chatName) : Config::getChatId('default');

        if (!$chatId) {
            return;
        }


        $job = Config::getJob([
            'text' => $text,
            'chatId' => $chatId,
        ]);

        dispatch($job);
    }
}
