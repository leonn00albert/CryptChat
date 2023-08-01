<?php

namespace App\Models;

use PDO;
use App\Utils\DB;

use App\Models\A_Model;
use PDOException;

class Conversation extends A_Model
{
    public ?int $id = null;
    public string $senderName;
    public string $receiverName;
    public ?string $hash;
    public $sharedKey;



    public function __construct(?string $hash = null, string $sharedKey = null)
    {
        if (isset($hash) && isset($sharedKey)) {
            $this->hash = $hash;
            $this->sharedKey = $sharedKey;
        }
    }
    public function save(): bool
    {
        $db = DB::getInstance();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (is_null($this->id)) {
            $stmt = $db->prepare("INSERT INTO conversations (hash, sharedKey) 
                VALUES (:hash, :sharedKey)");
        } else {
            $stmt = $db->prepare("UPDATE conversations 
                                  SET hash = :hash,
                                  sharedKey = :sharedKey
                                  WHERE id = :id");
            $stmt->bindParam(':id', $this->id);
        }
        $sharedKeyJson = json_encode($this->sharedKey);
        $stmt->bindParam(':hash', $this->hash);
        $stmt->bindParam(':sharedKey',  $sharedKeyJson ); 
        $stmt->execute();
        $db = null;
        return true;        
    }


    public static function findByHash(string $hashA, string $hashB="") {
        try {
            $db = DB::getInstance();
            $stmt = $db->prepare("SELECT * FROM conversations WHERE hash = :hashA OR hash = :hashB LIMIT 1;");
            $stmt->bindParam(':hashA', $hashA);
            $stmt->bindParam(':hashB', $hashB);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
            $conversation = $stmt->fetch();
            $db = null;
            if($conversation) {
                return $conversation;
            }
            return null;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null; 
        }
    }

    /**
     * Get the value of receiverName
     */
    public function getReceiverName()
    {
        return $this->receiverName;
    }
}
