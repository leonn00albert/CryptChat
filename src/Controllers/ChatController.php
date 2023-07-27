<?php
namespace App\Controllers;

class HomeController
{
    static public function index()
    {
        require_once(__DIR__ . "/../views/chat/index.html");
    }
}