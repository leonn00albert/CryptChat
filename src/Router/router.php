<?php

namespace App\Router;

use App\Controllers\ChatController;
use App\Controllers\HomeController;



class Router
{
    private static array $routes = [];

    public static function add($route, $controllerAction)
    {
        self::$routes[$route] = $controllerAction;
    }

    public static function start()
    {
        $requestUrl = $_SERVER["REQUEST_URI"] ?? '/';
        $matchedRoute = null;
        foreach (self::$routes as $pattern => $action) {
            $pattern = str_replace('/', '\/', $pattern);
            if (preg_match("/^{$pattern}$/", $requestUrl, $matches)) {
                $matchedRoute = $action;
                break;
            }
        }
        if ($matchedRoute) {
            switch ($matchedRoute) {
                case 'home':
                    HomeController::index();
                    break;
                case 'register':
                    HomeController::register();
                    break;
                case 'login':
                    HomeController::login();
                    break;
                case 'chat/index':
                    ChatController::index();
                    break;
                default:
                    echo '404 Not Found';
                    break;
            }
        } else {
            echo '404 Not Found';
        }
    }
}
