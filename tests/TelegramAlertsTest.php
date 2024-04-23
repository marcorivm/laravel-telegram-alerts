<?php

use Illuminate\Support\Facades\Bus;
use Marcorivm\TelegramAlerts\Exceptions\JobClassDoesNotExist;
use Marcorivm\TelegramAlerts\Exceptions\WebhookUrlNotValid;
use Marcorivm\TelegramAlerts\Facades\TelegramAlert;
use Marcorivm\TelegramAlerts\Jobs\SendToTelegramChatJob;

beforeEach(function () {
    Bus::fake();
});

it('can dispatch a job to send a message to telegram using the default chat', function () {
    config()->set('telegram-alerts.chats.default', '-1234567890');
    config()->set('telegram-alerts.bot_config.token', 'abc:123');

    TelegramAlert::message('test-data');

    Bus::assertDispatched(SendToTelegramChatJob::class);
});


it('can dispatch a job to send a message to telegram alternative chat', function () {
    config()->set('telegram-alerts.chats.default', '-1234567890');
    config()->set('telegram-alerts.chats.random', '-1234567891');
    config()->set('telegram-alerts.bot_config.token', 'abc:123');

    TelegramAlert::toChat('random')->message('test-data');

    Bus::assertDispatched(SendToTelegramChatJob::class);
});

it('will throw an exception for a non existing job class', function () {
    config()->set('telegram-alerts.chats.default', '-1234567890');
    config()->set('telegram-alerts.bot_config.token', 'abc:123');
    config()->set('telegram-alerts.job', 'non-existing-job');

    TelegramAlert::message('test-data');
})->throws(JobClassDoesNotExist::class);

it('will not throw an exception for an empty bot token', function () {
    config()->set('telegram-alerts.bot_config.token', '');
    config()->set('telegram-alerts.chats.default', '-1234567890');

    TelegramAlert::message('test-data');
})->expectNotToPerformAssertions();

it('will not throw an exception for an empty default chat', function () {
    config()->set('telegram-alerts.bot_config.token', 'abc:123');
    config()->set('telegram-alerts.chats.default', '');

    TelegramAlert::message('test-data');
})->expectNotToPerformAssertions();

it('will throw an exception for an invalid job class', function () {
    config()->set('telegram-alerts.chats.default', '-1234567890');
    config()->set('telegram-alerts.bot_config.token', 'abc:123');
    config()->set('telegram-alerts.job', '');

    TelegramAlert::message('test-data');
})->throws(JobClassDoesNotExist::class);

it('will throw an exception for a missing job class', function () {
    config()->set('telegram-alerts.chats.default', '-1234567890');
    config()->set('telegram-alerts.bot_config.token', 'abc:123');
    config()->set('telegram-alerts.job', null);

    TelegramAlert::message('test-data');
})->throws(JobClassDoesNotExist::class);
