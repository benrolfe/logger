# logger

A simple PSR-3 compliant logging class for PHP.

```php
use Unit6\Log\Logger;
$path = __DIR__ . '/logs'
$logger = new Logger($path);
$logger->info('Test info message.');
$logger->debug('Test debug message.');
```

### Available Levels

``` php
<?php
use Psr\Log\LogLevel;

// These are in order of highest priority to lowest.
LogLevel::EMERGENCY;
LogLevel::ALERT;
LogLevel::CRITICAL;
LogLevel::ERROR;
LogLevel::WARNING;
LogLevel::NOTICE;
LogLevel::INFO;
LogLevel::DEBUG;
```