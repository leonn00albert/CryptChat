<?php

namespace App\Models;

use PDO;
use App\Utils\DB;

use App\Models\A_Model;
use PDOException;

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