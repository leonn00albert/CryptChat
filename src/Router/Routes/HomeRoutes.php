<?php

declare(strict_types=1);

namespace App\Router\Routes;

use App\Controllers\AuthController;
use App\Controllers\HomeController;

final class HomeRoutes
{
    public static function get(string $route): void
    {
        $action = match ($route) {
            'home/index' => HomeController::index(),
            'home/register' => HomeController::register(),
            'home/login' => HomeController::login(),
            'home/logout' => AuthController::logout(),
            default => HomeController::pageNotFound()
        };
        echo $action;
    }
}
