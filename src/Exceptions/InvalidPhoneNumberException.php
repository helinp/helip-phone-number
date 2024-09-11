<?php

declare(strict_types=1);

namespace Helip\PhoneNumber\Exceptions;

use Exception;

class InvalidPhoneNumberException extends Exception
{
    public function __construct($message = "Invalid phone number", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
