<?php
namespace App\Models\Interfaces;

use PDOException;
use App\Models\Message;

interface FindableByConversationId
{
    /**
     * Find messages by conversation ID.
     *
     * @param int $id The ID of the conversation.
     * @return Message[] Returns an array of Message objects representing the messages found.
     * @throws PDOException If there is an error executing the database query.
     */
    static public function findByConversationId(int $id): array;
}