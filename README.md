# logger

A simple [PSR-3 compliant](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md) logging class for PHP.

```php
use Unit6\Log\Logger;

$path = __DIR__ . '/logs';
$logger = new Logger($path);
$logger->info('Test info message.');
$logger->debug('Test debug message.');
```

### Available Levels

``` php
use Psr\Log\LogLevel;

// These are in order of highest to lowest priority.
LogLevel::EMERGENCY;
LogLevel::ALERT;
LogLevel::CRITICAL;
LogLevel::ERROR;
LogLevel::WARNING;
LogLevel::NOTICE;
LogLevel::INFO;
LogLevel::DEBUG;
```