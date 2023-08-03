<?php

namespace App\Models;

use App\Models\Interfaces\I_Model;
use App\Utils\DB;
use PDO;
use PDOException;

abstract class A_Model implements I_Model
{
    public static function find(int $id): array
    {
        $classname = explode("\\", static::class);
        $db = DB::getInstance();
        try {
            $stmt = $db->prepare("SELECT * FROM " . lcfirst(end($classname)) . "s WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $db = null;
            return $result ?? [];
        } catch (PDOException $e) {
            $_SESSION["alerts"]["message"] = $e->getMessage();
            $db = null;
            return [];
        }
    }

    public static function all(): array
    {
        $classname = explode("\\", static::class);
        $db = DB::getInstance();
        try {
            $stmt = $db->prepare("SELECT * FROM " . lcfirst(end($classname)) . "s");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $db = null;
            return $result ?? [];
        } catch (PDOException $e) {
            $_SESSION["alerts"]["message"] = $e->getMessage();
            $db = null;
            return [];
        }
    }

    public static function create(array $data): void
    {
        $db = DB::getInstance();
        $classname = explode("\\", static::class);
        $table = lcfirst(end($classname)) . "s";
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $db->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value, PDO::PARAM_STR);
        }
        
        if ($stmt->execute()) {
            
        } else {
            throw new PDOException("Something went wrong");
        }
        $db = null;
    }
}
