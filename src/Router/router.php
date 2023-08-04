<?php

namespace App\Router;

use App\Controllers\AuthController;
use App\Controllers\ChatController;
use App\Controllers\ConversationController;
use App\Controllers\HomeController;
use App\Controllers\MessageController;
use App\Controllers\UserController;
use App\Utils\Router\JSON;
use App\Router\I_Router;

class Router implements I_Router
{
    private static array $routes = [];

    public static function get(string $route, string $controllerAction)
    {
        self::$routes[$route] = $controllerAction;
    }

    public static function post(string $route, string $controllerAction)
    {
        self::$routes[$route] = $controllerAction;
    }

    public static function start()
    {
        $requestUrl = $_SERVER["REQUEST_URI"] ?? '/';
        $matchedRoute = null;

        foreach (self::$routes as $pattern => $action) {
            $pattern = str_replace('/', '\/', $pattern);
            $pattern = preg_replace('/{(\w+)}/', '(?<$1>[^\/]+)', $pattern);
            if (preg_match("/^{$pattern}$/", $requestUrl, $matches)) {
                $matchedRoute = $action;
                break;
            }
        }

        if ($matchedRoute) {
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                self::handleGetRequest($matchedRoute, $matches);
            } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
                self::handlePostRequest($matchedRoute, $matches);
            } else {
                echo 'Invalid request method.';
            }
        } else {
            echo '404 Not Found';
        }
    }
    /**
     * Handle a GET request and execute the corresponding controller action.
     *
     * @param string $route The matched route.
     * @param array $matches The named placeholders in the route pattern.
     */
    private static function handleGetRequest(string $route, array $matches)
    {
        switch ($route) {
            case 'home':
                HomeController::index();
                break;
            case 'register':
                HomeController::register();
                break;
            case 'login':
                HomeController::login();
                break;
            case 'logout':
                AuthController::logout();
                break;
            case 'chat/index':
                ChatController::index();
                break;
            case 'settings':
                ChatController::settings();
                break;
            case 'chat/new':
                ChatController::new($matches['username']);
                break;
            case 'get/key':
                ConversationController::key(5);
                break;

            case 'users':
                UserController::read();
                break;
            case 'conversations/read':
                ConversationController::read($matches['hash']);
                break;
            case 'users/key':
                UserController::key(13);
                break;
            case 'messages/latest':
                MessageController::getMessageByTimestamp($matches['hash']);
                break;
            case 'chats/show':
                ChatController::show();
                break;

            default:
                echo '404 Not Found';
                break;
        }
    }
    /**
     * Handle a POST request and execute the corresponding controller action.
     *
     * @param string $route The matched route.
     * @param array $matches The named placeholders in the route pattern.
     */
    private static function handlePostRequest(string $route, array $matches)
    {
        switch ($route) {
            case 'user/create':
                UserController::create(JSON::read());
                break;

            case 'messages/new':
                MessageController::create(JSON::read());
                break;
            case 'auth/login':
                AuthController::login();
                break;
            case 'users/search':
                UserController::search(JSON::read()["query"]);
                break;
            default:
                echo '404 Not Found';
                break;
        }
    }
}
