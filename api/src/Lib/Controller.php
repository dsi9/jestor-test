<?php

namespace App\Lib;

abstract class Controller
{
    /** @var Request */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    final public function request(): Request
    {
        return $this->request;
    }
}
