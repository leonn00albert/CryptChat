<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\Auth\Authentication;
use App\Utils\Auth\AuthException;
use App\Utils\Router\JSON;
use Exception;

class UserController
{
    static public function create($data)
    {
        try {
            $sanatized = [
                "username" => trim(htmlspecialchars($data["username"])),
                "password" => trim(htmlspecialchars($data["password"])),
            ];
            $user = new User($sanatized["username"], password_hash($sanatized["password"], PASSWORD_BCRYPT));
            $user->save();
            JSON::response(200 ,"success","Created a new user");
        } catch (Exception $e) {
            JSON::response(400,"error","Failed to create User: " . $e->getMessage());
        }
    }
    static public function read()
    {
        try {
            Authentication::checkIfLoggedIn();
            echo json_encode([
                "users" =>  [...User::removeCurrentUser(User::all())]

            ]);
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, "error", $e->getMessage());
        }
    }
    static public function key($id)
    {
        try {
            Authentication::checkIfLoggedIn();
            Authentication::checkIfUser((int) $id);
            $user = User::find($id)[0];

            echo json_encode([
                "key" =>  $user["private_key"],
            ]);
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, "error", $e->getMessage());
        }
    }

    static public function search($query)
    {
        try {
            Authentication::checkIfLoggedIn();
            echo json_encode([
                "users" =>  [...User::removeCurrentUser(User::search("username", $query))],
            ]);
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, "error", $e->getMessage());
        }
    }
}
