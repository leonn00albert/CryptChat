<?php
namespace App\Controllers;

class HomeController
{
    static public function index()
    {
        require_once(__DIR__ . "/../views/home/index.html");
    }
    static public function login()
    {
        require_once(__DIR__ . "/../views/home/login.html");
    }
    static public function register()
    {
        require_once(__DIR__ . "/../views/home/register.html");
    }
}