<?php

namespace App\Lib\Request;

class Attributes
{
    /** @var string|null */
    private $api;

    /** @var string|null */
    private $controller;

    /** @var string|null */
    private $id;

    public function __construct(string $uri)
    {
        $this->createAttributes($uri);
    }

    private function createAttributes(string $uri): void
    {
        $paths = explode('/', $uri);
        $paths = array_filter($paths);
        $paths = array_values($paths);

        $this->api        = $paths[0] ?? null;
        $this->controller = $paths[1] ?? null;
        $this->id         = $paths[2] ?? null;
    }

    public function getApi(): ?string
    {
        return $this->api;
    }

    public function getController(): ?string
    {
        return $this->controller;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function uri(): string
    {
        return '/' . $this->getApi() . '/' . $this->getController() . ($this->getId() ? '/' . $this->getId() : '');
    }
}
