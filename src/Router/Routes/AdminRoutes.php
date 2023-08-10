<?php

declare(strict_types=1);

namespace App\Router\Routes;

use App\Controllers\AdminController;
use App\Controllers\HomeController;

final class AdminRoutes
{
    public static function get(string $route, array $matches): void
    {
        $action = match ($route) {
            'admin/index' => AdminController::index(),
            'admin/logs' => AdminController::logs(),
            'admin/users' => AdminController::users(),
            'admin/users/edit' => AdminController::usersEdit($matches['id']),
            'admin/users/delete' => AdminController::usersDelete($matches['id']),
            default => HomeController::pageNotFound()
        };

        echo $action;
    }
}
