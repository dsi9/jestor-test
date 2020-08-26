<?php

namespace App\Lib\Database;

use App\Lib\Database\Builder\OrderBy;
use App\Lib\Database\Builder\Where;
use App\Lib\Database\Connector\ConnectorInterface;
use App\Lib\Model;

class Builder
{
    /** @var string */
    private $modelName;

    /** @var Where[] */
    private $wheres = [];

    /** @var OrderBy[] */
    private $orders = [];

    /** @var string */
    private $table;

    /** @var int */
    private $limit;

    /** @var ConnectorInterface */
    private $connector;

    public function __construct(string $modelName)
    {
        $this->modelName = $modelName;

        $this->connector = ConnectorFactory::mysql();
    }

    public function table(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param string $column
     * @param string $operator
     * @param null|string|int $value
     * @return $this
     */
    public function where(string $column, string $operator, $value = null): self
    {
        $this->wheres[] = new Where($column, $operator, $value);

        return $this;
    }

    public function orderBy($column, $direction = 'asc'): self
    {
        $this->orders[] = new OrderBy($column, $direction);

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return Model[]
     */
    private function resultsToModel(array $results): array
    {
        return array_map(function ($row) {
            $model = new $this->modelName;

            assert($model instanceof Model);

            $model->buildFromArray($row);

            return $model;
        }, $results);
    }

    public function first(): ?Model
    {
        $results = $this->limit(1)->get();

        if (!empty($results)) {
            return reset($results);
        }

        return null;
    }

    private function addWhere(string &$query): array
    {
        $bindings = [];

        $where     = '';
        $whereType = 'WHERE';
        foreach ($this->wheres as $obj) {
            $where .= sprintf('%s %s %s :%s', $whereType, $obj->getColumn(), $obj->getOperator(), $obj->getColumn());

            $bindings[':' . $obj->getColumn()] = $obj->getValue();
            $whereType                         = ' AND';
        }

        $query = sprintf('%s %s', $query, $where);

        return $bindings;
    }

    private function addLimit(string &$query): void
    {
        if ($this->limit !== null) {
            $query = sprintf('%s LIMIT %d', $query, $this->limit);
        }
    }

    private function addOrderBy(string &$query): void
    {
        $order     = '';
        $orderType = 'ORDER BY';
        foreach ($this->orders as $orderBy) {
            $order .= sprintf('%s %s %s', $orderType, $orderBy->getColumn(), $orderBy->getDirection());

            $orderType = ',';
        }

        $query = sprintf('%s %s', $query, $order);
    }

    /**
     * @return Model[]
     */
    public function get(): array
    {
        $query = sprintf('SELECT * FROM %s', $this->table);

        $bindings = $this->addWhere($query);

        $this->addLimit($query);
        $this->addOrderBy($query);

        $results = $this->connector->select($query, $bindings);

        return $this->resultsToModel($results);
    }

    public function create(array $bindings): int
    {
        $params = implode(', ', array_keys($bindings));
        $values = ':' . implode(', :', array_keys($bindings));
        $sql    = sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->table, $params, $values);

        return $this->connector->execute($sql, $bindings);
    }

    public function save(array $bindings): int
    {
        $params = implode(', ', array_map(function ($key) {
            return "$key=:$key";
        }, array_keys($bindings)));

        $sql = sprintf('UPDATE %s SET %s', $this->table, $params);

        $bindings = array_merge($this->addWhere($sql), $bindings);

        return $this->connector->execute($sql, $bindings);
    }

    public function delete(): void
    {
        $sql = sprintf('DELETE FROM %s', $this->table);

        $bindings = array_merge($this->addWhere($sql));

        $this->connector->execute($sql, $bindings);
    }
}
