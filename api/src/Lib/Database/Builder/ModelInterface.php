<?php

namespace App\Lib\Database\Builder;

use App\Lib\Database\Builder;

interface ModelInterface
{
    public function builder(): Builder;

    public function find(int $id): ?Builder\ModelInterface;

    public function where(string $column, string $operator, $value = null): Builder;

    public function save(): bool;

    public function delete(): bool;

    public function buildFromArray(array $data);
}
