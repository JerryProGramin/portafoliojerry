<?php

declare(strict_types=1);

namespace App\Infrastructure\Database;

use App\Support\Config;
use PDO;

final class Connection
{
    public static function create(): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            Config::string('DB_HOST', '127.0.0.1'),
            Config::string('DB_PORT', '3306'),
            Config::string('DB_DATABASE', 'portafolio_jerry')
        );

        return new PDO(
            $dsn,
            Config::string('DB_USERNAME', 'root'),
            Config::string('DB_PASSWORD'),
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }
}
