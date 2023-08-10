<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\Router\JSON;
use Exception;

class AuthController
{
    static public function login(): void
    {
        try {
            $data = JSON::read();
            $user = User::findByUsername($data["username"]);
            if (isset($user) && $user->verifyPassword($data["password"])) {
                $_SESSION["auth"] = true;
                $_SESSION["user"] = $user;
                $_SESSION["username"] = $data["username"];
                setcookie('username', $data["username"], 0, '/chat');
                echo json_encode(
                    [
                    "message" => "Succesfully logged in",
                    "type" => "success",
                    ]
                );
                exit();
            }
            throw new Exception("Invalid username or password");
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(
                [
                "message" => "Failed to create User: " . $e->getMessage(),
                "type" => "error",
                ]
            );
        }
    }
    static public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = array();
        session_destroy();
        header('Location: /');
        exit;
    }
}
