<?php

declare(strict_types=1);

namespace App\Router\Routes;

use App\Controllers\ApiController;

final class ApiRoutes
{
    public static function get(string $route): void
    {
        echo match ($route) {
            'api/users' => ApiController::users(),
            'api/messages' => ApiController::messages(),
        };
    }
}
