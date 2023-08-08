<?php

declare(strict_types=1);

namespace App\Controllers;

class AdminController extends A_Controller
{
    public static function index(): string
    {
        return self::renderView('admin/index.html');
    }
    public static function users(): string
    {
        return self::renderView('admin/users.html');
    }
    public static function logs(): string
    {
        return self::renderView('admin/logs.html');
    }
}
