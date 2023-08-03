<?php

namespace App\Models;

use App\Models\A_Model;
use App\Models\Interfaces\FindableByConversationId;
use App\Utils\DB;
use PDO;
use PDOException;
use App\Models\User;
class User_Conversation extends A_Model implements FindableByConversationId {

    public ?int $user_id;
    public ?int $conversation_id;
    
    public function __construct(int $userId = null ,int $coversationId = null)
    {
        if (isset($userId) && isset($coversationId) ) {
            $this->user_id = $userId;
            $this->conversation_id = $coversationId;
    
        }
    }

    static public function findByConversationId(int $id): array
    {
        try {
            
            $db = DB::getInstance();
            $stmt = $db->prepare("SELECT *, users.username FROM user_conversations INNER JOIN users ON user_conversations.user_id = users.id WHERE conversation_id = :conversation_id");
            $stmt->bindParam(':conversation_id', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
            $users = $stmt->fetchAll();
            $db = null;
            return $users;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}