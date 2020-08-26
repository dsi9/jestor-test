<?php

namespace App\Lib\Response;

class Json implements ContentInterface
{
    public const CONTENT_TYPE = 'application/json';

    /** @var array|null */
    private $data;

    public function __construct(?array $data = null)
    {
        $this->data = $data;
    }

    public function contentType(): string
    {
        return self::CONTENT_TYPE;
    }

    public function data(): string
    {
        return json_encode($this->data);
    }

    public function __toString(): string
    {
        return $this->data();
    }
}
