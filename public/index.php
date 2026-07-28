<?php

declare(strict_types=1);

header('Content-Type: text/html; charset=UTF-8');

$router = require dirname(__DIR__) . '/bootstrap.php';
$router->dispatch();
