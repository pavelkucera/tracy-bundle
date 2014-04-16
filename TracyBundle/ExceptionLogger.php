<?php

/**
 * Copyright (c) Pavel Kučera (http://github.com/pavelkucera), Shipito (www.shipito.com)
 */

namespace Kucera\TracyBundle;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tracy\Debugger;


/**
 * @author Pavel Kučera
 * @author Shipito (www.shipito.com)
 */
class ExceptionLogger
{
    /** @var array */
    private $emails;

    /** @var string */
    private $logDir;


    public function __construct(array $emails, $logDir)
    {
        $this->emails = $emails;
        $this->logDir = $logDir;
    }


    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if ($exception instanceof HttpException) {
            return;
        }

        Debugger::$email = $this->emails;
        Debugger::$logDirectory = $this->logDir;
        Debugger::log($exception, Debugger::CRITICAL);
    }
}
