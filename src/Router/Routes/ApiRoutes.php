<?php

declare(strict_types=1);

namespace App\Router\Routes;

use App\Controllers\ApiController;
use App\Controllers\HomeController;
final class ApiRoutes
{
    public static function get(string $route): void
    {
        match ($route) {
            'api/users' => ApiController::users(),
            'api/messages' => ApiController::messages(),
            default => HomeController::pageNotFound()
        };
      
    }
}
