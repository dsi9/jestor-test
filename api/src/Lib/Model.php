<?php

namespace App\Lib;

use App\Lib\Database\Builder;
use JsonSerializable;

abstract class Model implements JsonSerializable
{
    private const EXCLUDE_PARAMS = ['table', 'id'];

    /** @var string */
    protected $table;

    /** @var int|null */
    protected $id;

    public function builder(): Builder
    {
        $builder = new Builder(get_class($this));

        $builder->table($this->table);

        return $builder;
    }

    public function find(int $id): ?Model
    {
        return $this->where('id', '=', $id)
                    ->first();
    }

    public function where(string $column, string $operator, $value = null): Builder
    {
        $builder = $this->builder();

        $builder->where($column, $operator, $value);

        return $builder;
    }

    public function saveOrCreate(): void
    {
        $data = $this->jsonSerialize();

        if ($this->id === null) {
            $this->id = $this->builder()
                             ->create($data);
            return;
        }

        $data = array_filter($data, function ($key) {
            return !in_array($key, self::EXCLUDE_PARAMS);
        }, ARRAY_FILTER_USE_KEY);

        $this->builder()
             ->where('id', '=', $this->id)
             ->save($data);
    }

    public function delete()
    {
        $this->builder()
            ->where('id', '=', $this->id)
             ->delete();
    }

    abstract public function jsonSerialize(): array;

    abstract public function buildFromArray(array $data): Model;
}
