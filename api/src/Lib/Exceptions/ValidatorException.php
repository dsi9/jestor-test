<?php

namespace App\Lib\Exceptions;

use App\Lib\Response;
use Throwable;

class ValidatorException extends HttpException
{
    public function __construct(array $errors, $code = Response::HTTP_CONFLICT, Throwable $previous = null)
    {
        $message = sprintf("Error validation: %s", implode(', ', $errors));

        parent::__construct($message, $code, $previous);
    }
}
