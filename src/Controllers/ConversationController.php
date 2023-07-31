<?php

namespace App\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Utils\Router\PostJSON;
use Exception;
class ConversationController
{
    static public function create($data)
    {

    }

    static public function key($id)
    {
        $conversation = Conversation::find($id)[0];
      
        echo json_encode([
            "key" =>  json_decode($conversation["sharedKey"],true)["sharedKeyA"],
        ]);
    }
    static public function read()
    {
        $conversation = Conversation::find(5)[0];
        $messages  = Message::findByConversationId($conversation["id"]);
        echo json_encode([
            "messages" =>  $messages,
            "conversation" =>  $conversation,
        ]);
    }
}
