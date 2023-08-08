<?php

namespace App\Controllers;

class AdminController extends A_Controller
{
    static public function index(): string
    {
        return self::renderView("admin/index.html");
     
    }
    static public function users(): string
    {
        return self::renderView("admin/users.html");
 
    }
    static public function logs(): string
    {
        return self::renderView("admin/logs.html");
    }
}
