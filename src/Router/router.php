<?php

namespace App\Router;

use App\Controllers\AuthController;
use App\Controllers\ChatController;
use App\Controllers\ConversationController;
use App\Controllers\HomeController;
use App\Controllers\MessageController;
use App\Controllers\UserController;
use App\Utils\Router\PostJSON;

class Router
{
    private static array $routes = [];

    public static function get($route, $controllerAction)
    {
        self::$routes[$route] = $controllerAction;
    }

    public static function post($route, $controllerAction)
    {
        self::$routes[$route] = $controllerAction;
    }

    public static function start()
    {
        $requestUrl = $_SERVER["REQUEST_URI"] ?? '/';
        $matchedRoute = null;

        foreach (self::$routes as $pattern => $action) {
            // Convert route pattern to a valid regex with placeholders
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

    private static function handleGetRequest($route, $matches)
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
            case 'chat/index':
                ChatController::index();
                break;
            case 'get/key':
                ConversationController::key(5);
                break;
            case 'users':
                UserController::read();
                break;
            case 'conversations/read':
                ConversationController::read($matches['id']);
                break;
            case 'users/key':
                UserController::key(13);
                break;
            case 'chats/show':
                if (isset($matches['id'])) {
                    ChatController::show($matches['id']);
                } else {
                    echo '404 Not Found';
                }
                break;
            case 'message/{messageId}':
                if (isset($matches['messageId'])) {
                    $messageId = $matches['messageId'];
                    MessageController::show($messageId);
                } else {
                    echo '404 Not Found';
                }
                break;
            default:
                echo '404 Not Found';
                break;
        }
    }

    private static function handlePostRequest($route, $matches)
    {
        switch ($route) {
            case 'user/create':
                UserController::create(PostJSON::read());
                break;

            case 'messages/new':
                MessageController::create(PostJSON::read());
                break;
            case 'auth/login':
                AuthController::login();
                break;
            default:
                echo '404 Not Found';
                break;
        }
    }
}
