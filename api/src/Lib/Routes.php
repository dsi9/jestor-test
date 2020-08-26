<?php

namespace App\Lib;

use App\Lib\Routes\Router;
use App\Lib\Routes\RouterCollection;

/**
 * @method Routes get(string $uri, $classNameMethod, array $middlewares = []);
 * @method Routes post(string $uri, $classNameMethod, array $middlewares = []);
 * @method Routes put(string $uri, $classNameMethod, array $middlewares = []);
 * @method Routes delete(string $uri, $classNameMethod, array $middlewares = []);
 */
class Routes
{
    /** @var RouterCollection */
    public $collection;

    public function __construct()
    {
        $this->collection = new RouterCollection();
    }

    public function __call($name, $arguments)
    {
        $method          = $name;
        $uri             = $arguments[0];
        $classNameMethod = $arguments[1];
        $middleware      = $arguments[2] ?? [];

        $this->collection->add(new Router($method, $uri, $classNameMethod, $middleware));
    }
}
