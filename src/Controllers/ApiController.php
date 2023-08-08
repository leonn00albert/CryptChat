<?php
namespace App\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Utils\Auth\AuthException;
use App\Utils\Router\JSON;
use Exception;

class ApiController
{

    static public function users() :void
    {
        try {
            echo json_encode([
                "users" =>  [...User::all()],
            ]);
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, "error", $e->getMessage());
        }
    }
    static public function messages() :void
    {
        try {
            echo json_encode([
                "messages" =>  [...Message::all()],
            ]);
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, "error", $e->getMessage());
        }
    }
}