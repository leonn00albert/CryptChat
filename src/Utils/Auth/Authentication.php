<?php

declare(strict_types=1);

namespace App\Utils\Auth;

use App\Models\User;
use App\Models\User_conversation;

class Authentication
{
    /**
     * Checks if the user is logged in and has an active session.
     *
     * @throws AuthException If the user is not logged in.
     */
    public static function checkIfLoggedIn(): void
    {
        if (! isset($_SESSION['username'])) {
            throw new AuthException('Authentication required. Please log in.', 401);
        }
    }
    /**
     * Check if the current user is the specified user.
     *
     * @param int $id The user ID to compare with the current user.
     *
     * @throws AuthException If the current user is not the specified user.
     */

    public static function checkIfUser(int $id): void
    {
        $user = User::findByUsername($_SESSION['username']);
        if ($user->id !== $id) {
            throw new AuthException('You are not the right user', 401);
        }
    }

    /**
     * Checks if the current user is a member of the conversation.
     *
     * @param object $conversation The conversation object to check against.
     *
     * @throws AuthException If the user is not a member of the conversation.
     */
    public static function isUserMemberOfConversation(object $conversation): void
    {
        $usersInConversation = User_conversation::findByConversationId($conversation->id);

        $inConversation = false;
        foreach ($usersInConversation as $user) {
            if ($user->username === $_SESSION['username']) {
                $inConversation = true;
                break;
            }
        }

        if (! $inConversation) {
            throw new AuthException('You are not part of this conversation', 401);
        }
    }
}
