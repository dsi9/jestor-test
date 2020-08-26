<?php

namespace App\Http\Middleware;

use App\Lib\Request;

interface MiddlewareInterface
{
    public function handle(Request $request): void;
}
