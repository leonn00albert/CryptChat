<?php

namespace App\Utils\Auth;

use App\Models\User_Conversation;
use AuthException;

class Authentication
{
    /**
     * Checks if the user is logged in and has an active session.
     *
     * @throws AuthException If the user is not logged in.
     */
    static public function checkIfLoggedIn(): void
    {
        if (!isset($_SESSION["username"])) {
            throw new AuthException("Authentication required. Please log in.", 401);
        }
    }

    /**
     * Checks if the current user is a member of the conversation.
     *
     * @param object $conversation The conversation object to check against.
     *
     * @throws AuthException If the user is not a member of the conversation.
     */
    static public function isUserMemberOfConversation($conversation): void
    {
        $usersInConversation = User_Conversation::findByConversationId($conversation->id);

        $inConversation = false;
        foreach ($usersInConversation as $user) {
            if ($user->username === $_SESSION["username"]) {
                $inConversation = true;
                break; 
            }
        }

        if (!$inConversation) {
            throw new AuthException("You are not authorized to send messages in this conversation.", 403);
        }
    }
}
