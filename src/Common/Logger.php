<?php

namespace Novosti\Common;

use Monolog\Logger as LoggerInterface;
use Monolog\Handler\StreamHandler;

class Logger {

    private $loggerHandler;

    function __construct($stream)
    {
        $this->loggerHandler = new LoggerInterface($stream);

        $log = sprintf("%s/%s.log", getenv('LOG_STORAGE'), $stream);
        $this->loggerHandler->pushHandler(new StreamHandler($log), LoggerInterface::INFO);

        return $this->loggerHandler;
    }

    function write()
    {
        return $this->loggerHandler;
    }

}
