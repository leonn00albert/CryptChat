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
    public string $senderName;
    public string $receiverName;
    public string $messageText;
    private string $sent_at;
    private bool $is_read = false;


    
    public function __construct(string $senderName=null, string $receiverName=null,$messageText ) {
        if(isset($senderName) && isset($receiverName) && isset($messageText)) {
            $this->senderName = $senderName;
            $this->receiverName = $receiverName;
            $this->messageText = $messageText;
        }
    }
    public function save(): bool
    {
        $db = DB::getInstance();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        if (is_null($this->id)) {
            $stmt = $db->prepare("INSERT INTO messages (sender_name, receiver_name, message_text, sent_at, is_read) 
                VALUES (:sender_name, :receiver_name, :message_text, :sent_at, :is_read)");
        } else {
            $stmt = $db->prepare("UPDATE messages 
                                  SET sender_name = :sender_name, receiver_name = :receiver_name,
                                      message_text = :message_text, sent_at = :sent_at, is_read = :is_read
                                  WHERE id = :id");
            $stmt->bindParam(':id', $this->id);
        }
        $date =date('Y-m-d H:i:s');
        $stmt->bindParam(':sender_name', $this->senderName);
        $stmt->bindParam(':receiver_name', $this->receiverName);
        $stmt->bindParam(':message_text', $this->messageText);
        $stmt->bindParam(':sent_at', $date);
        $stmt->bindParam(':is_read', $this->is_read);
    
        $stmt->execute();
        $db = null;
        return true;
    }
}