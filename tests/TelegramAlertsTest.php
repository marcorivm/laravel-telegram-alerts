<?php

use Illuminate\Support\Facades\Bus;
use Marcorivm\TelegramAlerts\Exceptions\JobClassDoesNotExist;
use Marcorivm\TelegramAlerts\Exceptions\WebhookUrlNotValid;
use Marcorivm\TelegramAlerts\Facades\TelegramAlert;
use Marcorivm\TelegramAlerts\Jobs\SendToTelegramChatJob;

beforeEach(function () {
    Bus::fake();
});

it('can dispatch a job to send a message to telegram using the default webhook url', function () {
    config()->set('telegram-alerts.webhook_urls.default', 'https://test-domain.com');

    TelegramAlert::message('test-data');

    Bus::assertDispatched(SendToTelegramChatJob::class);
});

it('can dispatch a job to send a set of blocks to telegram using the default webhook url', function () {
    config()->set('telegram-alerts.webhook_urls.default', 'https://test-domain.com');

    TelegramAlert::blocks([
        [
            "type" => "section",
            "text" => [
                "type" => "mrkdwn",
                "text" => "Hello!",
            ],
        ],
    ]);

    Bus::assertDispatched(SendToTelegramChatJob::class);
});

it('can dispatch a job to send a message to telegram using an alternative webhook url', function () {
    config()->set('telegram-alerts.webhook_urls.marketing', 'https://test-domain.com');

    TelegramAlert::to('marketing')->message('test-data');

    Bus::assertDispatched(SendToTelegramChatJob::class);
});

it('can dispatch a job to send a message to telegram alternative chat', function () {
    config()->set('telegram-alerts.webhook_urls.default', 'https://test-domain.com');

    TelegramAlert::toChat('random')->message('test-data');

    Bus::assertDispatched(SendToTelegramChatJob::class);
});

it('will throw an exception for a non existing job class', function () {
    config()->set('telegram-alerts.webhook_urls.default', 'https://test-domain.com');
    config()->set('telegram-alerts.job', 'non-existing-job');

    TelegramAlert::message('test-data');
})->throws(JobClassDoesNotExist::class);

it('will not throw an exception for an empty webhook url', function () {
    config()->set('telegram-alerts.webhook_urls.default', '');

    TelegramAlert::message('test-data');
})->expectNotToPerformAssertions();

it('will throw an exception for an invalid webhook url', function () {
    config()->set('telegram-alerts.webhook_urls.default', 'not-an-url');

    TelegramAlert::message('test-data');
})->throws(WebhookUrlNotValid::class);

it('will throw an exception for an invalid job class', function () {
    config()->set('telegram-alerts.webhook_urls.default', 'https://test-domain.com');
    config()->set('telegram-alerts.job', '');

    TelegramAlert::message('test-data');
})->throws(JobClassDoesNotExist::class);

it('will throw an exception for a missing job class', function () {
    config()->set('telegram-alerts.webhook_urls.default', 'https://test-domain.com');
    config()->set('telegram-alerts.job', null);

    TelegramAlert::message('test-data');
})->throws(JobClassDoesNotExist::class);
