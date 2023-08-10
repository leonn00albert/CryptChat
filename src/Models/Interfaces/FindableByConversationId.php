<?php

declare(strict_types=1);

namespace App\Models\Interfaces;

use App\Models\Message;
use App\Models\User;
use PDOException;

interface FindableByConversationId
{
    /**
     * Find messages by conversation ID.
     *
     * @param int $id The ID of the conversation.
     *
     * @return array<Message>|array<User> Returns an array of Message or User objects representing the messages found.
     *
     * @throws PDOException If there is an error executing the database query.
     */
    public static function findByConversationId(int $id): array;
}
