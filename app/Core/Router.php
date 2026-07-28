<?php

declare(strict_types=1);

namespace App\Core;

use App\Support\Config;
use FastRoute\Dispatcher;

use function FastRoute\simpleDispatcher;

final class Router
{
    public function __construct(private array $routes)
    {
    }

    public function dispatch(): void
    {
        $dispatcher = simpleDispatcher(function ($collector): void {
            foreach ($this->routes as [$method, $path, $handler]) {
                $collector->addRoute($method, $path, $handler);
            }
        });

        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
        $basePath = rtrim(Config::string('APP_BASE_PATH'), '/');

        if ($basePath !== '' && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath)) ?: '/';
        }

        $route = $dispatcher->dispatch($method, $uri);

        if ($route[0] === Dispatcher::NOT_FOUND) {
            http_response_code(404);
            echo '404 - Página no encontrada';
            return;
        }

        if ($route[0] === Dispatcher::METHOD_NOT_ALLOWED) {
            http_response_code(405);
            header('Allow: ' . implode(', ', $route[1]));
            return;
        }

        [$controller, $action] = $route[1];
        $controller->$action($route[2]);
    }
}
