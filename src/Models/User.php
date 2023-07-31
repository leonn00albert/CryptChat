<?php

namespace App\Models;

use PDO;
use App\Utils\DB;
use PDOException;
use PDOStatement;
use App\Models\A_Model;
use App\Utils\Auth\generateKeyPair;

class User extends A_Model
{
    private int $id;
    public string $username;
    public string $password;
    public string $publicKey;
    private string $privateKey = '';

    public function __construct(string $username=null, string $password=null,string $publicKey=null, string $privateKey=null) {
        if(isset($username) && isset($password)) {
            $this->username = $username;
            $this->password = $password;
        }
        if(isset($publicKey) && isset($privateKey)) {
            $this->publicKey = $publicKey;
            $this->privateKey = $privateKey;
        }
    }
    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }
    public function save()
    {
        if (is_null($this->publicKey) || is_null($this->privateKey)) {
            $keypair = generateKeyPair::create();
            $this->publicKey = $keypair["publicKey"];
            $this->privateKey = $keypair["privateKey"];
        }
        $db = DB::getInstance();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (is_null($this->id)) {
            $stmt = $db->prepare("INSERT INTO users (username, password, publicKey, privateKey) 
            VALUES (:username, :password, :publicKey, :privateKey)");
        } else {
            $stmt = $db->prepare("UPDATE users 
                                  SET password = :password, publicKey = :publicKey, privateKey = :privateKey
                                  WHERE username = :username");
        }
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':publicKey', $this->publicKey);
        $stmt->bindParam(':privateKey', $this->privateKey);

        $stmt->execute();
        $db = null;
        return true;
    }

    public static function findByUsername($username)
    {
        try {
            $db = DB::getInstance();
            $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
            $user = $stmt->fetch();
            $db = null;
            return $user;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Get the value of publicKey
     */ 
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Get the value of privateKey
     */ 
    public function getPrivateKey()
    {
        return $this->privateKey;
    }
}
