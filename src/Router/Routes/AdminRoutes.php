<?php

declare(strict_types=1);

namespace App\Router\Routes;

use App\Controllers\AdminController;

final class AdminRoutes
{
    public static function get(string $route): void
    {
        echo match ($route) {
            'admin/index' => AdminController::index(),
            'admin/logs' => AdminController::logs(),
            'admin/users' => AdminController::users(),
        };
    }
}
