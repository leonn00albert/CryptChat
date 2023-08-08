<?php

declare(strict_types=1);

namespace App\Router\Routes;

use App\Controllers\ChatController;

final class ChatRoutes
{
    public static function get(string $route, $matches): void
    {
        echo match ($route) {
            'chat/show' => ChatController::show(),
            'chat/index' => ChatController::index(),
            'chat/new' => ChatController::new($matches['username']),
        };
    }
}
