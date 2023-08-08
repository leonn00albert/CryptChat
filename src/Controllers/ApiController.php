<?php
namespace App\Controllers;

use App\Models\User;
use App\Utils\Auth\AuthException;
use App\Utils\Router\JSON;
use Exception;

class ApiController
{

    static public function users()
    {
        try {
            echo json_encode([
                "users" =>  [...User::all()],
            ]);
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, "error", $e->getMessage());
        }
    }

}