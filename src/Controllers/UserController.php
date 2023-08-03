<?php

namespace App\Controllers;

use App\Models\User;
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
            $user = new User($sanatized["username"], password_hash($sanatized["password"],PASSWORD_BCRYPT));
            $user->save();
            echo json_encode([
                "message" => "Created a new user",
                "type" => "success",
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                "message" => "Failed to create User: " . $e->getMessage(),
                "type" => "error",
            ]);
        }
    }
    static public function read()
    {
        $users = User::all();

        $usersWithoutCurrentUser = array_filter($users,fn($user) => $user["username"] != $_SESSION["username"]);
        $usersWithoutCurrentUser = array_map(function ($user) {
            return [
                "username" => $user["username"]
            ];
        },$usersWithoutCurrentUser);
        echo json_encode([
            "users" =>  [...$usersWithoutCurrentUser] 
          
        ]);
    }
    static public function key($id)
    {
        $user = User::find($id)[0];
      
        echo json_encode([
            "key" =>  $user["private_key"],
        ]);
    }
}
