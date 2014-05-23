<?php

namespace Kucera\TracyBundle;;

use Monolog\Handler\AbstractProcessingHandler;
use Tracy\Debugger;


class MonologHandler extends AbstractProcessingHandler
{
    /** @var int */
    private $minLevel;


    /**
     * @param int $minLevel
     */
    public function __construct($minLevel)
    {
        $this->minLevel = $minLevel;
    }


    protected function write(array $record)
    {
        if ($record['level'] < $this->minLevel) {
            return;
        }

        $level = $record['level_name'];
        $message = $record['message'];
        if (isset($record['context']['exception'])) {
            $message = $record['context']['exception'];
        }

        $this->log($message, $level);
    }


    /**
     * @param \Exception|string $message
     * @param string $level
     */
    public function log($message, $level)
    {
        Debugger::log($message, $level);
    }
}
