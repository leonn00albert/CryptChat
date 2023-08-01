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
    public  $user;
    public string $timestamp;
    public string $sent_at;
    private bool $is_read = false;


    
    public function __construct( string $conversationId=null,$messageText=null,$user=null) {
        if(isset($conversationId) && isset($messageText)&& isset($user)) {
            $this->conversationId = $conversationId;
            $this->messageText = $messageText;
            $this->user = $user;
        }
    }
    public function save(): bool
    {
        $db = DB::getInstance();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        if (is_null($this->id)) {
            $stmt = $db->prepare("INSERT INTO messages (conversation_id, message_text, sent_at, is_read, username, timestamp) 
                VALUES (:conversation_id, :message_text, :sent_at, :is_read,:username, :timestamp)");
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
        $time = time();
        $stmt->bindParam(':timestamp', $time);
        $stmt->bindParam(':username', $this->user);
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

    static public function findByConversationIdAndTimestamp($conversationId, $timestamp) {
        try {
            $db = DB::getInstance();
       
            $stmt = $db->prepare("SELECT * FROM messages WHERE conversation_id = :conversation_id AND timestamp > :timestamp ORDER BY sent_at ASC");
            $stmt->bindParam(':conversation_id', $conversationId);
            $stmt->bindParam(':timestamp', $timestamp);
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