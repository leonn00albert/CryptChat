<?php

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
        $requestUrl = $_GET['url'] ?? '/';
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
                default:
                    echo '404 Not Found';
                    break;
            }
        } else {
            echo '404 Not Found';
        }
    }
}
