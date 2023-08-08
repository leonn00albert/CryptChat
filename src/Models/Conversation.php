<?php

namespace App\Models;

use App\Models\Interfaces\Persistable;
use PDO;
use App\Utils\DB;

use App\Models\A_Model;
use App\Models\Interfaces\FindableByHash;
use PDOException;

class Conversation extends A_Model implements Persistable, FindableByHash
{
    /**
     * @var ?int The unique identifier for the conversation. Null if not yet saved in the database.
     */
    public ?int $id = null;

    /**
     * @var ?string The hash value associated with the conversation.
     */
    public ?string $hash;

     /**
     * The shared key for the conversation.
     *
     * @var string The shared key value.
     */
    public string $sharedKey;
    
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
        $stmt->bindParam(':sharedKey',  $sharedKeyJson);
        $stmt->execute();
        $db = null;
        return true;
    }

    static public function findByHash(string $hashA, string $hashB = null): ?Conversation
    {
        try {
            $db = DB::getInstance();
            $stmt = $db->prepare("SELECT * FROM conversations WHERE hash = :hashA OR hash = :hashB LIMIT 1;");
            $stmt->bindParam(':hashA', $hashA);
            $stmt->bindParam(':hashB', $hashB);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, Conversation::class);
            $conversation = $stmt->fetch();
            $db = null;
            return $conversation ?: null;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
