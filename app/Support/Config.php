<?php

declare(strict_types=1);

namespace App\Support;

final class Config
{
    public static function string(string $key, string $default = ''): string
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        return is_string($value) && $value !== '' ? $value : $default;
    }

    public static function bool(string $key, bool $default = false): bool
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? null;

        return $value === null
            ? $default
            : filter_var($value, FILTER_VALIDATE_BOOL);
    }
}
