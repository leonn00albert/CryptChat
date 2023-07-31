<?php

namespace App\Models;

use PDO;
use App\Utils\DB;

use App\Models\A_Model;

class Conversation extends A_Model
{
    public ?int $id = null;
    public string $senderName;
    public string $receiverName;
    public $sharedKey;



    public function __construct(string $senderName = null, string $receiverName = null, string $sharedKey = null)
    {
        if (isset($senderName) && isset($receiverName) && isset($sharedKey)) {
            $this->senderName = $senderName;
            $this->receiverName = $receiverName;
            $this->sharedKey = $sharedKey;
        }
    }
    public function save(): bool
    {
        $db = DB::getInstance();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (is_null($this->id)) {
            $stmt = $db->prepare("INSERT INTO conversations (senderName, receiverName, sharedKey) 
                VALUES (:senderName, :receiverName, :sharedKey)");
        } else {
            $stmt = $db->prepare("UPDATE conversations 
                                  SET senderName = :senderName, receiverName = :receiverName,
                                  sharedKey = :sharedKey
                                  WHERE id = :id");
            $stmt->bindParam(':id', $this->id);
        }

        $stmt->bindParam(':senderName', $this->senderName);
        $stmt->bindParam(':receiverName', $this->receiverName);
        $stmt->bindParam(':sharedKey', json_encode($this->sharedKey)); // Assuming $this->sharedKey contains the shared key

        $stmt->execute();
        $db = null;
        return true;
    }

    /**
     * Get the value of receiverName
     */
    public function getReceiverName()
    {
        return $this->receiverName;
    }
}
