<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Utils\Auth\Authentication;
use App\Utils\Auth\AuthException;
use App\Utils\Router\JSON;
use Exception;

class UserController
{
/**
 * Create a new user.
 *
 * @param array<string> $data The data for creating a user.
 */
    public static function create(array $data): void
    {
        try {
            $sanitized = [
                'username' => trim(htmlspecialchars($data['username'])),
                'password' => trim(htmlspecialchars($data['password'])),
            ];
            $user = new User($sanitized['username'], password_hash($sanitized['password'], PASSWORD_BCRYPT));
            $user->save();
            JSON::response(200, 'success', 'Created a new user');
        } catch (Exception $e) {
            JSON::response(400, 'error', 'Failed to create User: ' . $e->getMessage());
        }
    }

/**
 * Retrieve a list of users (excluding the current user).
 */
    public static function read(): void
    {
        try {
            Authentication::checkIfLoggedIn();
            echo json_encode(
                [
                    'users' => [...User::removeCurrentUser(User::all())],
                ]
            );
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, 'error', $e->getMessage());
        }
    }

/**
 * Retrieve the private key of a user.
 *
 * @param int $id The ID of the user.
 */
    public static function key(int $id): void
    {
        try {
            Authentication::checkIfLoggedIn();
            Authentication::checkIfUser((int) $id);
            $user = User::find($id)[0];

            echo json_encode(
                [
                    'key' => $user['private_key'],
                ]
            );
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, 'error', $e->getMessage());
        }
    }

/**
 * Search for users by username.
 *
 * @param string $query The search query.
 */
    public static function search(string $query): void
    {
        try {
            Authentication::checkIfLoggedIn();
            echo json_encode(
                [
                    'users' => [...User::removeCurrentUser(User::search('username', $query))],
                ]
            );
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, 'error', $e->getMessage());
        }
    }
}
