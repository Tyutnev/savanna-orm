<?php

namespace Tyutnev\SavannaOrm\Exception;

use Exception;
use Throwable;

class ConnectionException extends Exception
{
    public function __construct(string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}