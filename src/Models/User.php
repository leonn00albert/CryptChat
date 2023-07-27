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
    private string $public_key;
    private string $private_key;

    public function __construct(string $username=null, string $password=null) {
        if(isset($username) && isset($password)) {
            $this->username = $username;
            $this->password = $password;
        }
    }
    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }
    public function save()
    {
        if (is_null($this->public_key) || is_null($this->private_key)) {
            $keypair = generateKeyPair::create();
            $this->public_key = $keypair["public_key"];
            $this->private_key = $keypair["private_key"];
        }
        $db = DB::getInstance();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (is_null($this->id)) {
            $stmt = $db->prepare("INSERT INTO users (username, password, public_key, private_key) 
            VALUES (:username, :password, :public_key, :private_key)");
        } else {
            $stmt = $db->prepare("UPDATE users 
                                  SET password = :password, public_key = :public_key, private_key = :private_key
                                  WHERE username = :username");
        }
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':public_key', $this->public_key);
        $stmt->bindParam(':private_key', $this->private_key);

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
}
