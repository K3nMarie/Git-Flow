<?php
namespace App\Core;

use PDO;

/** Conexión PDO/SQLite (reemplaza DatabaseConnector.java, que usaba MySQL). */
class Database
{
    private static ?PDO $pdo = null;

    public static function connection(): PDO
    {
        if (self::$pdo === null) {
            $path = Application::config('db_path');
            self::$pdo = new PDO('sqlite:' . $path);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            self::$pdo->exec('PRAGMA foreign_keys = ON');
            self::migrate(self::$pdo);
        }
        return self::$pdo;
    }

    private static function migrate(PDO $pdo): void
    {
        $sql = file_get_contents(dirname(__DIR__, 2) . '/database/schema.sql');
        $pdo->exec($sql);
    }
}
