<?php

namespace App\Models;

use App\Models\Interfaces\FindableByConversationId;
use PDO;
use App\Utils\DB;
use PDOException;
use PDOStatement;
use App\Models\A_Model;
use App\Models\Interfaces\Persistable;

class Message extends A_Model implements FindableByConversationId , Persistable
{
    /**
     * @var int|null The ID of the message (nullable for new messages not yet saved to the database).
     */
    public ?int $id = null;

    /**
     * @var string The ID of the conversation that this message belongs to.
     */
    public string $conversationId;

    /**
     * @var string The text content of the message.
     */
    public string $messageText;

    /**
     * @var string The username of the user who sent the message.
     */
    public string $user;

    /**
     * @var string The timestamp of the message in Unix timestamp format (seconds since 1970-01-01 00:00:00).
     */
    public string $timestamp;

    /**
     * @var string The formatted date and time when the message was sent (e.g., "2023-08-01 11:19:10").
     */
    public string $sent_at;

    /**
     * @var bool Whether the message has been read or not (true for read, false for unread).
     *           This property is private as it should be managed internally by the class.
     */
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

    static public function findByConversationId(int $id): array
    {
        try {
            $db = DB::getInstance();
            $stmt = $db->prepare("SELECT * FROM messages WHERE conversation_id = :conversation_id");
            $stmt->bindParam(':conversation_id', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, Message::class);
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