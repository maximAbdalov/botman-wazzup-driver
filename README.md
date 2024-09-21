## Botman Wazzup driver

## Requirements
- PHP 7.4 or higher
- Any http client with PSR-18 support
- Botman

### Install driver
```bash
composer require foxtes/botman-wazzup-driver
```
Then you should define in the .env file the following properties:
```dotenv
WHATSAPP_PARTNER="https://api.wazzup24.com/v3"
WHATSAPP_TOKEN=your_token
WHATSAPP_CHANEL_ID=your_chanel_id
```
If you don't use BotMan Studio, the driver should be applied manually:
```php
// ...

// Applying driver
DriverManager::loadDriver(\BotMan\Drivers\WazzupDriver\WhatsAppDriver::class);

// ...
```
## Quick guide with examples
*In usage examples, the used file is `routes/botman.php`.*
```php
$botman->hears('Hello', function ($bot) {
    $bot->reply('Hi, '.$bot->getUser()->getFirstName());
});
```

## See also
- [Wazzup documentation for developers](https://wazzup24.ru/help/api-ru/)
- [BotMan documentation](https://botman.io/2.0/welcome)

## License
Wazzup driver is made under the terms of MIT license. BotMan is free software distributed under the terms of the MIT license.
