<?php

declare(strict_types=1);

namespace App\Utils\Auth;

use Exception;
use Throwable;

class AuthException extends Exception
{
    public function __construct($message = '', $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return self::class . ": [{$this->code}]: {$this->message}\n";
    }
}
