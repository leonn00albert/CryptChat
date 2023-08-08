<?php

declare(strict_types=1);

namespace App\Router\Routes;

use App\Controllers\AdminController;
use App\Controllers\HomeController;
final class AdminRoutes
{
    public static function get(string $route): void
    {
        $action = match ($route) {
            'admin/index' => AdminController::index(),
            'admin/logs' => AdminController::logs(),
            'admin/users' => AdminController::users(),
            default => HomeController::pageNotFound()
        };

        echo $action;
    }
}
