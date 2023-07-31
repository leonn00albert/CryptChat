<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\Router\PostJSON;
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
            $user = new User($sanatized["username"], $sanatized["password"]);
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
        echo json_encode([
            "users" =>  $users 
          
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
