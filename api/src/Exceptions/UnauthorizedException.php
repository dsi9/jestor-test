<?php

namespace App\Exceptions;

use App\Lib\Exceptions\HttpException;
use App\Lib\Response;
use Throwable;

class UnauthorizedException extends HttpException
{
    public function __construct(
        $message = "Unauthorized",
        $code = Response::HTTP_UNAUTHORIZED,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
