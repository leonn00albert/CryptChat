<?php
namespace App\Controllers;

class AdminController
{
    static public function index()
    {
        require_once(__DIR__ . "/../views/admin/index.html");
    }
    static public function users()
    {
        require_once(__DIR__ . "/../views/admin/users.html");
    }
    static public function logs()
    {
        require_once(__DIR__ . "/../views/admin/logs.html");
    }

}