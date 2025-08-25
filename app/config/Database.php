<?php

namespace Nabil\MVC\config;

class Database
{
    private static ?\PDO $pdo = null;

    // dalam bentuk static, agar bisa dipanggil-panggil
    public static function getConnection(string $env = "test"): \PDO
    {
        if (self::$pdo == null) {
            // create new PDO
            require_once __DIR__ . '/../../config/database.php';
            $config = getDatabaseConfig();
            self::$pdo = new \PDO(
                $config['database'][$env]['url'],
                $config['database'][$env]['username'],
                $config['database'][$env]['password']
            );
        }

        return self::$pdo;
    }

    public static function beginTransaction()
    {
        self::$pdo->beginTransaction();
    }

    public static function commitTransaction()
    {
        self::$pdo->commit();
    }

    public static function rollbackTransaction()
    {
        self::$pdo->rollBack();
    }
}
