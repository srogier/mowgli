<?php

namespace sro\Mowgli\Logger;

interface LoggerInterface
{

    /**
     * @param string $message
     * @param string $level
     */
    public function log($message, $level = 'info');
}
