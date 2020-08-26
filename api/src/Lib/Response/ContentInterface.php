<?php

namespace App\Lib\Response;

interface ContentInterface
{
    public function contentType(): string;

    public function data(): string;
}
