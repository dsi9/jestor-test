<?php

namespace App\Lib\Database\Connector;

interface ConnectorInterface
{
    public function select(string $sql, array $bindings): array;

    public function execute(string $sql, array $bindings): int;
}
