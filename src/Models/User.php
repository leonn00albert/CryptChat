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

    public function __construct($id, $username, $password)
    {
        $keypair = generateKeyPair::create();
        $this->id = $id;
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->public_key = $keypair["public_key"];
        $this->private_key = $keypair["private_key"];
    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }
    

}
