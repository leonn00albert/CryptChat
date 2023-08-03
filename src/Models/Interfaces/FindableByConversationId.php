<?php
namespace App\Models\Interfaces;

use PDOException;
use App\Models\Message;
use App\Models\User;


interface FindableByConversationId
{
    /**
     * Find messages by conversation ID.
     *
     * @param int $id The ID of the conversation.
     * @return Message[] | User[] Returns an array of Message or User objects representing the messages found.
     * @throws PDOException If there is an error executing the database query.
     */
    static public function findByConversationId(int $id): array;
}