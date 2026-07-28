<?php

declare(strict_types=1);

use App\Core\Router;
use App\Core\View;
use App\Http\Controllers\PortfolioController;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repositories\PdoProjectRepository;
use App\Infrastructure\Repositories\PdoTechnologyRepository;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/Support/helpers.php';

if (file_exists(__DIR__ . '/.env')) {
    Dotenv::createImmutable(__DIR__)->safeLoad();
}

date_default_timezone_set('America/Lima');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'httponly' => true,
        'secure' => !empty($_SERVER['HTTPS']),
        'samesite' => 'Lax',
    ]);
    session_start();
}

$connection = Connection::create();
$projectRepository = new PdoProjectRepository($connection);
$technologyRepository = new PdoTechnologyRepository($connection);
$portfolioController = new PortfolioController(
    $projectRepository,
    $technologyRepository,
    new View()
);
$routes = require __DIR__ . '/routes/web.php';

return new Router($routes);
