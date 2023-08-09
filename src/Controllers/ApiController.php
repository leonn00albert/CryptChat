<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Utils\Auth\AuthException;
use App\Utils\Router\JSON;
use Exception;

class ApiController
{
    /**
     * Get a list of all users.
     */
    public static function users(): void
    {
        try {
            echo json_encode(
                [
                    'users' => [...User::all()],
                ]
            );
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, 'error', $e->getMessage());
        }
    }

    public static function userFindById($id): void
    {
        try {
            echo json_encode(
                User::find((int) $id, "username")
            );
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, 'error', $e->getMessage());
        }
    }

    public static function userUpdate($id, $data): void
    {
        try {
            $username = User::find((int) $id)[0]["username"];
            $user = User::findByUsername($username);
            $user->username = trim(htmlspecialchars($data['username']));
            $user->save();
            echo json_encode(["message" => "success update"]);
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, 'error', $e->getMessage());
        }
    }

    /**
     * Get a list of all messages.
     */
    public static function messages(): void
    {
        try {
            echo json_encode(
                [
                    'messages' => [...Message::all()],
                ]
            );
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, 'error', $e->getMessage());
        }
    }
}
