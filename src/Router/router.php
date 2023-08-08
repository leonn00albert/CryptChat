<?php

namespace App\Router;

use App\Controllers\AdminController;
use App\Controllers\ApiController;
use App\Controllers\AuthController;
use App\Controllers\ChatController;
use App\Controllers\ConversationController;
use App\Controllers\FileController;
use App\Controllers\HomeController;
use App\Controllers\MessageController;
use App\Controllers\SettingsController;
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
                self::handleGetRequest($matchedRoute, $matches ?? []);
            } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
                self::handlePostRequest($matchedRoute, $matches ?? []);
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
    private static function handleGetRequest(string $route, array $matches):void
    {
        $action = match ($route) {
            "home" => HomeController::index(),
            'register' => HomeController::register(),
            "login" => HomeController::login(),
            "logout" => AuthController::logout(),
            "admin/index" => AdminController::index(),
            "admin/logs" => AdminController::logs(),
            "admin/users" => AdminController::users(),
            "settings" => ChatController::settings(),
            "chats/show" => ChatController::show(),
            "chat/index" => ChatController::index(),
            "chat/new" => ChatController::new($matches['username']),
            "get/key" => ConversationController::key(5),
            "api/users" => ApiController::users(),
            "api/messages" => ApiController::messages(),
            "conversations/read" => ConversationController::read($matches['hash']),
            "users" => UserController::read(),
            "users/key" => UserController::key(13),
            "messages/latest" => MessageController::getMessageByTimestamp($matches['hash']),
        
            default => HomeController::pageNotFound()
        };

        echo $action;
    }
    /**
     * Handle a POST request and execute the corresponding controller action.
     *
     * @param string $route The matched route.
     * @param array $matches The named placeholders in the route pattern.
     */
    private static function handlePostRequest(string $route, array $matches)
    {
        match($route) {
            "user/create" =>  UserController::create(JSON::read()),
            'messages/new' => MessageController::create(JSON::read()),
            "auth/login" =>  AuthController::login(),
            "users/search" => UserController::search(JSON::read()["query"]),
            "settings/password" =>  SettingsController::changePassword(JSON::read()),
            "upload/image" => FileController::profilePicture(),
            default => HomeController::pageNotFound()
        };
    }
} 
