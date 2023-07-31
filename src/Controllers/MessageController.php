<?php

namespace App\Controllers;

use App\Models\Message;
use App\Utils\Router\PostJSON;
use Exception;

class MessageController
{
    static public function create($data)
    {
        try {
            $sanatized = [
                "conversation_id" => trim(htmlspecialchars($data["conversation_id"])),
                "message" => trim(htmlspecialchars($data["message"])),
            ];
            $message = new Message( $sanatized["conversation_id"], $sanatized["message"], $_SESSION["username"]);
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
}
