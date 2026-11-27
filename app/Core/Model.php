<?php
namespace App\Core;

use PDO;

abstract class Model
{
    protected static function db(): PDO
    {
        return Database::connection();
    }

    protected static function all(string $sql, array $params = []): array
    {
        $st = self::db()->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    }

    protected static function one(string $sql, array $params = []): ?array
    {
        $st = self::db()->prepare($sql);
        $st->execute($params);
        $row = $st->fetch();
        return $row === false ? null : $row;
    }

    protected static function run(string $sql, array $params = []): int
    {
        $st = self::db()->prepare($sql);
        $st->execute($params);
        return $st->rowCount();
    }
}
