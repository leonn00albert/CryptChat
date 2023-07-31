<?php

namespace App\Models;

use PDO;
use App\Utils\DB;
use PDOException;
use PDOStatement;
use App\Models\A_Model;

class Message extends A_Model
{
    public ?int $id = null; 
    public string $conversationId;
    public string $messageText;
    private string $sent_at;
    private bool $is_read = false;


    
    public function __construct( string $conversationId=null,$messageText=null) {
        if(isset($conversationId) && isset($messageText)) {
            $this->conversationId = $conversationId;
            $this->messageText = $messageText;
        }
    }
    public function save(): bool
    {
        $db = DB::getInstance();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        if (is_null($this->id)) {
            $stmt = $db->prepare("INSERT INTO messages (conversation_id, message_text, sent_at, is_read) 
                VALUES (:conversation_id, :message_text, :sent_at, :is_read)");
        } else {
            $stmt = $db->prepare("UPDATE messages 
                                  SET conversation_id = :conversation_id,
                                      message_text = :message_text, sent_at = :sent_at, is_read = :is_read
                                  WHERE id = :id");
            $stmt->bindParam(':id', $this->id);
        }
        $date =date('Y-m-d H:i:s');
        $stmt->bindParam(':conversation_id', $this->conversationId);
        $stmt->bindParam(':message_text', $this->messageText);
        $stmt->bindParam(':sent_at', $date);
        $stmt->bindParam(':is_read', $this->is_read);
    
        $stmt->execute();
        $db = null;
        return true;
    }

     static public function findByConversationId($id){
        try {
            $db = DB::getInstance();
            $stmt = $db->prepare("SELECT * FROM messages WHERE conversation_id = :conversation_id");
            $stmt->bindParam(':conversation_id', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
            $messages = $stmt->fetchAll();
            $db = null;
            return $messages;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return []; 
        }
    }
}