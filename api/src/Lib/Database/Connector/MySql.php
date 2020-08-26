<?php

namespace App\Lib\Database\Connector;

use App\Lib\Exceptions\DatabaseException;
use PDO;

class MySql implements ConnectorInterface
{
    /** @var PDO */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function select(string $sql, array $bindings): array
    {
        $statement = $this->pdo->prepare($sql);

        foreach ($bindings as $key => $value) {
            $statement->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        if ($statement->execute() == false) {
            throw new DatabaseException(implode(' - ', $statement->errorInfo()));
        }

        return $statement->fetchAll();
    }

    public function execute(string $sql, array $bindings): int
    {
        $statement = $this->pdo->prepare($sql);

        if ($statement->execute($bindings) === false) {
            throw new DatabaseException(implode(' - ', $statement->errorInfo()));
        }

        return $this->pdo->lastInsertId();
    }
}
