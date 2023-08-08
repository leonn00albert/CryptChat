<?php

declare(strict_types=1);

namespace App\Router;

interface I_Router
{
    /**
     * Register a GET route with the specified controller action.
     *
     * @param string $route            The URL pattern to match.
     * @param string $controllerAction The controller action to be executed.
     */
    public static function get(string $route, string $controllerAction): void;
    /**
     * Register a POST route with the specified controller action.
     *
     * @param string $route            The URL pattern to match.
     * @param string $controllerAction The controller action to be executed.
     */
    public static function post(string $route, string $controllerAction): void;
    /**
     * Start the router and handle incoming requests.
     */
    public static function start(): void;
}
