<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;

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

    public static function usersEdit($id): string
    {
        return self::renderView('admin/users_edit.html');
    }

    public static function usersDelete($id): void
    {
        User::delete((int) $id);
        header("location: /admin/users");
    }


}
