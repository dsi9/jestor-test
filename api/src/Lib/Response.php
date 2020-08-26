<?php

namespace App\Lib;

use App\Lib\Response\ContentInterface;
use App\Lib\Response\Json;
use function function_exists;

class Response
{
    public const HTTP_OK                    = 200;
    public const HTTP_CREATED               = 201;
    public const HTTP_ACCEPTED              = 202;
    public const HTTP_NO_CONTENT            = 204;
    public const HTTP_BAD_REQUEST           = 400;
    public const HTTP_UNAUTHORIZED          = 401;
    public const HTTP_NOT_FOUND             = 404;
    public const HTTP_METHOD_NOT_ALLOWED    = 405;
    public const HTTP_CONFLICT              = 409;
    public const HTTP_INTERNAL_SERVER_ERROR = 500;

    public static $statusTexts = [
        self::HTTP_OK                    => 'OK',
        self::HTTP_CREATED               => 'Created',
        self::HTTP_ACCEPTED              => 'Accepted',
        self::HTTP_NO_CONTENT            => 'No Content',
        self::HTTP_BAD_REQUEST           => 'Bad Request',
        self::HTTP_UNAUTHORIZED          => 'Unauthorized',
        self::HTTP_NOT_FOUND             => 'Not Found',
        self::HTTP_METHOD_NOT_ALLOWED    => 'Method Not Allowed',
        self::HTTP_CONFLICT              => 'Conflict',
        self::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error',
    ];

    /** @var ContentInterface */
    private $content;

    /** @var int */
    private $statusCode;

    public function __construct(ContentInterface $content, int $statusCode = self::HTTP_OK)
    {
        $this->content    = $content;
        $this->statusCode = $statusCode;
    }

    public static function json(?array $data = null, int $statusCode = self::HTTP_OK): self
    {
        if ($statusCode < self::HTTP_BAD_REQUEST) {
            $data = ['data' => $data];
        }

        return new static(new Json($data), $statusCode);
    }

    public function send(): void
    {
        $statusText = self::$statusTexts[$this->statusCode];

        header('Content-Type: ' . $this->content->contentType(), true, $this->statusCode);
        header(sprintf('HTTP/%s %s %s', '1.1', $this->statusCode, $statusText), true, $this->statusCode);

        echo (string)$this->content;

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }
}
