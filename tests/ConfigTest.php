<?php

use Marcorivm\TelegramAlerts\Config;

beforeEach(function () {
    config()->set('telegram-alerts.webhook_urls.default', 'https://default-domain.com');
});
