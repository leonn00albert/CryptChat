<?php
namespace App\Models\Interfaces;
use App\Models\User;
use PDOException;


interface FindableByUsername
{
    /**
     * Find a user by their username.
     *
     * @param string $username The username to search for.
     * @return User|null Returns a User object if a user with the given username is found,
     *                  or null if no user is found.
     * @throws PDOException If there is an error executing the database query.
     */
    public static function findByUsername(string $username): ?User;
}