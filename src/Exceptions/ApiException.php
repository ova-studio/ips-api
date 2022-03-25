<?php

namespace OvaStudio\IpsApi\Exceptions;

use Exception;

abstract class ApiException extends Exception
{
    public ?string $errorCode;

    public ?string $errorMessage;

    public function __construct(?string $errorCode = null, ?string $errorMessage = null)
    {
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;

        parent::__construct($errorMessage);
    }
}
