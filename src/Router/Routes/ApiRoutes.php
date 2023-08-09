<?php

declare(strict_types=1);

namespace App\Router\Routes;

use App\Controllers\ApiController;
use App\Controllers\HomeController;
use App\Utils\Router\JSON;

final class ApiRoutes
{
    public static function get(string $route, array $matches): void
    {
        match ($route) {
            'api/users' => ApiController::users(),
            'api/messages' => ApiController::messages(),
            'api/users/id' => ApiController::userFindById($matches["id"]),
            default => HomeController::pageNotFound()
        };
      
    }
}
