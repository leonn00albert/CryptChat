<?php

namespace App\Controllers;

use App\Models\Conversation;
use App\Models\User;
use App\Models\User_Conversation;
use App\Utils\Auth\Authentication;
use App\Utils\Auth\GenerateSharedKey;
use App\Utils\Router\JSON;
use AuthException;
use Exception;

class ChatController
{
    static public function index()
    {
        require_once(__DIR__ . "/../views/chat/index.html");
    }

    static public function show()
    {
        require_once(__DIR__ . "/../views/chat/index.html");
    }

    static public function new(string $username):void 
    {
        Authentication::checkIfLoggedIn();
        $receiver = User::findByUsername($username);
        $conversationHashA = md5($username . $_SESSION["username"]);
        $conversationHashB = md5($_SESSION["username"] . $username);
        $conversation = Conversation::findByHash($conversationHashA, $conversationHashB);

        if (is_null($conversation)) {
            try {
                $conversation = new Conversation();
                $sender = User::findByUsername($_SESSION["username"]);
                $receiver = User::findByUsername($username);
                $conversation->sharedKey = json_encode(GenerateSharedKey::create($sender, $receiver));
                $conversation->hash = $conversationHashA;
                $conversation->save();
                $conversation = Conversation::findByHash($conversationHashA);
                User_Conversation::create(["user_id" => $sender->id,"conversation_id" => $conversation->id]); 
                User_Conversation::create(["user_id" => $receiver->id,"conversation_id" => $conversation->id]); 
                echo json_encode([
                    "hash" => $conversation->hash,
                    "sharedKey" => $conversation->sharedKey 
                ]);
            }
            catch (AuthException | Exception $e) {
                JSON::response(JSON::HTTP_BAD_REQUEST, "error", $e->getMessage());
            }
 
        }else {

            echo json_encode([
                "hash" => $conversation->hash,
                "sharedKey" => $conversation->sharedKey
            ]);
        }
    }
}
