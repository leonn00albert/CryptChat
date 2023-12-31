<?php

declare(strict_types=1);

namespace App\Router\Routes;

use App\Controllers\ApiController;
use App\Controllers\HomeController;

final class ApiRoutes
{
    public static function get(string $route, array $matches): void
    {
        match ($route) {
            'api/users' => ApiController::users(),
            'api/messages' => ApiController::messages(),
            'api/users/id' => ApiController::userFindById($matches['id']),
            'api/httplogs' => ApiController::httpLogs(),
            'api/devlogs' => ApiController::devLogs(),
            'api/websocketlogs' => ApiController::websocketLogs(),
            default => HomeController::pageNotFound()
        };
    }
}
