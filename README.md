# Quickly send a message to Telegram

This package can quickly send alerts to Telegram. You can use this to notify yourself of any noteworthy events happening in your app. This is based on the similar package by Spatie, ![Slack Alerts](https://github.com/spatie/laravel-slack-alerts)

```php
use Marcorivm\TelegramAlerts\Facades\TelegramAlert;

TelegramAlert::message("You have a new subscriber to the {$newsletter->name} newsletter!");
```

Under the hood, a job is used to communicate with Telegram. This prevents your app from failing in case Telegram is down.

## Installation

You can install the package via composer:

```bash
composer require marcorivm/laravel-telegram-alerts
```

You can set a `TELEGRAM_ALERT_WEBHOOK` env variable containing a Make.org url to connect to your Telegram bot. This will be later upgraded to connect directly to Telegram


Alternatively, you can publish the config file with:

```bash
php artisan vendor:publish --tag="telegram-alerts-config"
```

This is the contents of the published config file:

```php
return [
    /*
     * The webhook URLs that we'll use to send a message to Telegram.
     */
    'webhook_urls' => [
        'default' => env('TELEGRAM_ALERT_WEBHOOK'),
    ],

    /*
     * This job will send the message to Telegram. You can extend this
     * job to set timeouts, retries, etc...
     */
    'job' => Marcorivm\TelegramAlerts\Jobs\SendToTelegramChatJob::class,
];

```

## Usage

To send a message to Telegram, simply call `TelegramAlert::message()` and pass it any message you want.

```php
TelegramAlert::message("You have a new subscriber to the {$newsletter->name} newsletter!");
```


The webhook to be used can be chosen using the `to` function.

```php
use Marcorivm\TelegramAlerts\Facades\TelegramAlert;

TelegramAlert::to('marketing')->message("You have a new subscriber to the {$newsletter->name} newsletter!");
```

### Using a custom webhooks

The `to` function also supports custom webhook urls.

```php
use Marcorivm\TelegramAlerts\Facades\TelegramAlert;

TelegramAlert::to('https://custom-url.com')->message("You have a new subscriber to the {$newsletter->name} newsletter!");
```

### Sending message to an alternative chat

You can send a message to a chat other than the default one for the webhook, by passing it to the `toChat` function.

```php
use Marcorivm\TelegramAlerts\Facades\TelegramAlert;

TelegramAlert::toChat('subscription_alerts')->message("You have a new subscriber to the {$newsletter->name} newsletter!");
```

## Formatting

### Markdown
You can format your messages with Telegram's markup.

```php
use Marcorivm\TelegramAlerts\Facades\TelegramAlert;

TelegramAlert::message("A message *with some bold statements* and _some italicized text_.");
```

Links are formatted differently in Telegram than the classic markdown structure.

```php
TelegramAlert::message("<https://spatie.be|This is a link to our homepage>");
```

### Mentioning

You can use mentions to notify users and groups.
```php
use Marcorivm\TelegramAlerts\Facades\TelegramAlert;

TelegramAlert::message("A message that notifies <@username> and everyone else who is <!here>")

```

### Usage in tests

In your tests, you can make use of the `TelegramAlert` facade to assert whether your code sent an alert to Telegram.

```php
// in a test

use Marcorivm\TelegramAlerts\Facades\TelegramAlert;

it('will send an alert to Telegram', function() {

    TelegramAlert::shouldReceive('message')->once();

    // execute code here that does send a message to Telegram
});
```

Of course, you can also assert that a message wasn't sent to Telegram.

```php
// in a test

use Marcorivm\TelegramAlerts\Facades\TelegramAlert;

it('will not send an alert to Telegram', function() {
    TelegramAlert::shouldReceive('message')->never();

    // execute code here that doesn't send a message to Telegram
});
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please open a new PR.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Niels Vanpachtenbeke](https://github.com/Nielsvanpach)
- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Alternatives
