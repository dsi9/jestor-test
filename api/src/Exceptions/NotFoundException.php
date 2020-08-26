<?php

namespace App\Exceptions;

use App\Lib\Exceptions\HttpException;
use App\Lib\Response;
use Throwable;

class NotFoundException extends HttpException
{
    public function __construct($message = "Not Found", $code = Response::HTTP_NOT_FOUND, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
