<?php

declare(strict_types=1);

namespace App\Router;

use App\Controllers\ApiController;
use App\Controllers\AuthController;
use App\Controllers\ChatController;
use App\Controllers\ConversationController;
use App\Controllers\DevController;
use App\Controllers\FileController;
use App\Controllers\HomeController;
use App\Controllers\MessageController;
use App\Controllers\SettingsController;
use App\Controllers\UserController;
use App\Router\Routes\AdminRoutes;
use App\Router\Routes\ApiRoutes;
use App\Router\Routes\ChatRoutes;
use App\Router\Routes\HomeRoutes;
use App\Utils\Router\JSON;

class Router implements I_Router
{
    /**
     * @var array<mixed>
     */
    private static array $routes = [];

    public static function get(string $route, string $controllerAction): void
    {
        self::$routes[$route] = $controllerAction;
    }

    public static function post(string $route, string $controllerAction): void
    {
        self::$routes[$route] = $controllerAction;
    }

    public static function start(): void
    {
        $requestUrl = $_SERVER['REQUEST_URI'] ?? '/';
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
            switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                self::handleGetRequest($matchedRoute, $matches ?? []);
                break;
            case 'POST':
                self::handlePostRequest($matchedRoute, $matches ?? []);
                break;
            default:
                echo 'Invalid request method.';
                break;
            }
        } else {
            echo '404 Not Found';
        }
    }
    /**
     * Handle a GET request and execute the corresponding controller action.
     *
     * @param string        $route   The matched route.
     * @param array<string> $matches The named placeholders in the route pattern.
     */
    private static function handleGetRequest(string $route, array $matches): void
    {
        $split_route = explode('/', $route)[0];

        $action = match ($split_route) {
            'home' => HomeRoutes::get($route),
            'admin' => AdminRoutes::get($route, $matches),
            'api' => ApiRoutes::get($route, $matches),
            'chat' => ChatRoutes::get($route, $matches),
            'settings' => ChatController::settings(),
            'deploy' => DevController::DeployUpdate(),
            'conversations' => ConversationController::read($matches['hash']),
            'users' => UserController::read(),
            'messages' => MessageController::getMessageByTimestamp($matches['hash']),
            'deleteMessage' => MessageController::deleteById($matches['id']),
            default => HomeController::pageNotFound()
        };

        echo $action;
    }
    /**
     * Handle a POST request and execute the corresponding controller action.
     *
     * @param string        $route   The matched route.
     * @param array<string> $matches The named placeholders in the route pattern.
     */
    private static function handlePostRequest(string $route, array $matches): void
    {
        match ($route) {
            'user/create' => UserController::create(JSON::read()),
            'messages/new' => MessageController::create(JSON::read()),
            'auth/login' => AuthController::login(),
            'users/search' => UserController::search(JSON::read()['query']),
            'settings/password' => SettingsController::changePassword(JSON::read()),
            'upload/image' => FileController::profilePicture(),
            'api/users/update' => ApiController::userUpdate($matches['id'], JSON::read()),
            default => HomeController::pageNotFound()
        };
    }
}
