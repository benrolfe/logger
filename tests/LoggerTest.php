<?php
/*
 * This file is part of the logger package.
 *
 * (c) Unit6 <team@unit6websites.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Unit6\Log\Logger;
use Psr\Log\LogLevel;

class LoggerTest extends \PHPUnit_Framework_TestCase
{
    private $logPath;
    private $logger;
    private $errLogger;

    public function setUp()
    {
        $this->logPath = __DIR__ . '/logs';

        $this->logger = new Logger($this->logPath, LogLevel::DEBUG, [
            'flushFrequency' => 1
        ]);

        $this->errLogger = new Logger($this->logPath, LogLevel::ERROR, [
            'extension' => 'log',
            'prefix' => 'error_',
            'flushFrequency' => 1
        ]);
    }

    public function testImplementsPsr3LoggerInterface()
    {
        $this->assertInstanceOf('Psr\Log\LoggerInterface', $this->logger);
    }

    public function testAcceptsExtension()
    {
        $this->assertStringEndsWith('.log', $this->errLogger->getLogFilePath());
    }

    public function testAcceptsPrefix()
    {
        $filename = basename($this->errLogger->getLogFilePath());
        $this->assertStringStartsWith('error_', $filename);
    }

    public function testWritesBasicLogs()
    {
        $msg = 'This is a test ';

        $this->logger->log(LogLevel::DEBUG, $msg . LogLevel::DEBUG);
        $this->logger->log(LogLevel::WARNING, $msg . LogLevel::WARNING);

        $this->errLogger->log(LogLevel::ERROR, $msg . LogLevel::ERROR);
        $this->errLogger->log(LogLevel::EMERGENCY, $msg . LogLevel::EMERGENCY);

        $this->assertTrue(file_exists($this->errLogger->getLogFilePath()));
        $this->assertTrue(file_exists($this->logger->getLogFilePath()));

        $this->assertLastLineEquals($this->logger);
        $this->assertLastLineEquals($this->errLogger);
    }

    public function assertLastLineEquals(Logger $logr)
    {
        $this->assertEquals($logr->getLastLogLine(), $this->getLastLine($logr->getLogFilePath()));
    }

    public function assertLastLineNotEquals(Logger $logr)
    {
        $this->assertNotEquals($logr->getLastLogLine(), $this->getLastLine($logr->getLogFilePath()));
    }

    private function getLastLine($filename)
    {
        $fp = fopen($filename, 'r');
        $pos = -2; // start from second to last char
        $t = ' ';

        while ($t != "\n") {
            fseek($fp, $pos, SEEK_END);
            $t = fgetc($fp);
            $pos = $pos - 1;
        }

        $t = fgets($fp);
        fclose($fp);

        return trim($t);
    }

    public function tearDown() {
        #@unlink($this->logger->getLogFilePath());
        #@unlink($this->errLogger->getLogFilePath());
    }
}