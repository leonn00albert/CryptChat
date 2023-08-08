<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\Router\JSON;
use Exception;

class SettingsController
{
    static public function changePassword($data): void
    {
        try {
            $user = User::findByUsername($_SESSION["username"]);
            if ($user->verifyPassword($data["old_password"])) {
                $user->password = $data["new_password"];
                $user->save();
            }else {
                throw new Exception("Invalid username or password");
            }
        } catch (Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, "error","Failed to create new password: " . $e->getMessage() );
        }
    }

}
