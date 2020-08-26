<?php

namespace App\Lib\Exceptions;

use App\Lib\Response;
use JsonSerializable;
use RuntimeException;

class HttpException extends RuntimeException implements JsonSerializable
{
    public function getHttpCode(): int
    {
        return $this->getCode() === 0 ? Response::HTTP_INTERNAL_SERVER_ERROR : $this->getCode();
    }

    public function jsonSerialize(): array
    {
        return [
            'error'    => $this->getHttpCode(),
            'message' => $this->getMessage(),
            'trace'   => $this->getTraceAsString()
        ];
    }
}
