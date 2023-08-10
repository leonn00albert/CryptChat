<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Utils\Router\JSON;
use Exception;

class SettingsController
{
    /**
     * Change the user's password.
     *
     * @param array<string> $data The data for changing the password.
     */
    public static function changePassword(array $data): void
    {
        try {
            $user = User::findByUsername($_SESSION['username']);
            if ($user->verifyPassword($data['old_password'])) {
                $user->password = $data['new_password'];
                $user->save();
            } else {
                throw new Exception('Invalid username or password');
            }
        } catch (Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, 'error', 'Failed to create new password: ' . $e->getMessage());
        }
    }
}
