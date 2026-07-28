<?php

declare(strict_types=1);

use App\Support\Config;

function base_path(string $path = ''): string
{
    return dirname(__DIR__, 2) . ($path !== '' ? DIRECTORY_SEPARATOR . ltrim($path, '/\\') : '');
}

function url(string $path = ''): string
{
    $base = rtrim(Config::string('APP_BASE_PATH'), '/');

    return $base . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    $documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '';
    $publicRoot = realpath(base_path('public')) ?: '';
    $prefix = $documentRoot === $publicRoot ? '' : rtrim(Config::string('APP_BASE_PATH'), '/') . '/public';

    return $prefix . '/assets/' . ltrim($path, '/');
}

function vite_tags(string $entry): string
{
    $manifestPath = base_path('public/build/.vite/manifest.json');
    if (!file_exists($manifestPath)) {
        return '';
    }

    $manifest = json_decode((string) file_get_contents($manifestPath), true);
    $item = $manifest[$entry] ?? null;
    if (!is_array($item) || empty($item['file'])) {
        return '';
    }

    $tags = '';
    foreach ($item['css'] ?? [] as $css) {
        $tags .= '<link rel="stylesheet" href="/build/' . htmlspecialchars($css) . '">' . PHP_EOL;
    }

    return $tags . '<script type="module" src="/build/' . htmlspecialchars($item['file']) . '"></script>';
}
