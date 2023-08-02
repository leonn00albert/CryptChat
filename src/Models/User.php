<?php
namespace App\Models;

use App\Models\Interfaces\FindableByUsername;
use PDO;
use App\Utils\DB;
use PDOException;
use PDOStatement;
use App\Models\A_Model;
use App\Models\Interfaces\Persistable;
use App\Utils\Auth\generateKeyPair;

class User extends A_Model implements FindableByUsername, Persistable
{
    public ?int $id = null;
    public string $username;
    public string $password;
    public ?string $publicKey = null;
    private ?string $privateKey = null;

    public function __construct(string $username = null, string $password = null, string $publicKey = null, string $privateKey = null)
    {
        if (isset($username) && isset($password)) {
            $this->username = $username;
            $this->password = $password;
        }
        if (isset($publicKey) && isset($privateKey)) {
            $this->publicKey = $publicKey;
            $this->privateKey = $privateKey;
        }
    }
    public function verifyPassword(string $password)
    {
        return password_verify($password, $this->password);
    }
    public function save():bool
    {
        if (is_null($this->publicKey) || is_null($this->privateKey)) {
            $keypair = generateKeyPair::create();
            $this->publicKey = $keypair["public_key"];
            $this->privateKey = $keypair["private_key"];
        }
        $db = DB::getInstance();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (is_null($this->id)) {
            $stmt = $db->prepare("INSERT INTO users (username, password, public_key, private_key) 
            VALUES (:username, :password, :publicKey, :privateKey)");
        } else {
            $stmt = $db->prepare("UPDATE users 
                                  SET password = :password, public_key = :publicKey, private_key = :privateKey
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

    public static function findByUsername(string $username): ?User
    {
        try {
            $db = DB::getInstance();
            $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
            $user = $stmt->fetch();
            $db = null;
            return $user ? $user : null;
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
