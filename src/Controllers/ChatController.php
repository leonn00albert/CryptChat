<?php
namespace App\Controllers;

use App\Models\Conversation;
use App\Models\User;
use App\Utils\Auth\GenerateSharedKey;

class ChatController
{
    static public function index()
    {
        require_once(__DIR__ . "/../views/chat/index.html");
    }

    static public function show($id)
    {
        if(count(Conversation::find((int) $id)) == 0) {
            $conversation = new Conversation();
            $conversation->receiverName = trim(htmlspecialchars($_GET["receiverName"]));
            $conversation->senderName = trim(htmlspecialchars($_GET["senderName"]));
            $sender = User::findByUsername($_GET["senderName"]);
            $receiver = User::findByUsername($_GET["senderName"]);
            print_r($receiver->public_key);
            $conversation->sharedKey = GenerateSharedKey::create($sender,$receiver);
            print_r( $conversation->sharedKey);
            $conversation->save();
        } 
            

        require_once(__DIR__ . "/../views/chat/index.html");
    }
}