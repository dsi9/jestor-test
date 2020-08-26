<?php

namespace App\Lib\Routes;

class Router
{
    /** @var string */
    private $method;

    /** @var string */
    private $uri;

    /** @var string */
    private $classNameMethod;

    /** @var string[] */
    private $middlewares;

    public function __construct(string $method, string $uri, string $classNameMethod, array $middlewares = [])
    {
        $this->method          = $method;
        $this->uri             = $uri;
        $this->classNameMethod = $classNameMethod;
        $this->middlewares     = $middlewares;
    }

    public function key(): string
    {
        return $this->method . '_' . $this->uri;
    }

    private function matchMethod(string $method): bool
    {
        return strtolower($this->method) === strtolower($method);
    }

    private function matchUri(string $requestUri, array $attributes): bool
    {
        $uri = $this->uri;
        foreach ($attributes as $key => $value) {
            $uri = str_replace(":$key", $value, $uri);
        }

        return $uri === $requestUri;
    }

    public function match(string $method, string $uri, array $attributes): bool
    {
        return $this->matchMethod($method) && $this->matchUri($uri, $attributes);
    }

    public function getClassNameMethod(): string
    {
        return $this->classNameMethod;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
