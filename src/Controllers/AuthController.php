<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\Router\PostJSON;
use Exception;

class AuthController
{
    static public function login() :void
    {
        try {
            $data = PostJSON::read();
            $user = User::findByUsername($data["username"]);
            if($user->verifyPassword($data["password"])) {
                $_SESSION["auth"] = true;
                $_SESSION["user"] = $user;
                $_SESSION["username"] = $data["username"];
                echo json_encode([
                    "message" => "Succesfully logged in",
                    "type" => "success",
                ]);
                exit();
            }
            throw new Exception("Invalid username or password");
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                "message" => "Failed to create User: " . $e->getMessage(),
                "type" => "error",
            ]);
        }
    }
}
