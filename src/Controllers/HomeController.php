<?php

declare(strict_types=1);

namespace App\Controllers;

class HomeController extends A_Controller
{
    public static function index(): string
    {
        return self::renderView('home/index.html');
    }
    public static function login(): string
    {
        return self::renderView('home/login.html');
    }
    public static function register(): string
    {
        return self::renderView('home/register.html');
    }
    public static function pageNotFound(): string
    {
        return self::renderView('home/404.html');
    }
}
