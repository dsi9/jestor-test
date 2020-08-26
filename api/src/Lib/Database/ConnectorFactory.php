<?php

namespace App\Lib\Database;

use App\Lib\Database\Connector\MySql;
use PDO;

class ConnectorFactory
{
    private static function config(string $adapterName): array
    {
        $config = require __DIR__ . '/../../../config/database.php';

        return $config[$adapterName];
    }

    public static function mysql(): MySql
    {
        $config = self::config('mysql');
        $dsn    = sprintf('mysql:dbname=%s;host=%s;port=%s', $config['database'], $config['host'], $config['port']);

        $pdo = new PDO($dsn, $config['username'], $config['password']);

        return new MySql($pdo);
    }
}
