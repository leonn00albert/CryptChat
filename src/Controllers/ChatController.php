<?php

namespace App\Controllers;

use App\Models\Conversation;
use App\Models\User;
use App\Models\User_conversation;
use App\Utils\Auth\Authentication;
use App\Utils\Auth\GenerateSharedKey;
use App\Utils\Router\JSON;
use App\Utils\Auth\AuthException;
use Exception;

class ChatController extends A_Controller
{
    static public function index(): string
    {
        return self::renderView("chat/index.html");
    }

    static public function settings(): string
    {
        return self::renderView("chat/settings.html");
    }

    static public function show(): string
    {
         return self::renderView("chat/index.html");
    }

    /**
     * Create a new conversation with a user if it doesn't exist and return the conversation details.
     *
     * @param string $username The username of the user to create a conversation with.
     *
     * @throws AuthException If the user is not logged in.
     */
    static public function new(string $username): void
    {
        try {
            Authentication::checkIfLoggedIn();
            $receiver = User::findByUsername($username);
            $conversationHashA = md5($username . $_SESSION["username"]);
            $conversationHashB = md5($_SESSION["username"] . $username);
            $conversation = Conversation::findByHash($conversationHashA, $conversationHashB);

            if (is_null($conversation)) {

                $conversation = new Conversation();
                $sender = User::findByUsername($_SESSION["username"]);
                $receiver = User::findByUsername($username);
                $conversation->sharedKey = json_encode(GenerateSharedKey::create($sender, $receiver));
                $conversation->hash = $conversationHashA;
                $conversation->save();
                $conversation = Conversation::findByHash($conversationHashA);
                User_conversation::create(["user_id" => $sender->id, "conversation_id" => $conversation->id]);
                User_conversation::create(["user_id" => $receiver->id, "conversation_id" => $conversation->id]);
                echo json_encode(
                    [
                    "hash" => $conversation->hash,
                    "sharedKey" => $conversation->sharedKey
                    ]
                );
            } else {

                echo json_encode(
                    [
                    "hash" => $conversation->hash,
                    "sharedKey" => $conversation->sharedKey
                    ]
                );
            }
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, "error", $e->getMessage());
        }
    }
}
