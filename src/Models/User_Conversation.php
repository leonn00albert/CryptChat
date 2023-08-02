<?php

namespace App\Models;

use App\Models\A_Model;

class User_Conversation extends A_Model {

    public ?int $user_id;
    public ?int $conversation_id;
    
    public function __construct(int $userId = null ,int $coversationId = null)
    {
        if (isset($userId) && isset($coversationId) ) {
            $this->user_id = $userId;
            $this->conversation_id = $coversationId;
    
        }
    }
}