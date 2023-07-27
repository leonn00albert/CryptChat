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
    private string $username; 
    private string $password; 
    private string $public_key; 
    private string $private_key; 

    public function __construct($username, $password)
    {
        $keypair = generateKeyPair::create();
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->public_key = $keypair["public_key"];
        $this->private_key = $keypair["private_key"];
    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }
    public function save() {
        try {
            $db = DB::getInstance();
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $db->prepare("INSERT INTO users (username, password, public_key, private_key) 
                                  VALUES (:username, :password, :public_key, :private_key)");
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':public_key', $this->public_key);
            $stmt->bindParam(':private_key', $this->private_key);

            $stmt->execute();
            $db = null;
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

}
