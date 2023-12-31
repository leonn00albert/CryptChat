<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Interfaces\FindableByUsername;
use App\Models\Interfaces\Persistable;
use App\Utils\Auth\GenerateKeyPair;
use App\Utils\DB;
use PDO;
use PDOException;

class User extends A_Model implements FindableByUsername, Persistable
{
    public ?int $id = null;
    public string $username;
    public string $password;
    public ?bool $own = null;

    public ?string $publicKey = null;
    public ?string $public_key = null;
    public ?string $private_key = null;
    private ?string $privateKey = null;

    public function __construct(?string $username = null, ?string $password = null, ?string $publicKey = null, ?string $privateKey = null)
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
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public static function removeCurrentUser(array $users): array
    {
        $usersWithoutCurrentUser = array_filter($users, static fn ($user) => $user['username'] !== $_SESSION['username']);
        return array_map(
            static function ($user) {
                return [
                    'username' => $user['username'],
                ];
            },
            $usersWithoutCurrentUser
        );
    }
    public function save(): bool
    {
        if (is_null($this->publicKey) || is_null($this->privateKey)) {
            $keypair = GenerateKeyPair::create();
            $this->publicKey = $keypair['public_key'];
            $this->privateKey = $keypair['private_key'];
        }
        $db = DB::getInstance();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (is_null($this->id)) {
            $stmt = $db->prepare(
                'INSERT INTO users (username, password, public_key, private_key) 
            VALUES (:username, :password, :publicKey, :privateKey)'
            );
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':publicKey', $this->publicKey);
            $stmt->bindParam(':privateKey', $this->privateKey);
        } else {
            $stmt = $db->prepare(
                'UPDATE users SET username = :username WHERE id = :id'
            );
            $stmt->bindParam(':id', $this->id);
        }

        $stmt->bindParam(':username', $this->username);

        $stmt->execute();
        $db = null;
        return true;
    }

    public static function findByUsername(string $username): ?User
    {
        try {
            $db = DB::getInstance();
            $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
            $stmt->execute([':username' => $username]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
            $user = $stmt->fetch();
            $db = null;
            return $user ? $user : null;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
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
