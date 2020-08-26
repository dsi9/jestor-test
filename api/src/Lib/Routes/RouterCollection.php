<?php

namespace App\Lib\Routes;

use App\Lib\Collection;
use App\Lib\Request;

class RouterCollection extends Collection
{
    public function add(Router $router): self
    {
        $this->set($router->key(), $router);

        return $this;
    }


    public function findByRequest(Request $request): ?Router
    {
        return $this->where(function (Router $router) use ($request) {
            return $router->match(
                $request->method(),
                $request->attributes->uri(),
                ['id' => $request->attributes->getId()]
            );
        })->first();
    }
}
