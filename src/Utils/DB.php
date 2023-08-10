<?php

declare(strict_types=1);

namespace App\Utils;

use App\Config\DatabaseConfig;
use Exception;
use PDO;

class DB
{
    private static array $instances = [];

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup(): void
    {
        throw new \Exception('Cannot unserialize a singleton.');
    }
    public static function getInstance()
    {
        $cls = static::class;
        if (! isset(self::$instances[$cls])) {
            try {
                self::$instances[$cls] = new PDO('mysql:host=' . DatabaseConfig::SERVER_NAME . ';dbname=' . DatabaseConfig::DB_NAME, DatabaseConfig::USER_NAME, DatabaseConfig::PASSWORD);
            } catch (Exception $e) {
            }
        }

        return self::$instances[$cls];
    }
}
