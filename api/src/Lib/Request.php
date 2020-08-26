<?php

namespace App\Lib;

class Request
{
    /** @var Collection */
    public $query;

    /** @var Collection */
    public $request;

    /** @var Request\Attributes */
    public $attributes;

    /** @var Collection */
    public $server;

    public function __construct(
        array $query = [],
        array $request = [],
        Request\Attributes $attributes = null,
        array $server = []
    )
    {
        $this->query      = new Collection($query);
        $this->attributes = $attributes;
        $this->server     = new Collection($server);
        $this->createRequest($request);
    }

    public function createRequest(array $request): void
    {
        $inputJSON = file_get_contents('php://input');

        $json = [];

        if ($inputJSON !== null) {
            $json = json_decode($inputJSON, true);
        }

        if (!empty($json) && is_array($json)) {
            $request = $json;
        }

        $this->request = new Collection($request);
    }

    public function method(): string
    {
        return strtolower($this->server->get('REQUEST_METHOD'));
    }
}
