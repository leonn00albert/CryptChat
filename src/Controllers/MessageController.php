<?php

namespace App\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Utils\Router\PostJSON;
use Exception;

class MessageController
{
    static public function create($data)
    {
        try {
            $sanatized = [
                "conversation_hash" => trim(htmlspecialchars($data["conversation_hash"])),
                "message" => trim(htmlspecialchars($data["message"])),
            ];
            $conversation = Conversation::findByHash($sanatized["conversation_hash"]);
            $message = new Message( $conversation->id, $sanatized["message"], $_SESSION["username"]);
            $message->save();
            echo json_encode([
                "message" => "Created a new message",
                "type" => "success",
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                "message" => "Failed to create message: " . $e->getMessage(),
                "type" => "error",
            ]);
        }
    }

    static public function getMessageByTimestamp($url) {
   

        $parsedUrl = parse_url($url);
        $hash = $parsedUrl['path'];
        parse_str($parsedUrl['query'], $queryParams);


            $conversation = Conversation::findByHash($hash);
            $messages  = Message::findByConversationIdAndTimeStamp($conversation->id,$queryParams["timestamp"]);
            $messages = array_map(function ($message) { 
                if( $message->username === $_SESSION["username"]) {
                    $message->own = true;
                }
                return $message;
            }
            ,$messages);
            echo json_encode([
                "messages" =>  $messages,
            ]);

    
    }   
}
