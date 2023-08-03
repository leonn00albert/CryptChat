<?php
namespace App\Models\Interfaces;

use App\Models\Conversation;
use PDOException;

interface FindableByHash
{
 /**
     * Find a conversation by its hash.
     *
     * @param string $hashA The first hash to search for.
     * @param string $hashB (Optional) The second hash to search for. Defaults to an empty string.
     * @return Conversation|null Returns a Conversation object if a conversation with the given hash is found,
     *                          or null if no conversation is found.
     * @throws PDOException If there is an error executing the database query.
     */
    static public function findByHash(string $hashA, string $hashB = null): ?Conversation;
}