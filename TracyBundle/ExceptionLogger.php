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

    /** @var bool */
    private $logAutomatically;


    public function __construct(array $emails, $logDir, $logAutomatically)
    {
        $this->emails = $emails;
        $this->logDir = $logDir;
        $this->logAutomatically = $logAutomatically;
    }


    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if (!$this->logAutomatically || $exception instanceof HttpException) {
            return;
        }

        $this->log($exception, Debugger::CRITICAL);
    }


    public function log(\Exception $e, $level = Debugger::ERROR)
    {
        Debugger::$email = $this->emails;
        Debugger::$logDirectory = $this->logDir;
        Debugger::log($e, $level);
    }
}
