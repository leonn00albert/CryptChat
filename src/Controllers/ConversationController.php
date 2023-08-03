<?php

namespace App\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Utils\Auth\Authentication;
use App\Utils\Auth\AuthException;
use App\Utils\Router\JSON;
use Exception;

class ConversationController
{
    static public function create($data)
    {
    }

    static public function key(int $id): void
    {
        try {
            Authentication::checkIfLoggedIn();

            $conversation = Conversation::find($id)[0];
            Authentication::isUserMemberOfConversation($conversation);

            echo json_encode([
                "key" =>  json_decode($conversation["sharedKey"], true)["sharedKeyA"],
            ]);
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, "error", $e->getMessage());
        }
    }
    static public function read(string $hash): void
    {
        try {
            Authentication::checkIfLoggedIn();
            $conversation = Conversation::findByHash($hash);
            Authentication::isUserMemberOfConversation($conversation);

            $messages  = Message::findByConversationId($conversation->id);
            $messages = array_map(
                function ($message) {
                    if ($message->username === $_SESSION["username"]) {
                        $message->own = true;
                    }
                    return $message;
                },
                $messages
            );
            echo json_encode([
                "messages" =>  $messages,
                "conversation" =>  $conversation,
            ]);
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, "error", $e->getMessage());
        }
    }
}
