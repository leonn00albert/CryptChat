<?php

namespace App\Controllers;

class HomeController extends A_Controller
{
    static public function index(): string
    {
        return self::renderView("home/index.html");
    }
    static public function login(): string
    {
        return self::renderView("home/login.html");
    }
    static public function register(): string
    {
        return self::renderView("home/register.html");
    }
    static public function pageNotFound(): string
    {
        return self::renderView("home/404.html");

    }
}
